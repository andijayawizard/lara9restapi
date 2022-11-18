<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    // public function __construct($resource)
    // {
    //     parent::__construct($resource);
    // }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            // 'id' => $this->id,
            // 'name' => $this->name,
            // 'email' => $this->email,
            // 'phone' => $this->phone,
            // 'pic' => $this->pic,
            // 'address' => $this->address,
            'data' => $this->resource
        ];
    }
}