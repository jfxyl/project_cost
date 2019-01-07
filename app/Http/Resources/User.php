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
            'wechat' => $this->wechat,
            'is_admin' => $this->is_admin,
            'supply_cate_ids' => $this->supplyCates->pluck('id'),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
