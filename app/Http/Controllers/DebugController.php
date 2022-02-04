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
use App\Http\Controllers\ReportController;
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
                $query->where('status', '=', 1)->where('service_id', 3);
            })->get();

            foreach ($abonents as $single_abonent) {
                $abonent = Abonent::find($single_abonent['id']);
                $meters = $abonent->meter()->where('title', '!=', 'virtual')->where('archived', 0)->get();
                foreach ($meters as $meter) {
                    $cost_existed = Cost::where('meter_id', $meter['id'])->where('service_id', 1)->whereMonth('created_at', '1')->first();
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
}
