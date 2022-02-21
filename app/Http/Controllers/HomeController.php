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


        $months = $this->showmonth();

        if ($user->hasAnyRole('admin', 'inspector')) {
            $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

            $t_counters = Counter::whereIn('service_id', $service_id)->whereBetween('created_at', [$start, $end])->count();
            $t_payments = Payment::where('title', 'Оплата')->whereIn('service_id', $service_id)->whereBetween('created_at', [$start, $end])->sum('value');
            $date = [
                'day' => Payment::whereIn('service_id', $service_id)->where('title', 'Оплата')->whereBetween('created_at', [$start, $end])->sum('value'),
                'month' => Payment::whereIn('service_id', $service_id)->where('title', 'Оплата')->whereMonth('created_at', Carbon::today()->month)->get()->sum('value'),
                'year' => Payment::whereIn('service_id', $service_id)->where('title', 'Оплата')->whereYear('created_at', Carbon::today()->year)->get()->sum('value'),
            ];

            $payments_user = Payment::where('title', 'Оплата')->where('author_id', $user->id)->whereIn('service_id', $service_id)->whereBetween('created_at', [$start, $end])->sum('value');
        }

        return view('home', [
            'user'       => $user,
            't_counters' => $t_counters,
            't_payments' => $t_payments,
            'months'     => $months,
            'date'       => $date,
            'payments_user' => $payments_user
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @return array
     */
    public function showmonth()
    {

        $start = Carbon::now()->subMonths(5);
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

        $service_id = Inspector2Service::where('user_id', 5)->get('service_id');

        $services = Service::whereIn('id', $service_id)->get();

        foreach ($months as $month) {

                $arr[] = array(
                    'monthName' => $month['name'],
                    'total_sum' => Payment::where('title', 'Оплата')->whereMonth('created_at', $month['month'])->whereYear('created_at', Carbon::now()->year)->sum('value'),
                );
        }

        return $arr;

    }
}
