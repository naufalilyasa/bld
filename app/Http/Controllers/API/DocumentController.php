<?php

namespace App\Http\Controllers\API;

use App\Document as Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreDocumentRequest;
use App\Http\Requests\API\UpdateDocumentRequest;
use App\Http\Requests\API\DestroyDocumentRequest;
use App\Http\Resources\API\DocumentCollection;
use App\Http\Resources\API\DocumentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DocumentController extends Controller
{
    public function index($id = null)
    {
        $user = auth('api')->user();

        if (is_null($id))
        {
            if ($user->hasPermissionTo('read documents', 'api')) {
                $documents = DB::table('documents as d')
                               ->leftJoin('borrowers as b', 'd.id', '=', 'b.document_id')
                               ->select(
                                 DB::raw('d.*, (d.items_available - COUNT(b.document_id)) AS items_left, GROUP_CONCAT(b.borrower_id) AS borrowers, GROUP_CONCAT(b.return_status) AS borrowers_return_status')
                               )
                               ->groupBy('d.id')
                               ->get();

                return new DocumentCollection($documents);
            }
        } else {
            $document = DB::table('documents as d')
                          ->leftJoin('borrowers as b', 'd.id', '=', 'b.document_id')
                          ->select(
                            DB::raw('d.*, (d.items_available - COUNT(b.document_id)) AS items_left, GROUP_CONCAT(b.borrower_id) AS borrowers, GROUP_CONCAT(b.return_status) AS borrowers_return_status')
                          )
                          ->where('d.id', $id)
                          ->groupBy('d.id')
                          ->first();
            if ($user->hasPermissionTo('read a document', 'api')) {
                $doc = new DocumentResource($document);
                $doc = collect($doc);
                return response()->json($doc);
            }
        }

        return [];
    }

    public function store(StoreDocumentRequest $request)
    {
        // Validasi data
        $data = $request->validated();

        // Format tanggal
        $data['published_at'] = new Carbon($data['published_at']);

        // Simpan
        $user = auth('api')->user();
        $document = new Document;
        $document->user_id = $user->id;
        $document->fill($data);
        $document->save();

        return response()->json($document, 201);

    }

    public function update(UpdateDocumentRequest $request, $id)
    {
        // Validasi data
        $data = $request->validated();

        $user = auth('api')->user();
        $document = Document::where('id', $id)->firstOrFail();

        if ($document->user_id !== $user->id)
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $document->update($data);

        return response()->json($document, 200);
    }

    public function destroy(DestroyDocumentRequest $request, $id = null)
    {
        $user = auth('api')->user();

        if (is_null($id))
        {
            $data = $request->validated();

            $ids = explode(',', $data['ids']);

            if (count($ids) == 0) throw new UnprocessableEntityHttpException();

            Document::where('user_id', $user->id)->whereIn('id', $ids)->delete();

            return response('', 204);
        } else {
            $document = Document::where('id', $id)->firstOrFail();

            if ($document->user_id !== $user->id)
            {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $document->delete();

            return response('', 204);
        }
    }
}
