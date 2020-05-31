<?php

namespace App\Http\Controllers\API;

use App\Borrower;
use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\BorrowsConfirmsRequest;
use App\Http\Requests\API\BorrowsRequest;
use App\Http\Requests\API\BorrowsReturnsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BorrowController extends Controller
{
    //
    public function borrows(BorrowsRequest $request, $id = null)
    {
        $user = auth('api')->user();

        if (is_null($id))
        {
            $data = $request->validated();

            $ids = explode(',', $data['ids']);

            if (count($ids) == 0) throw new UnprocessableEntityHttpException();

            $borrowedListIds = DB::transaction(function () use ($user, $ids) {
                // Mengecek apakah id yang diberikan semuanya dalam keadaan available
                $availableDocuments = Document::whereIn('id', $ids)->where('items_available', '>', 0)->get();

                // Buat datanya
                $borrowedList = $availableDocuments->map(function ($document) use ($user) {
                    return [
                        'document_id' => $document->id,
                        'borrower_id' => $user->id,
                        'owner_id' => $document->user_id,
                        'is_borrowed' => true,
                        'return_status' => 0
                    ];
                })->toArray();

                $borrowedListIds = [];

                // Insert datanya
                foreach ($borrowedList as $borrow) {
                    Borrower::updateOrCreate($borrow);
                    $borrowedListIds[] = $borrow['document_id'];
                }

                return implode(',', $borrowedListIds);
            });

            return response()->json(['message' => "Successfully borrowed all documents. Ids: {$borrowedListIds}"], 200);
        } else {
            // Mengecek apakah available
            $document = Document::find($id)->where('items_available', '>', 0)->firstOrFail();

            // UPDATE atau buat datanya
            Borrower::updateOrCreate([
                'document_id' => $document->id,
                'borrower_id' => $user->id,
                'owner_id' => $document->user_id,
                'is_borrowed' => true
            ]);

            return response()->json(['message' => "Successfully borrowed the document. Id: {$id}"]);
        }
    }

    public function returns(BorrowsReturnsRequest $request, $id = null)
    {
        $user = auth('api')->user();

        if (is_null($id))
        {
            $data = $request->validated();

            $ids = explode(',', $data['ids']);

            if (count($ids) == 0) throw new UnprocessableEntityHttpException();

            $borrowedList = Borrower::where('borrower_id', $user->id)->whereIn('document_id', $ids);

            if (!$borrowedList) return response()->json(['message' => 'Document not found'], 404);

            $borrowedList->update(['is_borrowed' => false, 'return_status' => 1]);

            $returnedIds = $borrowedList->get()->map(function ($borrow) {
                return $borrow->document_id;
            })->toArray();
            $returnedIds = implode(',', $returnedIds);

            return response()->json(['message' => "Successfully returned all documents. Ids: {$returnedIds}"], 200);

        } else {
            $borrowedDoc = Borrower::where('document_id', $id)->where('borrower_id', $user->id)->firstOrFail();

            $borrowedDoc->update(['is_borrowed' => false, 'return_status' => 1 ]);

            return response()->json(['message' => "Successfully returned the document. Id: {$id}"], 200);
        }
    }

    public function confirms(BorrowsConfirmsRequest $request, $id = null)
    {
        $user = auth('api')->user();

        if (is_null($id))
        {
            $data = $request->validated();

            $ids = explode(',', $data['ids']);

            if (count($ids) == 0) throw new UnprocessableEntityHttpException();

            $borrowedList = Borrower::where('owner_id', $user->id)->whereIn('document_id', $ids);

            if (!$borrowedList) return response()->json(['message' => 'Document not found'], 404);

            $borrowedList->update(['return_status' => 2]);

            $returnedIds = $borrowedList->get()->map(function ($borrow) {
                return $borrow->document_id;
            })->toArray();
            $returnedIds = implode(',', $returnedIds);

            return response()->json(['message' => "Successfully returned all documents. Ids: {$returnedIds}"], 200);
        } else {
            $borrowedDoc = Borrower::where('owner_id', $user->id)->where('document_id', $id)->firstOrFail();

            $borrowedDoc->update(['return_status' => 2]);

            return response()->json(['message' => "Succesfully confirmed the document. Id: {$id}"], 200);
        }
    }
}
