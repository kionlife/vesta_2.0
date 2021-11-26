<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AbonentsWithoutCountersResource;
use App\Models\Cost;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use App\Models\Meters;
use Illuminate\Support\Facades\Auth;
use App\Models\Inspector2Service;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;
use Illuminate\Database\Eloquent\Builder;


class CounterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	 public function index(Request $request)
    {
		$limit = 50;
		$user = Auth::user();
		$result = '';

		if ($request->page) {
			$page = $request->page;
			$offset = $page*$limit;
		} else {
			$offset = 0;
		}

		if ($user->hasAnyRole('admin', 'inspector')) {
			$service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

			$counters = Counter::orderBy('id', 'desc')->offset($offset)->limit($limit)->whereIn('service_id', $service_id)->get();
			$total_count = Counter::whereIn('service_id', $service_id)->count();

			$result = CounterResource::collection($counters)->additional(['total_count' => $total_count, 'success' => true]);
		} else {
			//$abonent_id = Abonent::where('user_id', $user->id)->first();
			$abonent_id = Abonent::where('user_id', $user->id)->first();

			$counters = Counter::where('abonent_id', $abonent_id->id)->orderBy('added_at', 'desc')->offset($offset)->limit($limit)->get();
			$total_count = Counter::where('abonent_id', $abonent_id->id)->get()->count();

			$result = CounterResource::collection($counters)->additional(['total_count' => $total_count, 'success' => true]);
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
            $input['author_id'] = $user->id;
            $abonent = Abonent::find($input['abonent_id']);
		} else {
			$input['abonent_id'] = Abonent::where('user_id', $user->id)->first()->id;
			$input['service_id'] = $request->service_id;
			$input['author_id'] = $user->id;
			$input['meter_id'] = $request->meter_id;
			$input['value'] = $request->value;
		}

        $validator = Validator::make($input, [
            'abonent_id' => 'required',
            'service_id' => 'required',
            'author_id'  => 'required',
            'meter_id'   => 'required',
            'value'      => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }



        if (Counter::whereMonth('added_at', Carbon::now()->month)->where('meter_id', $input['meter_id'])->exists()) {
//            $result = $this->sendResponse('', 'Показники абонента в поточному місяці для цього лічильника вже були передані');
            $result = $this->sendError('Показники абонента в поточному місяці для цього лічильника вже були передані',$input['meter_id'] . ' error', 200);
        } else {

            $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $input['service_id'])->first()['value'];
            $last_counter = Counter::where('meter_id', $input['meter_id'])->orderBy('added_at', 'DESC')->first();
            if (!$last_counter) {
                $last_counter = 0;
            } else {
                $last_counter = $last_counter['value'];
            }
            $cost = new Cost();
            $cost->abonent_id = $abonent->id;
            $cost->service_id = $input['service_id'];
            $cost->meter_id = $input['meter_id'];
            $cost->author_id = $input['author_id'];
            $cost->value = ($input['value'] - $last_counter) * $tariff;
            $cost->save();

            $meter = Meters::where('abonent_id', $input['abonent_id'])->where('id', $input['meter_id'])->update(['counter' => $input['value']]);
            $counter = Counter::create($input);
            $result = $this->sendResponse(new CounterResource($counter), 'Показники додані успішно!');

        }


        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        if (is_null($id)) {
            return $this->sendError('Abonent not found.');
        }

		$limit = 10;
		$user = Auth::user();
		$result = '';

		if ($request->page) {
			$page = $request->page;
			$offset = $page*$limit;
		} else {
			$offset = 0;
		}

		$user = Auth::user();

		$service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');
		$total_count = Counter::where('abonent_id', $id)->whereIn('service_id', $service_id)->count();

		$result = CounterResource::collection(Counter::offset($offset)->limit($limit)->where('abonent_id', $id)->whereIn('service_id', $service_id)->orderBy('added_at', 'DESC')->get())->additional(['total_count' => $total_count, 'success' => true]);

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

    public function getAbonentsWithoutCounters(Request $request) {

        $user = Auth::user();


        if ($request->limit){
            $limit = $request->limit;
        } else {
            $limit = 100;
        }

        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }

        $meters_all = Meters::whereDoesntHave('counters', function (Builder $query) {
            $query->whereMonth('added_at', Carbon::now()->format('m'));
        })->orderBy('abonent_id', 'ASC')->get();

        $meters = Meters::offset($offset)->limit($limit)->whereDoesntHave('counters', function (Builder $query) {
            $query->whereMonth('added_at', Carbon::now()->format('m'));
        })->orderBy('abonent_id', 'ASC')->get();





        return $this->sendResponseCustom(new AbonentsWithoutCountersResource($meters), $limit, $meters_all->count(), 'Abonent updated successfully.');

    }

    public function getCounter($meter, $month, $yearOfMonth) {
        $counter = Counter::where('meter_id', $meter)->whereMonth('added_at', $month)->whereYear('added_at', $yearOfMonth)->orderBy('added_at', 'DESC')->first();

        if (!$counter) {
            $counter['id'] = 0;
            $counter['value'] = 0;
        }

        return $counter;
    }

    public function addCounters(Request $request) {
//        $meters = $request->meters;
        $meters = Meters::whereDoesntHave('counters', function (Builder $query) {
            $query->whereMonth('added_at', Carbon::now()->format('m'));
        })->where('archived', 0)->orderBy('abonent_id', 'ASC')->get();

        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $lastMonth = Carbon::now()->subMonth()->format('m');
        $lastYearOfMonth = Carbon::now()->subMonth()->format('Y');

        foreach ($meters as $single_meter) {
            $services = array();
            $meter = $single_meter;

            $abonent = Abonent::find($meter->abonent_id);
            $current_counter = $this->getCounter($meter->id, $currentMonth, $currentYear);

            $last_counter = $this->getCounter($meter->id, $lastMonth, $lastYearOfMonth);
            if($current_counter['value'] == 0) {
                foreach ($meter->services as $service) {
                    $services[] = $service['id'];
                }


                if ($meter['title'] == 'virtual') {
                    if (in_array(1, $services)) {
                        $current_counter['value'] = $last_counter['value'] + 4 * $abonent->peoples;
                    } else {
                        $current_counter['value'] = $last_counter['value'] + $abonent->peoples;
                    }
                } else {
                    $current_counter['value'] = $last_counter['value'];
                }


                $counter = new Counter();
                $counter->abonent_id = $meter->abonent_id;
                $counter->service_id = $services[0];
                $counter->meter_id = $meter->id;
                $counter->author_id = 0;
                $counter->archived = 0;
                $counter->value = $current_counter['value'];
                $counter->save();
            }
        }
    }

    public function getCountersByMeter($id) {
        $result = Counter::where('meter_id', $id)->get();

        return $result;
    }

    public function getLastCounterByMeter($id) {
        $result = Counter::where('meter_id', $id)->orderBy('added_at', 'DESC')->first();

        if (!$result) {
            $result['value'] = 0;
        }

        return $result;
    }
}
