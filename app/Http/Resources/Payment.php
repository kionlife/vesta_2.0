<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Abonent;
use App\Models\Service;
use App\Models\User;
use App\Models\Source_of_income;


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
        $source = Source_of_income::find($this->source_id);

		return [
				'abonent_id' => $abonent->id,
                'source' => $source->name,
				'abonent' => $abonent->name,
				'service' => $service->name,
				'author' => $author->name,
				'value' => $this->value,
			];

    }
}
