<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbonentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id'               => $this->id,
            'personal_account' => $this->personal_account,
            'name'             => $this->name,
            'provider_balance' => 10,
            'address'          => $this->address,
            'phone'            => $this->phone,
        ];
    }
}
