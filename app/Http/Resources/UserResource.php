<?php

namespace App\Http\Resources;

use App\Models\UserProfileLink;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'=> $this->id,
            'role_id'=>$this->role_id,
            'name'=>$this->name,
            'email'=>$this->email,
            'is_active'=>$this->is_active,
            'image'=>asset($this->image),
            'user_name'=>$this->user_name,
            'created_at'=>Carbon::parse($this->created_at)->toDateTimeString(),
            'links' => UserProfileLinkResource::collection($this->links),
            'role'=> new RoleResource($this->role)
        ];
    }
}
