<?php

namespace App\Http\Controllers\API;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Abonent;
use App\Models\User;
use App\Models\Service;
use App\Models\Counter;
use App\Models\Tariff;
use App\Models\Inspector2Service;
use App\Models\Balance;
use App\Models\Meters;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\Service as ServiceResource;
use Carbon\Carbon;
use DB;
use PDF;

class InvoiceController extends BaseController
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'account_id' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $abonent = Abonent::create($input);

        return $this->sendResponse(new AbonentResource($abonent), 'Abonent created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $abonent = Abonent::find($id);

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

	public function generate() {
        $invoice_data = array();

		$abonents_ids = Abonent::where('status', 0)->where('archived', 0)->limit(1)->get();
		$invoice = array();

		foreach ($abonents_ids as $abonent) {

			//Отримуємо особовий рахунок абонента
			$abonent_id = $abonent->id;

			//Отримуємо інформацію про абонента
            $invoice_data['abonent'] = Abonent::where('id', $abonent_id)->where('status', 0)->where('archived', 0)->get();
            $city_id = Abonent::where('id', $abonent_id)->where('status', 0)->where('archived', 0)->first('city_id');

			//Отримуємо послуги абонента та інформацію про них
            /*$invoice_data['services'] = Service::whereHas('balance', function (Builder $query) use ($abonent_id) {
				$query->where('abonent_id', $abonent_id);
			})->get();
            */

			//Отримуємо послуги абонента та інформацію про них
            $balances = Balance::where('abonent_id', $abonent_id)->where('status', 1)->with('service.provider')->get();

            $invoice_data['balances'] = array();
            foreach ($balances as $balance) {
                $balanceNew = array();
                $balanceNew = $balance;

                //Отримуємо тариф
                $tariff = Tariff::where('service_id', $balance->service_id)->where('city_id', $city_id['city_id'])->first();
                $balanceNew->tariff = $tariff;

                //Отримуємо дані по платежах
                $balanceNew->payment = Payment::where('service_id', $balance->service_id)->where('abonent_id', $abonent_id)->whereMonth('created_at', Carbon::now()->subMonth()->month)->first();

                array_push($invoice_data['balances'], $balanceNew);
            }

            //Отримуємо лічильники абонента
            $invoice_data['meters'] = Meters::where('abonent_id', $abonent_id)->get();

            //Отримуємо показник за минулий місяць
            $invoice_data['counters']['current_counter'] = Counter::where('abonent_id', $abonent_id)->whereMonth('added_at', Carbon::now()->subMonth()->month)->first();

            //Отримуємо показники за позаминулий місяць
            $invoice_data['counters']['counter_2m_ago'] = Counter::where('abonent_id', $abonent_id)->whereMonth('added_at', Carbon::now()->subMonth(2)->month)->first();

            //Отримуємо показники за позапозаминулий місяць
            $invoice_data['counters']['counter_3m_ago'] = Counter::where('abonent_id', $abonent_id)->whereMonth('added_at', Carbon::now()->subMonth(3)->month)->first();


            $invoice_data['date']['month'] = '08';
            $invoice_data['date']['year'] = '2021';

            array_push($invoice, $invoice_data);

		}

//		return $invoice;
        return $this->generateInvoice($invoice);

	}

	public function generateInvoice($invoices_data) {

            $pdf = PDF::loadView('invoice', [
                'invoice_data' => $invoices_data
            ]);

            return $pdf->download('pdf_file.pdf');

    }

	public function generateOld() {
		$abonents_ids = Abonent::all('id');
		$invoice_data = array();
		foreach ($abonents_ids as $abonent_id) {
			$abonent_id = $abonent_id->id;
			$services = Balance::where('abonent_id', $abonent_id)->get('service_id');
			$currentMonth = date('m');
			$currentYear = date('Y');
			$lastMonth = date('m', strtotime('-1 months'));
			$beforeLastMonth = date('m', strtotime('-2 months'));
			$beforeBeforeLastMonth = date('m', strtotime('-3 months'));
			foreach ($services as $service) {
				if (Service::where('id', $service['service_id'])->first('counters')->counters === '1') {
					if (Meters::where('service_id', $service['service_id'])->where('abonent_id', $abonent_id)->get()->count() > 0) {
						$countersCheck = Counter::where('abonent_id', $abonent_id)->whereMonth('added_at', '=', $lastMonth)->first('value');

						$lastCounters = Counter::where('abonent_id', $abonent_id)->whereMonth('added_at', '=', $beforeLastMonth)->first('value')->value;

						$beforeLastCounters = Counter::where('abonent_id', $abonent_id)->whereMonth('added_at', '=', $beforeBeforeLastMonth)->first('value')->value;

						if ($countersCheck) {
							$currentCounters = $countersCheck->value;
						} else {
							$currentCounters = ceil(($lastCounters -$beforeLastCounters)+$lastCounters);
						}

						$counters = $currentCounters - $lastCounters;

						$total = $counters * Tariff::where('name', 'tariff')->where('service_id', $service['service_id'])->first('value')->value;

						$newBalance = Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->first('value')->value - $total;

						if (date('m', strtotime(Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->first('last_update')->last_update)) < date('m')) {
							Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->update(['value' => $newBalance, 'last_update' => date('Y-m-d')]);
						}
					} else {
						$peoples = Abonent::where('id', $abonent_id)->first('peoples')->peoples;

						$total = $peoples * 4 * Tariff::where('name', 'tariff')->where('service_id', $service['service_id'])->first('value')->value;

						$newBalance = Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->first('value')->value - $total;
						if (date('m', strtotime(Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->first('last_update')->last_update)) < date('m')) {
							Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->update(['value' => $newBalance, 'last_update' => date('Y-m-d')]);
						}
					}
				} else {
					$newBalance = Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->first('value')->value - (float)Tariff::where('name', 'tariff')->where('service_id', $service['service_id'])->first('value')->value;

					if (date('m', strtotime(Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->first('last_update')->last_update)) < date('m')) {
						Balance::where('abonent_id', $abonent_id)->where('service_id', $service['service_id'])->update(['value' => $newBalance, 'last_update' => date('Y-m-d')]);
					}
				}
			}

			$abonent = Abonent::where('id', $abonent_id)->first();
			$services = Service::whereHas('balance', function (Builder $query) use ($abonent_id) {
				$query->where('abonent_id', '=', $abonent_id);
			})->get();

			$servicesNew = array();
			foreach ($services as $service) {

				$balance = Balance::where('service_id', $service['id'])->where('abonent_id', $abonent_id)->get('value');

				$service['balance'] = $balance[0]['value'];

				if ($service['counters'] == 1) {
					$meters = Meters::where('service_id', $service['id'])->where('abonent_id', $abonent_id)->get();

					$service['last_counters'] = Counter::where('abonent_id', $abonent_id)->where('service_id', $service['id'])->whereMonth('added_at', '=', $beforeLastMonth)->first('value')->value;

					$service['meters'] = $meters;
				}

				array_push($servicesNew, $service);
			}

			$invoice_data['month'] = $currentMonth;
			$invoice_data['year'] = $currentYear;
			$invoice_data['data'] = array(
				'abonent'  => array(
					'abonent_id' => $abonent->id,
					'name'       => $abonent->name,
					'address' 	 => $abonent->address
				),
				'services' => $servicesNew
			);

			$input['abonent_id'] = $abonent_id;
			$input['month'] = date('m');
			$input['year'] = date('Y');
			$input['data'] = json_encode($invoice_data);

			unset($invoice_data);
		}

		return Invoice::create($input);

	}

	public function createPdf() {

		$lastMonth = date('m', strtotime('-1 months'));
		$invoice_data = Invoice::where('month', $lastMonth)->get('data');
		$invoices = array();
		foreach ($invoice_data as $invoice) {
			array_push($invoices, json_decode($invoice['data']));
		}

		foreach ($invoices->data->services as $service) {
			$tariff = Tariff::where('service_id', $service['id']);
			array_push($invoices->data->services, $tariff);
		}

		// dd($invoices);

		$pdf = PDF::loadView('invoice', [
			'invoice_data' => $invoices,
			'month' 	   => $lastMonth,
			'year'    	   => '2021'
		]);

		// download PDF file with download method
		return $pdf->download('pdf_file.pdf');
		// return $invoice_data;
    }

}
