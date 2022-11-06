<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'point' => $this->point,
            'image_path' => $this->image_path,
            'shop' => ShopResource::collection($this->whenLoaded('shops')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
