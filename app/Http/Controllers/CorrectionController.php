<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Counter;
use App\Models\User;
use App\Models\Abonent;
use App\Models\Payment;
use App\Models\Balance;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\Counter as CounterResource;
use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\Payment as PaymentResource;

class CorrectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = 20;
        $user = Auth::user();
        $result = '';
        $pay_allow = 1;

        if (session('alert') == true) {
            $alert = $this->sendResponseMessage('Баланс успішно скориговано.');
            $request->session()->forget('alert');
        } else {
            $alert = '';
        }

        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }

        if ($user->hasAnyRole('admin', 'inspector')) {
            $payments = Payment::offset($offset)->limit($limit)->orderBy('created_at', 'DESC')->get();
            $total_count = Payment::all()->count();

            $result = PaymentResource::collection($payments)->additional(['total_count' => $total_count, 'success' => true, 'pay_allow' => $pay_allow]);
        } else {
            $abonent_id = Abonent::where('user_id', $user->id)->first();

            $payments = Payment::where('abonent_id', $abonent_id->id)->offset($offset)->limit($limit)->get();
            $total_count = Payment::where('abonent_id', $abonent_id->id)->get()->count();

            $result = PaymentResource::collection($payments)->additional(['total_count' => $total_count, 'success' => true, 'pay_allow' => $pay_allow]);
        }

        return view('corrections/corrections', [
            'alert' => $alert
        ])->with('user', $user);
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
            $input['author_id'] = $user->id;
        } else {
            $input['abonent_id'] = Abonent::where('user_id', $user->id)->first()->id;
            $input['service_id'] = $request->service_id;
            $input['author_id'] = $user->id;
            $input['value'] = $request->value;
        }

        $validator = Validator::make($input, [
            'abonent_id' => 'required',
            'service_id' => 'required',
            'author_id'  => 'required',
            'value'      => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['title'] = 'Корекція';
        if ($input['value'] > 0) {
            $operation = Payment::create($input);

            $current_balance = Balance::where('abonent_id', $input['abonent_id'])->where('service_id', $input['service_id'])->first();
            $current_balance->value = $current_balance->value + $input['value'];
            $current_balance->last_update = date('Y-m-d');
            $current_balance->save();

        } else {
            $input['value'] = abs($input['value']);
            $operation = Cost::create($input);
            $current_balance = Balance::where('abonent_id', $input['abonent_id'])->where('service_id', $input['service_id'])->first();
            $current_balance->value = $current_balance->value - $input['value'];
            $current_balance->last_update = date('Y-m-d');
            $current_balance->save();
        }
        $result = redirect('/corrections')->with('alert', true);

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }

        if ($user->hasAnyRole('admin', 'inspector')) {
            $payments = Payment::offset($offset)->limit($limit)->where('abonent_id', $id)->get();
            $total_count = Payment::where('abonent_id', $id)->count();

            $result = PaymentResource::collection($payments)->additional(['total_count' => $total_count, 'success' => true]);
        }

        return $result;
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
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $abonent->name = $input['name'];
        $abonent->detail = $input['detail'];
        $abonent->save();

        return $this->sendResponse(new AbonentResource($abonent), 'Abonent updated successfully.');
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

    public function getShift(Request $request)
    {

    }

    public function openShift(Request $request)
    {

    }

    public function closeShift(Request $request)
    {

    }
}
