<?php

namespace App\Http\Controllers\API;

use App\Document as Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreDocumentRequest;
use App\Http\Requests\API\UpdateDocumentRequest;
use App\Http\Requests\API\DestroyDocumentRequest;
use App\Http\Resources\API\DocumentCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                return new DocumentCollection(Document::paginate());
            }
        } else {
            if ($user->hasPermissionTo('read a document', 'api')) {
                return Document::where('id', $id)->firstOrFail();
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
