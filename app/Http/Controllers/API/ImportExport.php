<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Abonent;
use App\Models\User;
use App\Models\Inspector2Service;
use App\Models\Balance;
use App\Models\Service;
use App\Models\Meters;
use Validator;
use App\Http\Resources\Abonent as AbonentResource;
use DB;
use App\Imports\AbonentsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExport extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = 12;
        $user = Auth::user();
        $result = '';

        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }

        $abonents = collect();
        $service_id = Inspector2Service::where('user_id', $user->id)->first('service_id')->service_id;
        //$service_id = 1;
        $total_count = Balance::where('service_id', $service_id)->count();

        $abonents = Abonent::offset($offset)->limit($limit)->whereHas('balance', function (Builder $query) use ($service_id) {
            $query->where('service_id', '=', $service_id);
        })->get();

        $result = AbonentResource::collection($abonents)->additional(['total_count' => $total_count, 'success' => true, 'service_id' => $service_id]);

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
        }
        /* TODO Створення абонента
        Додати перевірку на наявність абонента, користувача
        Додати перевірку помилок
        */
        $userReg = new User();
        $userReg->password = bcrypt('the-password-of-choice');
        $userReg->email = 'the-email@example.com';
        $userReg->name = 'My Name';
        $userReg->save();
        $input['user_id'] = $userReg->id;
        $abonent = Abonent::create($input);

        $balanceData['abonent_id'] = $input['id'];
        $services = $input['balance'];

        foreach ($services as $key => $item) {
            $balanceData['service_id'] = $key;
            $balanceData['value'] = $item;
            Balance::create($balanceData);
        }

        //return $this->sendResponse(new AbonentResource($abonent), 'Абонента створено успішно!');
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
        $abonent = Abonent::find($id);
        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

        /* Abonent::whereHas('balance', function (Builder $query) use ($service_id) {
            $query->where('service_id', '=', $service_id);
        })->where('name', 'LIKE','%'.$request->keyword.'%')->orWhere('id', 'LIKE','%'.$request->keyword.'%')->get(); */

        $services_ids = Balance::where('abonent_id', $id)->get('service_id');

        $services = Service::whereHas('balance', function (Builder $query) use ($id, $service_id) {
            $query->where('abonent_id', '=', $id)->whereIn('service_id', $service_id);
        })->get();

        $servicesNew = array();
        foreach ($services as $service) {
            $meters = Meters::where('service_id', $service['id'])->where('abonent_id', $id)->get();
            $balance = Balance::where('service_id', $service['id'])->where('abonent_id', $id)->get('value');
            $service['balance'] = $balance[0]['value'];
            $service['meters'] = $meters;

            array_push($servicesNew, $service);
        }

        $abonent['services'] = $servicesNew;

        /* foreach ($services_ids as $service_id) {
            echo Service::where('id', $service_id['service_id'])->first();
            $services[] = Service::where('id', $service_id)->first('name')->name;
        } */



        if (is_null($abonent)) {
            return $this->sendError('Abonent not found.');
        }

        return $this->sendResponse(new AbonentResource($abonent), 'Abonent retrieved successfully.');
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
            'name' 		 => 'required',
            'address' 	 => 'required',
            'phone'   	 => 'required',
            'peoples' 	 => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $abonent->name = $input['name'];
        $abonent->address = $input['address'];
        $abonent->phone = $input['phone'];
        $abonent->peoples = $input['peoples'];
        $abonent->updated_at = date('Y-m-d H:i:s');
        $abonent->save();

        return $this->sendResponse(new AbonentResource($abonent), 'Дані абонента оновлено!');
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

    public function import(Request $request) {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'inspector')) {
            $input = $request->all();
        }

        /*$userReg = new User();
        $userReg->password = bcrypt('the-password-of-choice');
        $userReg->email = 'the-email@example.com';
        $userReg->name = 'My Name';
        $userReg->save();
        $input['user_id'] = $userReg->id;
        $abonent = Abonent::create($input);

        $balanceData['abonent_id'] = $input['id'];
        $services = $input['balance'];

        foreach ($services as $key => $item) {
            $balanceData['service_id'] = $key;
            $balanceData['value'] = $item;
            Balance::create($balanceData);
        }*/

//        Excel::import(new AbonentsImport, 'public/abonents.xlsx');
        Excel::import(new AbonentsImport, 'public/meters.xlsx');


    }
}
