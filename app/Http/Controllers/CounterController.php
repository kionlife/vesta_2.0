<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbonentsWithoutCountersResource;
use App\Models\Balance;
use App\Models\Cost;
use App\Models\Tariff;
use App\Models\TariffSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use App\Models\Service;
use App\Models\Meters;
use Illuminate\Support\Facades\Auth;
use App\Models\Inspector2Service;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;
use Illuminate\Database\Eloquent\Builder;


class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = 50;
        $user = Auth::user();
        $result = '';

        if ($request->page) {
            $page = $request->page;
            $offset = $page * $limit;
        } else {
            $offset = 0;
        }

        if (session('alert') == true) {
            $alert = $this->sendResponseMessage('Показник додано.');
            $request->session()->forget('alert');
        } else {
            $alert = '';
        }


        if ($user->hasAnyRole('admin', 'inspector')) {
            $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

            $counters = Counter::orderBy('id', 'desc')->whereIn('service_id', $service_id)->paginate($limit);

        } else {
            $abonent_id = Abonent::where('user_id', $user->id)->first();

            $counters = Counter::where('abonent_id', $abonent_id->id)->orderBy('created_at', 'desc')->offset($offset)->limit($limit)->get();
            $total_count = Counter::where('abonent_id', $abonent_id->id)->get()->count();

            $result = CounterResource::collection($counters)->additional(['total_count' => $total_count, 'success' => true]);
        }

        return view('counters/counters', [
            'alert' => $alert
        ])->with('counters', $counters)->with('user', $user)->with('services', Service::whereIn('id', $service_id)->get());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
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
            'author_id' => 'required',
            'meter_id' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $meter = Meters::find($input['meter_id']);
        $meter_services = Meters::find($input['meter_id'])->services;


        /* if (Counter::whereMonth('created_at', Carbon::now()->month)->where('meter_id', $input['meter_id'])->exists()) {
 //            $result = $this->sendResponse('', 'Показники абонента в поточному місяці для цього лічильника вже були передані');
             $result = $this->sendError('Показники абонента в поточному місяці для цього лічильника вже були передані',$input['meter_id'] . ' error', 200);
         } else {*/

        $last_counter = Counter::where('meter_id', $input['meter_id'])->orderBy('created_at', 'DESC')->first();
        if (!$last_counter) {
            $last_counter = 0;
        } else {
            $last_counter = $last_counter['value'];
        }

        if ($last_counter <= $input['value']) {

            $abonent_services = $abonent->service()->where('status', 1)->with('tariff')->get();

            $s = $abonent_services->map(function ($serv) {
                return $serv['service_id'];
            })->toArray();


            foreach ($meter->services()->where('status', 1)->get() as $service) {


                if (in_array($service['id'], $s)) {
                $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];
                    $tariff = $abonent_services->where('service_id', $service['id'])->first()->tariff;


                $cost = new Cost();
                $cost->abonent_id = $abonent->id;
                $cost->service_id = $service['id'];
                $cost->meter_id = $input['meter_id'];
                $cost->author_id = $input['author_id'];
                $cost->value = ($input['value'] - $last_counter) * $tariff['value'];
                $cost->save();

                $current_balance = Balance::where('abonent_id', $abonent->id)->where('service_id', $service['id'])->first();
                $current_balance->value = $abonent->balanceCalc($service['id'])['value'];
                $current_balance->updated_at = date('Y-m-d');
                $current_balance->save();
            }

            }
            $meter = Meters::where('abonent_id', $input['abonent_id'])->where('id', $input['meter_id'])->update(['counter' => $input['value']]);
            $counter = Counter::create($input);
            $result = redirect('/counters')->with('alert', true);

        } else {
            $result = redirect('/counters')->with('alert', false);
        }
