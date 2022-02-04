<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Meter;
use App\Models\Abonent;
use App\Models\Cost;
use App\Models\Counter;
use App\Models\Meters;
use App\Models\Service;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Controllers\API\BaseController as BaseController;


class CostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function getCounter($meter, $month, $yearOfMonth) {
        $counter = Counter::where('meter_id', $meter)->whereMonth('created_at', $month)->whereYear('created_at', $yearOfMonth)->first();

        if (!$counter) {
            $counter['id'] = 0;
            $counter['value'] = 0;
        }

        return $counter;
    }

    public function generate() {

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

                $meters = Meters::whereHas('services', function (Builder $query) use ($abonent, $service) {
                    $query->where('abonent_id', '=', $abonent['id'])->where('service_id', $service['id']);
                })->where('archived', 0)->get();


                /* Перебираємо лічильники */
                foreach ($meters as $meter) {

                        $abonent = Abonent::find($meter['abonent_id']);
                        $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];
                        $currentDate = Carbon::now();
                        $lastMonth = Carbon::now()->subMonth()->format('m');
                        $lastYearOfMonth = Carbon::now()->subMonth()->format('Y');
                        $currentMonth = Carbon::now()->format('m');
                        $currentYearOfMonth = Carbon::now()->format('Y');
//                        $last_counter = $this->getCounter($meter['id'], 8, $lastYearOfMonth);
//                        $current_counter = $this->getCounter($meter['id'], 9, $currentYearOfMonth);

                        $last_counter = Counter::where('meter_id', $meter['id'])->orderBy('created_at', 'DESC')->first();
                        $current_counter = Counter::where('meter_id', $meter['id'])->orderBy('created_at', 'ASC')->first();

                        if (!$last_counter) {
                            $last_counter['id'] = 0;
                            $last_counter['value'] = 0;
                        }

                        if (!$current_counter) {
                            $current_counter['id'] = 0;
                            $current_counter['value'] = 0;
                        }

                        $cost = new Cost();
                        $cost->abonent_id = $meter['abonent_id'];
//            $cost->author_id = $counter['author_id'];
                        $cost->author_id = 99;
                        $cost->service_id = $service['id'];
                        $cost->meter_id = $meter['id'];
                        $cost->value = abs(($current_counter['value'] - $last_counter['value']) * $tariff);
                        $cost->save();
                        $result[] = $cost;

                }
            }
        }

        return $result;
    }
}
