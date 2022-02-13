<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Carbon\Traits\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AbonentsWithoutCountersResource;
use App\Models\Cost;
use App\Models\Tariff;
use Carbon\Carbon;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use App\Models\Service;
use App\Models\Meters;
use App\Models\Inspector2Service;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\Report as ReportResource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Payment;
use App\Models\Balance;

class DebugController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();

        $start = Carbon::today();
        $start->startOfDay();
        $end = Carbon::today();
        $end->endOfDay();


        $months = $this->showmonth();


        if ($user->hasAnyRole('admin', 'inspector')) {
            $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

            $t_counters = Counter::whereIn('service_id', $service_id)->whereBetween('created_at', [$start, $end])->count();
            $t_payments = Payment::whereIn('service_id', $service_id)->whereBetween('created_at', [$start, $end])->sum('value');

        } else {
            //$abonent_id = Abonent::where('user_id', $user->id)->first();
            $abonent_id = Abonent::where('user_id', $user->id)->first();

            $t_counters = Counter::where('abonent_id', $abonent_id->id)->whereBetween('created_at', [$start, $end])->get()->count();
            $t_payments = Counter::where('abonent_id', $abonent_id->id)->whereBetween('created_at', [$start, $end])->get()->count()->sum('value');

        }

        return view('home', [
            'user' => $user
        ])->with('t_counters', $t_counters)->with('t_payments', $t_payments)->with('months', $months);
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
            $query->whereMonth('created_at', '12');
        })->orderBy('abonent_id', 'ASC')->where('archived', 0)->where('title', 'virtual')->get();

/*        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $lastMonth = Carbon::now()->subMonth()->format('m');
        $lastYearOfMonth = Carbon::now()->subMonth()->format('Y');*/

        $currentMonth = '01';
        $currentYear = '2022';
        $lastMonth = '12';
        $lastYearOfMonth = '2021';
        $counters = array();
        $meter_services_ids = array();
        foreach ($meters as $single_meter) {
            $services = array();
            $meter = $single_meter;


            $abonent = Abonent::find($meter->abonent_id);
            $current_counter = $this->getCounter($meter->id, $currentMonth, $currentYear);
            $last_counter = $this->getCounter($meter->id, $lastMonth, $lastYearOfMonth);
            $tariff_total = 0;
            if ($current_counter['value'] == 0) {

                $abonent_services = $abonent->service()->where('status', 1)->with('tariff')->get();

                $s = $abonent_services->map(function ($serv) {
                    return $serv['service_id'];
                })->toArray();

                foreach ($meter->services as $service) {

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
                        $counter->service_id = 0;
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


            echo $single_abonent->name . '<br>';
            $n++;

        }

        return $n;

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function balancesMigrate() {
        $abonents = Abonent::all();

        foreach ($abonents as $single_abonent) {
            $abonent = Abonent::find($single_abonent['id']);
            $balances = $abonent->balanceDebug;
            foreach ($balances as $balance) {
                $correct_balance = $abonent->balanceCalc($balance['service_id']);
                Balance::find($balance['id'])->update([
                    'value' => $correct_balance['value']
                ]);
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function costGenerateByServiceId(Request $request) {


            $abonents = Abonent::whereHas('balance', function (Builder $query) {
                $query->where('status', '=', 1)->where('service_id', 1);
            })->get();

            foreach ($abonents as $single_abonent) {
                $abonent = Abonent::find($single_abonent['id']);
                $meters = $abonent->meter()->where('title', 'virtual')->where('archived', 0)->get();

                foreach ($meters as $meter) {
                    if ($meters->services)
                    if (!empty($cost_existed)) {
                        $cost = new Cost();
                        $cost->abonent_id = $abonent->id;
                        $cost->author_id = 2517;
                        $cost->meter_id = $meter['id'];
                        $cost->service_id = 3;
                        $cost->title = 'Списання';
                        $cost->value = ($cost_existed['value'] / 14) * 11.20;
                        $cost->save();
                    }
                }
            }

    }




    public function makeBallanceNullable () {
        $service_id = 2;

        $abonents = Abonent::whereHas('balance', function (Builder $query) use ($service_id) {
            $query->where('service_id', $service_id)->where('status', 1);
        })->where('archived', 0)->get();
        $payments = array();
        foreach ($abonents as $abonent) {
            $balance = $abonent->balanceCalc(2);

            if ($balance['value'] < 0) {
                $payment = new Payment();
                $payment->abonent_id = $abonent['id'];
                $payment->service_id = $service_id;
                $payment->author_id = 5555;
                $payment->title = 'Корекція';
                $payment->source_id = 1;
                $payment->value = abs($balance['value']);
                $payment->archived = 0;
                $payment->save();
                $payments[] = $payment;
            }
        }
        return $payments;
    }



    public function generateCosts() {

        $counters = Counter::whereHas('meter', function (Builder $query) {
            $query->where('title', '!=', 'virtual')->where('archived', 0);
        })->get();


        $abonents = Abonent::orderBy('personal_account', 'ASC')->where('archived', 0)->get();

        foreach ($abonents as $abonent) {

            $services = Service::whereHas('balance', function (Builder $query) use ($abonent) {
                $query->where('abonent_id', '=', $abonent['id'])->where('status', 1);
            })->get();



            /* Отримуємо дані по послугах */
            foreach ($services as $service) {
                if ($service['id'] != 2) {

                    $meters = Meters::whereHas('services', function (Builder $query) use ($abonent, $service) {
                        $query->where('abonent_id', '=', $abonent['id'])->where('service_id', $service['id'])->where('status', 1);
                    })->where('archived', 0)->where('title', 'virtual')->where('abonent_id', '=', $abonent['id'])->get();

                    /* Перебираємо лічильники */
                    foreach ($meters as $meter) {

                        $abonent = Abonent::find($meter['abonent_id']);
                        $tariff = Tariff::find($abonent->balance()->where('service_id', $service['id'])->where('status', 1)->first()['tariff_id']);

                        $cost = new Cost();
                        $cost->abonent_id = $meter['abonent_id'];
                        $cost->author_id = 5555;
                        $cost->service_id = $service['id'];
                        $cost->meter_id = $meter['id'];
                        $cost->value = abs(($abonent['peoples'] * $tariff['multiplier']) * $tariff['value']);
                        $cost->save();
                        $result[] = $cost;

                    }
                }
            }
        }

        return $result;
    }
}
