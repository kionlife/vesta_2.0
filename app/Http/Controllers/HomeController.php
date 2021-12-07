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
use App\Http\Controllers\API\BaseController as BaseController;
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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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


        $months=$this->showmonth();



        if ($user->hasAnyRole('admin', 'inspector')) {
            $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

            $t_counters = Counter::whereIn('service_id', $service_id)->whereBetween('added_at', [$start, $end])->count();
            $t_payments = Payment::whereBetween('created_at', [$start, $end])->sum('value');

        } else {
            //$abonent_id = Abonent::where('user_id', $user->id)->first();
            $abonent_id = Abonent::where('user_id', $user->id)->first();

            $t_counters = Counter::where('abonent_id', $abonent_id->id)->whereBetween('added_at', [$start, $end])->get()->count();
            $t_payments = Counter::where('abonent_id', $abonent_id->id)->whereBetween('created_at', [$start, $end])->get()->count()->sum('value');

        }

        return view('home', [
            'user' => $user
        ])->with('t_counters', $t_counters)->with('t_payments', $t_payments)->with('months', $months);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showmonth()
    {

        $start = Carbon::now()->subMonths(6);
        $start->startOfMonth();
        $end = Carbon::today();
        $end->endOfDay();


        $period = CarbonPeriod::create($start, $end)->month();
        $months = collect($period)->map(function (Carbon $date) {
            return [
                'month' => $date->month,
                'name' => $date->monthName,
            ];
        })->toArray();

        $services = Service::all();

        foreach ($services as $service) {
            foreach ($months as $month) {


                $obj = Service::find($service['id']);


                $arr[] = array(
                    'service_id' => $service['id'],
                    'name' => $service['name'],
                    'monthName' => $month['name'],
                    'provider_id' => $service['provider_id'],
                    'total_sum' => $obj->payment()->whereMonth('created_at',$month['month'])->whereYear('created_at',Carbon::now()->year)->sum('value'),
                );

            }
        }

        return $arr;

    }
}
