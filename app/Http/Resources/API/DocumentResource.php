<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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

        return [
          'id' => $this->id,
          'user_id' => $this->user_id,
          'title' => $this->title,
          'author' => $this->author,
          'publisher' => $this->publisher,
          'category' => $this->category,
          'location' => $this->location,
          'status' => $getStatus($this->items_left, $this->borrowers, $this->borrowers_return_status),
          'items_available' => $this->items_available,
          'published_at' => Carbon::parse($this->published_at)->format('d/m/Y'),
          'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
          'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y')
      ];
    }
}
