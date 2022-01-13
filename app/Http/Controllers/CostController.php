<?php

namespace App\Http\Controllers;

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


class CostController extends Controller
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
        $counter = Counter::where('meter_id', $meter)->whereMonth('added_at', $month)->whereYear('added_at', $yearOfMonth)->first();

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
                    $query->where('abonent_id', '=', $abonent['id'])->where('service_id', $service['id'])->where('status', 1);
                })->where('archived', 0)->where('title', 'virtual')->where('abonent_id', '=', $abonent['id'])->get();

                /* Перебираємо лічильники */
                foreach ($meters as $meter) {

                        $abonent = Abonent::find($meter['abonent_id']);
                        $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];
                        $last_counter = Counter::where('meter_id', $meter['id'])->whereMonth('added_at', Carbon::now()->subMonth())->orderBy('added_at', 'ASC')->first();
                        $current_counter = Counter::where('meter_id', $meter['id'])->orderBy('added_at', 'DESC')->first();

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
                        $cost->author_id = 100;
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