//        }


        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
            $offset = $page * $limit;
        } else {
            $offset = 0;
        }

        $user = Auth::user();

        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');
        $total_count = Counter::where('abonent_id', $id)->whereIn('service_id', $service_id)->count();

        $result = CounterResource::collection(Counter::offset($offset)->limit($limit)->where('abonent_id', $id)->whereIn('service_id', $service_id)->orderBy('created_at', 'DESC')->get())->additional(['total_count' => $total_count, 'success' => true]);

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abonent $abonent)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $abonent->name = $input['name'];
        $abonent->detail = $input['detail'];
        $abonent->save();

        return $this->sendResponse(new AbonentResource($abonent), 'Abonent updated successfully.');
    }

    public function getAbonentsWithoutCounters(Request $request)
    {

        $user = Auth::user();


        if ($request->limit) {
            $limit = $request->limit;
        } else {
            $limit = 1000;
        }

        if ($request->page) {
            $page = $request->page;
            $offset = $page * $limit;
        } else {
            $offset = 0;
        }

        $meters = Meters::whereDoesntHave('counters', function (Builder $query) {
            $query->whereMonth('created_at', Carbon::now()->format('m'));
        })->orderBy('abonent_id', 'ASC')->where('archived', 0)->get();

//        $meters = Meters::whereIn('id', [4836,4837])->get();

        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $lastMonth = Carbon::now()->subMonth()->format('m');
        $lastYearOfMonth = Carbon::now()->subMonth()->format('Y');
        $counters = array();
        $meter_services_ids = array();
        foreach ($meters as $single_meter) {
            $services = array();
            $meter = $single_meter;


            $abonent = Abonent::find($meter->abonent_id);
            if ($abonent['archived'] == 0) {
                $current_counter = $this->getCounter($meter->id, $currentMonth, $currentYear);
                $last_counter = $this->getCounter($meter->id, $lastMonth, $lastYearOfMonth);
                $tariff_total = 0;
                if ($current_counter['value'] == 0) {
                    $abonent_services = $abonent->service()->where('status', 1)->with('tariff')->get();

                    $s = $abonent_services->map(function ($serv) {
                        return $serv['service_id'];
                    })->toArray();
                    foreach ($meter->services()->where('status', 1)->get() as $service) {

                        if (in_array($service['id'], $s)) {
                            $tariff = $abonent_services->where('service_id', $service['id'])->first()->tariff;
                            $tariff_total += $tariff['value'];
                            if ($meter['title'] == 'virtual') {
                                $current_counter['value'] = $last_counter['value'] + $tariff['multiplier'] * $abonent->peoples;
                                $used = $current_counter['value'] - $last_counter['value'];
                            } else {
                                $current_counter['value'] = $last_counter['value'];
                                $used = $current_counter['value'] - $last_counter['value'];
                            }

                            $counter = new Counter();
                            $counter->abonent_id = $meter->abonent_id;
                            $counter->service_id = $service['id'];
                            $counter->meter_id = $meter->id;
                            $counter->author_id = $user->id;
                            $counter->archived = 0;
                            $counter->last_value = $last_counter['value'];
                            $counter->value = $current_counter['value'];
                            $counter->used = $used;
                            $counter->to_pay = $tariff_total * $used;
                            $counters[] = $counter;
                        }
                    }


                }
            }
        }
        return $counters;

    }

    public function getAbonentsWithoutCountersPreview(Request $request)
    {

        $user = Auth::user();

        $counters = $this->getAbonentsWithoutCounters($request);


        return view('counters/empty', [
            'user' => $user,
            'count' => 0,
            'counters' => $counters
        ]);

    }

    public function getCounter($meter, $month, $yearOfMonth)
    {
        $counter = Counter::where('meter_id', $meter)->whereMonth('created_at', $month)->whereYear('created_at', $yearOfMonth)->orderBy('created_at', 'DESC')->first();

        if (!$counter) {
            $counter['id'] = 0;
            $counter['value'] = 0;
        }

        return $counter;
    }

    public function addCounters(Request $request)
    {
        $user = Auth::user();
        $counters = $this->getAbonentsWithoutCounters($request);

        $n = 0;
        foreach ($counters as $single_counter) {
            $single_abonent = Abonent::find($single_counter['abonent_id']);

            $counter = new Counter();
            $counter->abonent_id = $single_abonent->id;
            $counter->service_id = $single_counter['service_id'];
            $counter->meter_id = $single_counter['meter_id'];
            $counter->author_id = $user->id;
            $counter->archived = 0;
            $counter->value = $single_counter['value'];

            $cost = new Cost();
            $cost->abonent_id = $single_abonent->id;
            $cost->author_id = $user->id;
            $cost->meter_id = $single_counter['meter_id'];
            $cost->service_id = $single_counter['service_id'];
            $cost->title = 'Списання';
            $cost->value = $single_counter['to_pay'];
            $cost->save();
            $counter->save();

            echo $single_abonent->name . '<br>';
            $n++;

        }

        return $n;

    }

    public function getCountersByMeter($id)
    {
        $result = Counter::where('meter_id', $id)->get();

        return $result;
    }

    public function getLastCounterByMeter($id)
    {
        $result = Counter::where('meter_id', $id)->orderBy('created_at', 'DESC')->first();

        if (!$result) {
            $result['value'] = 0;
        }

        return $result;
    }
}
