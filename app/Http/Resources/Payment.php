<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Abonent;
use App\Models\Service;
use App\Models\User;


class Payment extends JsonResource
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
		$author = User::find((int)$this->author_id);
		$service = Service::find($this->service_id);

		return [
				'abonent_id' => $abonent->id,
				'abonent_name' => $abonent->name,
				'service' => $service->name,
				'author_name' => $author->name,
				'value' => $this->value,
				'added_at' => $this->created_at,
			];

    }
}
