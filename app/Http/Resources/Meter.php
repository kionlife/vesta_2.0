<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Abonent;
use App\Models\Service;
use App\Models\User;
use App\Models\Meters;
use function PHPUnit\Framework\isEmpty;


class Meter extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	public function toArray($request)
    {

        $last_counter = Meters::find($this->id)->counters()->orderBy('added_at', 'DESC')->first();


        if (!$last_counter) {
            $last_counter = 0;
        } else {
            $last_counter = $last_counter['value'];
        }

		return [
				'id'         => $this->id,
				'abonent_id' => $this->abonent_id,
				'service_id' => $this->service_id,
				'next_check' => $this->next_check,
				'code' 		 => $this->code,
				'last_counter' 	 => $last_counter,
				'title'		 => $this->title,
				'archived'	 => $this->archived,
			];

    }
}
