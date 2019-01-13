<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'phone' => $this->phone,
            'wechat' => $this->wechat,
            'is_admin' => $this->is_admin,
            'item_ids' => $this->items->pluck('id'),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
