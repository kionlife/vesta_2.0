<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Provider;


class Service extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	public function toArray($request)
    {
		$provider = Provider::where('id', $this->provider_id)->first('title')->title;
		return [
				'id' 		 => $this->id,
				'name' 		 => $this->name,
				'provider'   => $provider,
			];

    }
}
