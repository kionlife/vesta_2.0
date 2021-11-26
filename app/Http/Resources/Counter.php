<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Abonent;
use App\Models\Service;
use App\Models\User;
use App\Models\Meters;


class Counter extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	public function toArray($request)
    {
		$abonent_id = $this->abonent_id;
		$abonent = Abonent::find($abonent_id);
		$author = User::find($this->author_id);
		$meter = Meters::find($this->meter_id);
		if (!$meter) {
            $meter['title'] = 'невідомо';
        }
		$service = Service::find($this->service_id);

		return [
				'abonent_id' => $abonent->id,
				'abonent_name' => $abonent->name,
				'service' => $service->name,
				'meter' => $meter['title'],
				'author_name' => $author->name,
				'value' => $this->value,
				'added_at' => $this->added_at,
			];

    }
}
