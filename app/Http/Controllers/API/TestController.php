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

class TestController extends BaseController
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
        $message['status'] = true;
        $message['text'] = 'Абонента створено успішно!';
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'inspector')) {
            $input = $request->all();
        }
        /* TODO Створення абонента
        Додати перевірку на наявність абонента, користувача
        Додати перевірку помилок
        */
        $userReg = new User();
        $userReg->password = bcrypt($input['id']);
        $userReg->email = $input['id'];
        $userReg->name = $input['name'];
        try {
            $userReg->save();
            $input['user_id'] = $userReg->id;
            Abonent::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            $message['status'] = false;
            $message['text'] = 'Помилка ' . $e->errorInfo[1] . ': ' . $e->errorInfo[2];
        }


        if ($message['status'] == true) {
            $balanceData['abonent_id'] = $input['id'];
            $services = $input['balance'];

            foreach ($services as $item) {
                $balanceData['service_id'] = $item['id'];
                $balanceData['value'] = $item['value'];
                Balance::create($balanceData);
            }
        }

        return response()->json([
            "success" => $message['status'],
            "message" => $message['text']
        ]);

//        return $this->sendResponse('', $message['text']);
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
        /* TODO
        оновлення балансів не працюють
         * */
        foreach ($input['services'] as $service) {
            Balance::where('abonent_id', $input['abonent_id'])->where('service_id', $service['id'])->update(['value' => $service['value']]);
        }
//        $balance->value = $input['balance'];


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
        User::where('id', $abonent->user_id)->delete();
        Balance::where('abonent_id', $abonent->id)->delete();
        $abonent->delete();
        $message = 'Абонент %s видалений';
        return $this->sendResponse([], sprintf($message, $abonent->name));
    }

    public function func1() {
        $abonents = Abonent::get('id');
        foreach ($abonents as $abonent) {
            Balance::create(['abonent_id' => $abonent['id'], 'service_id' => 2, 'value' => 0]);
        }
        return response()->json($abonents);
    }
}
