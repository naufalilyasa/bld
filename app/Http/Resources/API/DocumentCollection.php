<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth('api')->user();

        $getStatus = function ($itemsLeft, $borrowers, $borrowersReturnStatus) use ($user) {
          $borrowerIds = explode(',', $borrowers);
          $borrowerReturnStatus = explode(',', $borrowersReturnStatus);
          $borrowerIdWithReturnStatus = array_combine($borrowerIds, $borrowerReturnStatus);

          if (in_array($user->id, $borrowerIds))
          {
            if ($borrowerIdWithReturnStatus[$user->id] === '1')
            {
              return 'Menunggu konfirmasi';
            }

            return 'Sedang Anda pinjam';
          }

          if ($itemsLeft == 0)
          {
            return 'Kosong';
          }

          return 'Tersedia';
        };

        $transform = fn ($collection) => [
            'id' => $collection->id,
            'user_id' => $collection->user_id,
            'title' => $collection->title,
            'author' => $collection->author,
            'publisher' => $collection->publisher,
            'category' => $collection->category,
            'location' => $collection->location,
            'status' => $getStatus($collection->items_left, $collection->borrowers, $collection->borrowers_return_status),
            'published_at' => Carbon::parse($collection->published_at)->format('d/m/Y'),
            'created_at' => Carbon::parse($collection->created_at)->format('d/m/Y'),
            'updated_at' => Carbon::parse($collection->updated_at)->format('d/m/Y')
        ];

        return [
            'data' => $this->collection->map($transform),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
