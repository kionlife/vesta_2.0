<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Balance;
use App\Models\Service;
use App\Models\Meters;
use App\Models\Inspector2Service;

class Abonent extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	public function toArray($request)
    {
		$user = Auth::user();

		//$meter = Meters::where('abonent_id', $this->id)->where('service_id', $service_id['service_id'])->get();
        if (isset($this->type[0])) {
            $type = array('id' => $this->type[0]->id, 'title' => $this->type[0]->title);
        } else {
            $type = array('id' => 0, 'title' => 'невідомо');
        }

        return [
            'id'                => $this->id,
            'personal_account'  => $this->personal_account,
            'name' 		        => $this->name,
			'address' 	        => $this->address,
			'city'   	        => array('id' => $this->city->id, 'name' => $this->city->name),
			'phone' 	        => $this->phone,
			'peoples'	        => $this->peoples,
			'status'	        => $this->status,
			'archived'	        => $this->archived,
			'services'	        => $this->services,
            'contracts'         => $this->contracts,
			'meters'            => $this->meters,
			'type'              => $type,
        ];
    }
}
