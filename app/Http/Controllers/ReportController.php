<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Service;
use Carbon\Carbon;
use App\Http\Resources\Report as ReportResource;
use App\Http\Resources\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showday()
    {

        $start = Carbon::today();
        $start->startOfDay();
        $end = Carbon::today();
        $end->endOfDay();
        $services = Service::all();

        foreach ($services as $service) {
            $obj = Service::find($service['id']);
            $arr[] = array(
                'service_id' => $service['id'],
                'name' => $service['name'],
                'total_sum' => $obj->payment()->whereBetween('created_at', [$start, $end])->sum('value'),
            );
        }

        return $this->sendResponse(new ReportResource($arr), 'Report retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showmonth(Request $request)
    {

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        if ($request->month) {
            $month = $request->month;
        } else {
            $month = $currentMonth;
        }

        $services = Service::all();

        foreach ($services as $service) {
            $obj = Service::find($service['id']);
            $arr[] = array(
                'service_id' => $service['id'],
                'name' => $service['name'],
                'total_sum' => $obj->payment()->whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('value'),
            );
        }

        return $this->sendResponse(new ReportResource($arr), 'Report retrieved successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showyear()
    {

        $start = new Carbon('first day of this year');
        $start->startOfYear();
        $end = new Carbon('last day of this year');
        $end->endOfYear();

        $services = Service::all();
        $arr = array();

        foreach ($services as $service) {
            $obj = Service::find($service['id']);
            $arr[]= array(
                'service_id' => $service['id'],
                'name' => $service['name'],
                'total_sum' => $obj->payment()->whereBetween('created_at', [$start, $end])->sum('value'),
            );
        }

        return $this->sendResponse(new ReportResource($arr), 'Report retrieved successfully.');
    }

}
