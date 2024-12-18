<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AbonentAddedResource;
use App\Http\Resources\TypeResource;
use App\Models\Counter;
use App\Models\Provider;
use App\Models\Service2Meter;
use App\Models\Type;
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
use App\Models\Contract;
use App\Models\Archive;
use Validator;
use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\AbonentUpdatedResource;
use DB;

class AbonentController extends BaseController
{

    function sendMessage($messaggio) {
        $chatID = '-594024168';
        $token = '1937471338:AAGTX_yaSDnkvt9zu_BrMCIxsWx-IkKGMBk';
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

	 public function index(Request $request)
    {
		$limit = 50;
		$user = Auth::user();
		$result = '';

		if ($request->page) {
			$page = $request->page;
			$offset = $page*$limit;
		} else {
			$offset = 0;
		}

		$abonents = collect();
		$service_id = Inspector2Service::where('user_id', 5)->get('service_id');
		//$service_id = 1;
		$total_count = Abonent::where('archived', 0)->whereHas('balance', function (Builder $query) use ($service_id) {
            $query->whereIn('service_id', $service_id);
        })->orderBy('id')->count();

		$abonents = Abonent::where('archived', 0)->offset($offset)->limit($limit)->whereHas('balance', function (Builder $query) use ($service_id) {
			$query->whereIn('service_id', $service_id);
		})->orderBy('personal_account')->with('type')->get();

        return view('abonents', ['abonents' => $abonents]);
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
        $abonent = new Abonent();
        $userReg->password = bcrypt($input['personal_account']);
        $userReg->email = $input['personal_account'];
        $userReg->name = $input['name'];
        try {
            $userReg->save();
            $input['user_id'] = $userReg->id;
//            $input['user_id'] = 0;

            $abonent->personal_account = $input['personal_account'];
            $abonent->name = $input['name'];
            $abonent->address = $input['address'];
            $abonent->phone = $input['phone'];
            $abonent->peoples = $input['peoples'];
            $abonent->city_id = $input['city_id'];

            $abonent->save();
            $abonent->type()->attach(1);

            $balanceData['abonent_id'] = $abonent->id;
            $services = $input['balance'];

             foreach ($services as $item) {
                $balanceData['service_id'] = $item['id'];
                $balanceData['value'] = $item['value'];
                $contractsNew[] = array(
                    'abonent_id'  => $balanceData['abonent_id'],
                    'provider_id' => Service::where('id', $item['id'])->first('provider_id')['provider_id'],
                    'title'       => '',
                    'date'        => ''
                );
                Balance::create($balanceData);
            }

            $contracts = array_map("unserialize", array_unique(array_map("serialize", $contractsNew)));
            foreach ($contracts as $contract) {
                Contract::create($contract);
            }

        } catch (\Illuminate\Database\QueryException $e) {
                $message['status'] = false;
                $message['text'] = 'Помилка ' . $e->errorInfo[1] . ': ' . $e->errorInfo[2];
                $tg = 'Даааа, ебать его в рот: ' . $e->errorInfo[1] . ' ' . $e->errorInfo[2] . ' Користувач: ' . $user->name . ' (' . $user->email .')' . PHP_EOL . 'UserData: ' . json_encode($userReg, JSON_UNESCAPED_UNICODE) . PHP_EOL . 'AbonentData:' . json_encode($input, JSON_UNESCAPED_UNICODE);
                $this->sendMessage($tg);
        }


        return $this->sendResponse(new AbonentAddedResource($abonent), $message['text']);

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
		$contractsNew = array();
		foreach ($services as $service) {
			$balance = $abonent->balanceCalc($service['id']);
			$service['balance'] = $balance['value'];
			$service['status'] = $balance['status'];

			array_push($servicesNew, $service);
//			$providers[] = ;
            $contract = Contract::where('abonent_id', $id)->where('provider_id', $service['provider_id'])->first();
            if ($contract) {
                $contracts = array(
                    'provider_id' => $service['provider_id'],
                    'provider_name' => Provider::find($service['provider_id'])->title,
                    'title' => $contract['title'],
                    'date' => $contract['date']
                );
                array_push($contractsNew, $contracts);
            }
		}

        $meters = Meters::where('abonent_id', $id)->where('title', '!=', 'virtual')->get();
        $abonent['meters'] = array();
        $metersNew = array();
		foreach ($meters as $meter) {
            $meter0 = array(
                'title'         => $meter->title,
                'abonent_id'    => $meter->abonent_id,
                'code'          => $meter->code,
                'code_plomb'    => $meter->code_plomb,
                'counter'       => $meter->counter,
                'last_check'    => $meter->last_check,
                'next_check'    => $meter->next_check,
                'meter_id'      => $meter->id,
                'archived'      => $meter->archived,
                'services'      => ''
            );

            $meterServices = array();
            foreach (Service2Meter::where('meter_id', $meter['id'])->get() as $service) {
                $meterServicesTemp = array(
                    'service_id' => $service['service_id'],
                    'name'       => Service::where('id', $service['service_id'])->first()['name']
                );
                array_push($meterServices, $meterServicesTemp);
            }

            $meter0['services'] = $meterServices;
            array_push($metersNew, $meter0);

        }

        $abonent['meters'] = $metersNew;
		$abonent['services'] = $servicesNew;
		$abonent['contracts'] = array_map("unserialize", array_unique(array_map("serialize", $contractsNew)));
		$abonent['type'] = Abonent::with('type')->findOrFail($id)->type;


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
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $abonent = Abonent::find($id);

        $validator = Validator::make($input, [
            'name' 		 => 'required',
            'address' 	 => 'required',
            'phone'   	 => 'required',
            'peoples' 	 => 'required',
            'city_id' 	 => 'required',
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $abonent->name = $input['name'];
        $abonent->address = $input['address'];
        $abonent->phone = $input['phone'];
        $abonent->peoples = $input['peoples'];

        if ($input['status']) {
            $abonent->status = $input['status'];
        } else {
            $abonent->status = 0;
        }
        Abonent::where('id', $input['abonent_id'])->update(['city_id' => $input['city_id']]);


        $abonent->updated_at = date('Y-m-d H:i:s');
//        $abonent->city_id = 1;

        $abonent->save();
        Abonent::find($input['abonent_id'])->type()->sync($input['type_id']);
//        $abonent->type = array(0 => array('id' => $input['type_id'], 'title' => 'rt'));
        foreach ($input['services'] as $service) {
            Balance::where('abonent_id', $input['abonent_id'])->where('service_id', $service['id'])->update(['value' => $service['value'], 'status' => $service['status']]);
        }

        foreach ($input['contracts'] as $contract) {
            Contract::where('abonent_id', $input['abonent_id'])->where('provider_id', $contract['provider_id'])->update([
                'title' => $contract['title'],
                'date' =>  date("Y-m-d", strtotime($contract['date']))
            ]);
        }
//        $balance->value = $input['balance'];


        //return $this->sendResponse(new AbonentResource($abonent), 'Дані абонента оновлено!');
        return $this->sendResponse(new AbonentUpdatedResource($abonent), 'Дані абонента оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abonent $abonent)
    {

        User::where('id', $abonent->user_id)->update(['archived' => 1]);
        $abonent->update(['archived' => 1]);
        $message = 'Абонент %s переміщений в архів';
        return $this->sendResponse([], sprintf($message, $abonent->name));
    }

	public function search(Request $request) {
		$user = Auth::user();
        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

        $data = Abonent::whereHas('balance', function (Builder $query) use ($service_id) {
            $query->whereIn('service_id', $service_id);
        })->where('name', 'LIKE','%'.$request->keyword.'%')->orWhere('personal_account', 'LIKE','%'.$request->keyword.'%')->where('archived', 0)->get();

        return response()->json($data);
	}

	public function archive(Request $request)
    {
        if ($request->limit) {
            $limit = (int)$request->limit;
        } else {
            $limit = 50;
        }

        $user = Auth::user();
        $result = '';

        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }

        $archive = Abonent::where('archived', 1)->offset($offset)->limit($limit)->orderBy('personal_account')->get();

        $data['data'] = $archive;
        $data['total_count'] = Abonent::where('archived', 1)->count();
        $data['per_page'] = $limit;
        $data['success'] = true;

        return $data;
    }

	public function archiveId($id)
    {
        $archive = Archive::find($id);
        $data['data'] = json_decode($archive->data);

        $data['success'] = true;

        return $data;
    }

    public function types()
    {
        return $this->sendResponse(new TypeResource(Type::all()), 'Abonent retrieved successfully.');
    }
}
