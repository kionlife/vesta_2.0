<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbonentAddedResource;
use App\Http\Resources\TypeResource;
use App\Http\Resources\Payment as PaymentResource;
use App\Models\City;
use App\Models\Cost;
use App\Models\Counter;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\Service2Meter;
use App\Models\Source_of_income;
use App\Models\Tariff;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Abonent;
use App\Models\User;
use App\Models\Inspector2Service;
use App\Models\Balance;
use App\Models\Service;
use App\Models\Meters;
use App\Models\Contract;
use App\Models\Archive;
use App\Models\Family;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\AbonentUpdatedResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use App\Http\Resources\CityResource;
use Yajra\DataTables\DataTables;


class AbonentController extends Controller
{

    function sendMessage($messaggio)
    {
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
        $user = Auth::user();

        if (session('alert') == true) {
            $alert = $this->sendResponseMessage('Абонент переміщений в архів');
            $request->session()->forget('alert');
        } else {
            $alert = '';
        }

        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

        $abonents = Abonent::where('archived', 0)->whereHas('balance', function (Builder $query) use ($service_id) {
            $query->whereIn('service_id', $service_id);
        })->with('type', 'balance');

        $total_count = $abonents->count();

        if ($request->ajax()) {

            $data = Abonent::select('*');

            $result = Datatables::of($abonents)
                ->addIndexColumn()
                ->addColumn('archived', function($row){
                    if ($row->status) {
                        return '<span class="">Active</span>';
                    } else {
                        return '<span class="">Deactive</span>';
                    }
                })
                ->addColumn('balance', function($row){
                    $sum = 0;
                    foreach ($row->balance as $item) {
                        $sum += $item['value'];
                    }
                    return view('datatables/balance', [
                        'sum' => $sum
                    ]);
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('archived') == '0' || $request->get('archived') == '1') {
                        $instance->where('archived', $request->get('archived'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('personal_account', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['archived'])
                ->setRowAttr([
                    'data-href' => function($ab) {
                        return '/abonents/' . $ab->id;
                    },
                ])
                ->make(true);
            return $result;
        }

        return view('abonents/abonents', [
            'user' => $user,
            'total_count' => $total_count,
            'alert' => $alert
        ]);
    }


    public function storePage() {
        $data = '';



        return view('abonents/add', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
        $userReg = User::firstOrNew(array(
            'email' => $input['personal_account'],
        ));
        $abonent = new Abonent();
        $userReg->password = bcrypt($input['personal_account']);
        $userReg->name = $input['name'];

            $userReg->save();
            $input['user_id'] = $userReg->id;

            $abonent->personal_account = $input['personal_account'];
            $abonent->name = $input['name'];
            $abonent->address = $input['address'];
            $abonent->phone = $input['phone'];
            $abonent->peoples = $input['peoples'];
            $abonent->city_id = 1;

            $abonent->save();
            $abonent->type()->attach(1);

            for($i=0;$i<$input['peoples'];$i++) {
                $person = new Family();
                $person->abonent_id = $abonent->id;
                $person->save();
            }

            $balanceData['abonent_id'] = $abonent->id;
            $services = Service::all();

            foreach ($services as $item) {
                $balanceData['service_id'] = $item['id'];
                $balanceData['status'] = 0;
                $contractsNew[] = array(
                    'abonent_id' => $balanceData['abonent_id'],
                    'provider_id' => Service::where('id', $item['id'])->first('provider_id')['provider_id'],
                    'title' => '',
                    'date' => date('Y-m-d')
                );
                Balance::create($balanceData);
            }

            $contracts = array_map("unserialize", array_unique(array_map("serialize", $contractsNew)));
            foreach ($contracts as $contract) {
                Contract::create($contract);
            }




        return $abonent->id;

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = Auth::user();
        $abonent = Abonent::find($id);

        if (is_null($abonent)) {
            return $this->sendError('Абонента не знайдено!');
        }

        if (session('alert') == true) {
            $alert = $this->sendResponseMessage('Дані абонента оновлено.');
            $request->session()->forget('alert');
        } else {
            $alert = '';
        }

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
            $service['tariff'] = Tariff::where('id', Balance::where('abonent_id', $id)->where('service_id', $service['id'])->first()['tariff_id'])->first();
            $service['available_tariffs'] = Tariff::where('service_id', $service['id'])->where('city_id', $abonent['city_id'])->get();

            array_push($servicesNew, $service);
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
            $service['contracts'] = $contractsNew;

        }

        $meters = Meters::where('abonent_id', $id)->where('archived', 0)->get();
        $abonent['meters'] = array();
        $metersNew = array();
        foreach ($meters as $meter) {
            $meter0 = array(
                'title' => $meter->title,
                'abonent_id' => $meter->abonent_id,
                'code' => $meter->code,
                'code_plomb' => $meter->code_plomb,
                'counter' => $meter->counter,
                'last_check' => $meter->last_check,
                'next_check' => $meter->next_check,
                'meter_id' => $meter->id,
                'archived' => $meter->archived,
                'services' => $meter->services,
                'provider' => $meter->services()->first()->provider[0]['id'],
                'tariff'   => array(
                    'current'    => $meter->tariff,
                    'available'  => Tariff::whereIn('provider_id', $meter->services()->where('status', 1)->first()->provider[0])->get()
                ),
                'counters' => Counter::where('meter_id', $meter->id)->orderBy('created_at', 'DESC')->with('author')->get(),
            );

            array_push($metersNew, $meter0);

        }

        $family = Family::where('abonent_id', $id)->where('archived', 0)->get();

        $fam_count = Family::where('abonent_id', $id)->where('archived', 0)->get()->count();
        $abonent['peoples'] = $fam_count;



        $abonent['meters'] = $metersNew;
        $abonent['services'] = $servicesNew;
        $abonent['tariffs'] = Tariff::whereIn('service_id', $abonent->service()->where('status', 1)->get('service_id'))->whereIn('service_id', $service_id)->get();
        $providers = $services->groupBy('provider_id');
        foreach($providers as $provider) {
            $balance_temp = 0;
            foreach ($provider as $pr_service) {
                $balance_temp += $pr_service['balance'];
                $providers[$pr_service['provider_id']] = array(
                    'provider' => Provider::find($pr_service['provider_id']),
                    'balance' => $balance_temp
                );
            }
        }


        $abonent['providers'] = $providers;
        $abonent['contracts'] = array_map("unserialize", array_unique(array_map("serialize", $contractsNew)));
        $abonent['type'] = Abonent::with('type')->findOrFail($id)->type;

        $costs = Cost::where('abonent_id', $id)->where('archived', 0)->orderBy('created_at', 'DESC')->get();
        $payments = Payment::where('abonent_id', $id)->where('archived', 0)->orderBy('created_at', 'DESC')->get()->transform(function($item) {
            $payment = $item;
            $payment['allow_cancel'] = 0;
            if (strtotime($item['created_at']) > (time() - (60*60*24))) {
                $payment['allow_cancel'] = 1;
            }
            return $item;
        });



        $abonent['history'] = $costs->merge($payments)->groupBy('service_id');
        $abonent['receipts'] = $abonent->receipt()->with('author', 'status')->get();
        $sources = Source_of_income::all();

        return view('abonents/card', [
            'abonent'   => $abonent,
            'family'    => $family,
            'alert'     => $alert,
            'user'      => $user,
            'cities'    => City::all(),
            'types'     => Type::all(),
            'services'  => collect($servicesNew)->where('status', 1),
            'sources' => $sources

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $abonent = Abonent::find($id);

        $validator = Validator::make($input, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'peoples' => 'required',
            'city_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $family=Family::where('abonent_id', $id)->where('archived', 0)->get()->count();

        $abonent->personal_account = $input['personal_account'];
        $abonent->name = $input['name'];
        $abonent->address = $input['address'];
        $abonent->phone = $input['phone'];
        $abonent->peoples = $family;


        if (isset($input['status'])) {
            $abonent->status = 1;
        } else {
            $abonent->status = 0;
        }
        Abonent::where('id', $id)->update(['city_id' => $input['city_id']]);


        $abonent->updated_at = date('Y-m-d H:i:s');
//        $abonent->city_id = 1;

        $abonent->save();
        Abonent::find($id)->type()->sync($input['type_id']);

        foreach ($input['services'] as $service) {
            Balance::where('abonent_id', $id)->where('service_id', $service['id'])->update(['status' => $service['status']]);
        }


        if (isset($input['persons'])) {
            foreach ($input['persons'] as $person) {
                Family::where('abonent_id', $id)->where('id', $person['id'])->update(['first_name' => $person['first_name'], 'second_name' => $person['second_name'], 'last_name' => $person['last_name']]);
            }
        }

        if (isset($input['contracts'])) {
            foreach ($input['contracts'] as $contract) {
                if (!$contract['title']) {
                    $contract['title'] = '';
                }
                Contract::where('abonent_id', $id)->where('provider_id', $contract['provider_id'])->update([
                    'title' => $contract['title'],
                    'date' => date("Y-m-d", strtotime($contract['date']))
                ]);
            }
        }

//        $balance->value = $input['balance'];

        /* Лічильники збереження */

        if (isset($input['meters'])) {

            foreach ($input['meters'] as $single_meter) {
                $meter = Meters::find($single_meter['meter_id']);
                $meter->title = $single_meter['title'];
                $meter->code = $single_meter['code'];
                $meter->code_plomb = $single_meter['code_plomb'];
                $meter->next_check = $single_meter['next_check'];
                $meter->last_check = $single_meter['last_check'];
//                $meter->tariff_id = $single_meter['tariff_id'];

                $meter->services()->sync($single_meter['services']);

                $meter->save();
            }
        }

        //return $this->sendResponse(new AbonentResource($abonent), 'Дані абонента оновлено!');
        return redirect('/abonents/' . $id)->with('alert', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

        $abonent = Abonent::find($id);
        User::where('id', $abonent->user_id)->update(['archived' => 1]);
        $abonent->update(['archived' => 1]);
        $message = 'Абонент %s переміщений в архів';

        return redirect('/abonents')->with('alert', true);
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');

        $data = Abonent::whereHas('balance', function (Builder $query) use ($service_id) {
            $query->whereIn('service_id', $service_id);
        })->where('name', 'LIKE', '%' . $request->keyword . '%')->orWhere('personal_account', 'LIKE', '%' . $request->keyword . '%')->where('archived', 0)->limit(30)->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function family_add(Request $request)
    {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'inspector')) {
            $input = $request->all();
        }

        $person = new Family();
        $person->abonent_id = $input['abonent_id'];
        $person->first_name = $input['first_name'];
        $person->second_name = $input['second_name'];
        $person->last_name = $input['last_name'];
        $person->save();

        return 'Запис додано успішно!';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function family_remove($id)
    {
        $person = Family::find($id);
        $person->archived = 1;
        $person->save();

        return $id;
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
            $offset = $page * $limit;
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

    /**
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getBalance($id, Request $request) {

        $abonent = Abonent::find($id);

        $service_id = $request->service_id;

        $balance = $abonent->balanceCalc($service_id);

        return $balance;
    }
}


