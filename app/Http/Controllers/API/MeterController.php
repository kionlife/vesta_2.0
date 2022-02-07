<?php

namespace App\Http\Controllers\API;

use App\Models\Service2Meter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use App\Models\Balance;
use App\Models\Service;
use App\Models\Meters;
use Illuminate\Support\Facades\Auth;
use App\Models\Inspector2Service;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\Meter as MeterResource;

class MeterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	 public function index(Request $request)
    {
		$user = Auth::user();

		if ($user->hasAnyRole('admin', 'inspector')) {
			$service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

			$result = Meters::whereIn('service_id', $service_id)->where('abonent_id', $request->abonent_id)->get();
		} else {
			$abonent_id = Abonent::where('user_id', $user->id)->first('id')->id;

			$meters = Meters::where('service_id', $request->service_id)->where('abonent_id', $request->abonent_id)->get();

			$result = response()->json($meters);
		}

        return $result;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$user = Auth::user();
		if ($user->hasAnyRole('admin', 'inspector')) {
			$input = $request->all();
		}

        $validator = Validator::make($input, [
            'abonent_id' => 'required',
            'next_check' => 'required',
            'code'       => 'required',
            'counter'    => 'required',
            'title'      => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $services = $input['service'];
        $meter = new Meters();
        $meter->title = $input['title'];
        $meter->abonent_id = $input['abonent_id'];
        $meter->code = $input['code'];
        $meter->code_plomb = $input['code_plomb'];
        $meter->counter = $input['counter'];
        $meter->next_check = $input['next_check'];
        $meter->last_check = $input['last_check'];
        $meter->save();

        $data = array();
        foreach ($services as $service) {
            $data['abonent_id'] = $input['abonent_id'];
            $data['service_id'] = $service['service_id'];
            $data['meter_id'] = $meter->id;
            Service2Meter::create($data);
        }

        return $this->sendResponse(new MeterResource($meter), 'Лічильник доданий успішно!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($id, Request $request)
    {

		$user = Auth::user();

        if (is_null($id)) {
            return $this->sendError('Meter not found.');
        }

		$service_id = Inspector2Service::where('user_id', $user->id)->where('service_id', $request->service_id)->get('service_id');

        $meters = Meters::where('abonent_id', $id)->where('archived', 0)->whereHas('services', function ($query) use ($request) {
            $query->where('services.id', $request->service_id)->where('archived', 0);
        })->with(array('counters' => function($query) {
            $query->orderBy('created_at', 'DESC')->limit(1);
        }))->get();

        return $meters;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meters $meter)
    {
        $user = Auth::user();
		if ($user->hasAnyRole('admin', 'inspector')) {
			$input = $request->all();
		}

/*        $validator = Validator::make($input, [
            'title'      => 'required',
            'abonent_id' => 'required',
            'service' => 'required',
            'next_check' => 'required',
            'code'       => 'required',
            'counter'    => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }*/

        $meter->title = $input['title'];
        $meter->code = $input['code'];
        $meter->code_plomb = $input['code_plomb'];
        $meter->counter = $input['counter'];
        $meter->next_check = $input['next_check'];
        $meter->last_check = $input['last_check'];

        Service2Meter::where('meter_id', $meter->id)->where('abonent_id', $meter->abonent_id)->delete();

        foreach ($input['service'] as $service) {

            $data['abonent_id'] = $meter->abonent_id;
            $data['service_id'] = $service;
            $data['meter_id'] = $meter->id;
            Service2Meter::create($data);
        }

        $meter->save();

        return $this->sendResponse(new MeterResource($meter), 'Дані  лічильника оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meters $meter)
    {
        $meter->archived = 1;
        $meter->save();
        Service2Meter::where('meter_id', $meter->id)->update(['archived' => 1]);
        Counter::where('meter_id', $meter->id)->update(['archived' => 1]);

        return $this->sendResponse([], 'Лічильник видалено!');
    }
}
