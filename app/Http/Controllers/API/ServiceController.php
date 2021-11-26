<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use App\Models\Balance;
use App\Models\Service;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use App\Models\Inspector2Service;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;

class ServiceController extends BaseController
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
			// $result = Service::whereIn('id', $service_id)->get();
            if ($request->counters) {
                $result = Service::whereHas('provider', function (Builder $query) use ($service_id) {
                    $query->whereIn('id', $service_id);
                })->where('counters', $request->counters)->get();
            } else {
                $result = Service::whereHas('provider', function (Builder $query) use ($service_id) {
                    $query->whereIn('id', $service_id);
                })->get();
            }
		} else {
			$abonent_id = Abonent::where('user_id', $user->id)->first('id')->id;

			$services_ids = Balance::where('abonent_id', $abonent_id)->get('service_id');

			$services = Service::whereIn('id', $services_ids)->get();


			/*
			$services = Service::whereHas('balance', function (Builder $query) use ($service_id) {
				$query->where('service_id', '=', $service_id);
			})->get();
			 */

			$result = response()->json($services);
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
		} else {
			$input['abonent_id'] = Abonent::where('user_id', $user->id)->first()->id;
			$input['service_id'] = $request->service_id;
			$input['author_id'] = $user->id;
			$input['value'] = $request->value;
		}

        $validator = Validator::make($input, [
            'abonent_id' => 'required',
            'service_id' => 'required',
            'author_id'  => 'required',
            'value'      => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $counter = Counter::create($input);

        return $this->sendResponse(new CounterResource($counter), 'Показники додані успішно!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = Auth::user();

        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

        $result = Balance::addSelect(['name' => Service::select('name')
            ->whereColumn('service_id', 'services.id')
            ->where('status', 1)
            ->limit(1)
        ])->where('abonent_id', $id)->whereIn('service_id', $service_id)->where('status', 1)->get('service_id');

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abonent $abonent)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $abonent->name = $input['name'];
        $abonent->detail = $input['detail'];
        $abonent->save();

        return $this->sendResponse(new AbonentResource($abonent), 'Abonent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abonent $abonent)
    {
        $abonent->delete();

        return $this->sendResponse([], 'Abonent deleted successfully.');
    }
}
