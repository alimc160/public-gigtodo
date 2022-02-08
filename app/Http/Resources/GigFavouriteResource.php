<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class GigFavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'id'=>$this->id,
          'created_at'=>Carbon::parse($this->created_at)->toDateTimeString(),
//            'user'=>new UserResource($this->whenLoaded('user')),
            'gig'=>new GigResource($this->whenLoaded('gig')),
        ];
    }
}
