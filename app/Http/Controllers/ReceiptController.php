<?php

namespace App\Http\Controllers;

use App\Http\Resources\Abonent as AbonentResource;
use App\Http\Resources\Payment;
use App\Http\Resources\ReceiptCounter;
use App\Http\Resources\ReceiptPreviewResource;
use App\Http\Resources\ReceiptResource;
use App\Models\Balance;
use App\Models\Counter;
use App\Models\Inspector2Service;
use App\Models\Meters;
use App\Models\Receipt;
use App\Models\Abonent;
use App\Models\ReceiptData;
use App\Models\Service;
use App\Models\Tariff;
use App\Models\Payment as PaymentModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


class ReceiptController extends Controller
{

    public function getCounter($meter, $month, $yearOfMonth) {
        $counter = Counter::where('meter_id', $meter)->whereMonth('added_at', $month)->whereYear('added_at', $yearOfMonth)->first();

        if (!$counter) {
            $counter['id'] = 0;
            $counter['value'] = 0;
        }

        return $counter;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = 100;
        $receipts = array();
        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }
//1
        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');
//
        $receipts_arr = Receipt::where('archived', 0)->offset($offset)->limit($limit)->with('services')->orderBy('created_at', 'desc')->get();

        foreach ($receipts_arr as $item) {
            $receipt = new Receipt();
            $abonent = Abonent::find($item['abonent_id']);
            $receipt->abonent_id = $abonent->id;
            $receipt->abonent_name = $abonent->name;
            $receipt->abonent_personal_account = $abonent->personal_account;
            $receipt->author_id = $item['author_id'];
            $receipt->status_id = $item['status_id'];
            $receipt->archived = $item['archived'];
            $receipt->created_at = $item['created_at'];
            $receipt->services = $item['services'];

            $receipts[] = $receipt;

        }
        return view('receipts/receipts')->with('receipts', $receipts)->with('user', $user)->with('services', Service::whereIn('id', $service_id)->get());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receiptByStatus($id, Request $request)
    {

        $limit = 100;
        $user = Auth::user();

        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }

        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');
        $total_count = Receipt::where('archived', 0)->where('status_id', $id)->orderBy('id')->count();
        $receipts = Receipt::where('archived', 0)->where('status_id', $id)->offset($offset)->limit($limit)->with('abonent', 'status', 'services')->get();

        return $this->sendResponseCustom(new ReceiptResource($receipts), $limit, $total_count, 'receipts retrieved successfully.');
    }

    public function preview(Request $request) {
        $user = Auth::user();


        if ($request->limit){
            $limit = $request->limit;
        } else {
            $limit = 100;
        }

        if ($request->page) {
            $page = $request->page;
            $offset = $page*$limit;
        } else {
            $offset = 0;
        }


        if ($request->abonents){
            /* Отримуємо з масиву абонентів без квитанцій за минулий місяць */
            $abonents = Abonent::offset($offset)->limit($limit)->whereIn('id', $request->abonents)->orderBy('personal_account', 'ASC')->get();
        } else {
            /* Отримуємо всіх абонентів без квитанцій за минулий місяць */
            $abonents = Abonent::offset($offset)->limit($limit)->whereDoesntHave('receipt', function (Builder $query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            })->where('archived', 0)->orderBy('personal_account', 'ASC')->get();
        }

        $receipts = array();



        /*
            з лічильниками

        $abonents = Abonent::offset($offset)->limit($limit)->whereDoesntHave('receipt', function (Builder $query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        })->whereHas('meter', function (Builder $query2) {
            $query2->where('archived', 0);
        })->get();

        */



        foreach ($abonents as $abonent) {
            $abonentData = Abonent::find($abonent['id']);
            $currentDate = Carbon::now();
            $lastMonth = Carbon::now()->subMonth()->format('m');
            $lastYearOfMonth = Carbon::now()->subMonth()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentYearOfMonth = Carbon::now()->format('Y');

            // Отримуємо минулу квитанцію
//            $last_receipt = Abonent::find($abonent['id'])->receipt()->whereMonth('created_at', Carbon::now()->subMonth()->month)->first();
            $last_receipt = '';
            // Якщо знайдена остання квитанція, отримуємо її вміст (її дані)
            if ($last_receipt) {
                $receipt = Receipt::find($last_receipt['id']);
                $receipt->services = $receipt->services;
            } else {

                $receipt = new Receipt();
                $receipt->abonent_id = $abonent['id'];
                $receipt->abonent_name = $abonent['name'];
                $receipt->abonent_personal_account = $abonent['personal_account'];
                $receipt->author_id = $user->id;
                $receipt->status_id = 1;
                $receipt->archived = 0;
                $receipt->created_at = $currentDate;

                $services = Service::whereHas('balance', function (Builder $query) use ($abonent) {
                    $query->where('abonent_id', '=', $abonent['id'])->where('status', 1);
                })->get();

                /* Отримуємо дані по послугах */
                foreach ($services as $service) {

                    /* Перевіряємо, чи для послуги потрібні лічильники */
                    /* Якщо потрібні */
                    if ($service['counters'] == 1) {

                        $meters = Meters::whereHas('services', function (Builder $query) use ($abonent, $service) {
                            $query->where('abonent_id', '=', $abonent['id'])->where('service_id', $service['id'])->where('status', 1);
                        })->where('archived', 0)->get();

                        /* Якщо є лічильники */
                        if ($meters->isNotEmpty()) {

                            /* Перебираємо лічильники */
                            foreach ($meters as $meter) {
                                /* Якщо лічильник фізичний */
                                if ($meter['title'] != 'virtual') {
                                    $last_counter = $this->getCounter($meter['id'], $lastMonth, $lastYearOfMonth);
                                    $current_counter = $this->getCounter($meter['id'], $currentMonth, $currentYearOfMonth);


                                    /* отримуємо тариф по послузі лічильника */
                                    $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];

                                    $receipt->services->push(
                                        array(
                                            'service_id' => $service['id'],
                                            'service_title' => $service['name'],
                                            'meter_title' => $meter['title'],
                                            'meter_id' => $meter['id'],
                                            'last_counter_id' => $last_counter['id'],
                                            'last_counter' => $last_counter['value'],
                                            'current_counter_id' => $current_counter['id'],
                                            'current_counter' => $current_counter['value'],
                                            'used_counter' => $current_counter['value'] - $last_counter['value'],
                                            'generated' => ($current_counter['value'] - $last_counter['value']) * $tariff,
                                            'tariff' => $tariff,
                                            'balance' => $abonent->balanceCalc($service['id'])['value'],
//                                            'to_pay' => round(abs($abonent->balanceCalc($service['id'])['value'] - (($current_counter['value'] - $last_counter['value']) * $tariff)),2),
                                            'to_pay' => ($abonent->balanceCalc($service['id'])['value'] <= 0) ? abs($abonent->balanceCalc($service['id'])['value']) : $abonent->balanceCalc($service['id'])['value'] * -1,
                                        )
                                    );

                                /* Якщо лічильник віртуальний */
                                } elseif ($meter['title'] == 'virtual') {
                                    $last_counter = $this->getCounter($meter['id'], $lastMonth, $lastYearOfMonth);
                                    $current_counter = $this->getCounter($meter['id'], $currentMonth, $currentYearOfMonth);
                                    $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];

                                    $receipt->services->push(
                                        array(
                                            'service_id' => $service['id'],
                                            'service_title' => $service['name'],
                                            'meter_title' => $meter['title'],
                                            'meter_id' => $meter['id'],
                                            'last_counter_id' => $last_counter['id'],
                                            'last_counter' => $last_counter['value'],
                                            'current_counter_id' => $current_counter['id'],
                                            'current_counter' => $current_counter['value'],
                                            'used_counter' => $current_counter['value'] - $last_counter['value'],
                                            'generated' => ($current_counter['value'] - $last_counter['value']) * $tariff,
                                            'tariff' => $tariff,
                                            'balance' => $abonent->balanceCalc($service['id'])['value'],
                                            'to_pay' => ($abonent->balanceCalc($service['id'])['value'] <= 0) ? abs($abonent->balanceCalc($service['id'])['value']) : $abonent->balanceCalc($service['id'])['value'] * -1,
                                            )
                                    );
                                }
                            }

                        } /*else {

                            /* Якщо немає лічильників

                            $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];

                            $receipt->services->push(
                                array(
                                    'service_id' => $service['id'],
                                    'service_title' => $service['name'],
                                    'tariff' => $tariff,
                                    'peoples' => $abonent->peoples,
                                    'last_counter' => 4,
                                    'current_counter' => 4,
//                                    'last_balance' => Balance::where('abonent_id', $abonent->id)->where('service_id', $service['id'])->first()->value,
                                    'balance' => $abonent->balanceCalc($service['id'])['value'],
                                    'to_pay' => abs($abonent->balanceCalc($service['id'])['value'] - (($abonent->peoples * 4) * $tariff)),
                                )
                            );
                        }

                        */

                        /* Якщо непотрібні */
                    } else {

                        $tariff = Tariff::where('abonent_type', $abonent->type[0]->id)->where('city_id', $abonent->city_id)->where('service_id', $service['id'])->first()['value'];

                        $receipt->services->push(
                            array(
                                'service_id' => $service['id'],
                                'service_title' => $service['name'],
                                'peoples' => $abonent->peoples,
                                'tariff' => $tariff,
                                'last_counter' => 0,
                                'current_counter' => 0,
                                'balance' => $abonent->balanceCalc($service['id'])['value'],
                                'to_pay' => $abonent->peoples * $tariff,
                            )
                        );
                    }
                }
            }
            $receipts[] = $receipt;

        }

        return $receipts;
//        return $this->sendResponse(new ReceiptPreviewResource($receipts), 'Receipts retrieved successfully.');
    }

    public function previewPage(Request $request) {
        $receipts = $this->preview($request);
        $user = Auth::user();
        return view('receipts/preview', [
            'receipts' => $receipts,
            'user' => $user
        ]);
    }

    public function saveReceipt(Request $request) {

        $user = Auth::user();
        $receipts = $this->preview($request);

        foreach ($receipts as $receipt_single) {
            $receipt = new Receipt();
            $receipt->abonent_id = $receipt_single->abonent_id;
            $receipt->author_id = $receipt_single->author_id;
            $receipt->status_id = $receipt_single->status_id;
            $receipt->archived = $receipt_single->archived;
            $receipt->created_at = $receipt_single->created_at;
            $receipt->save();

            $result['all'][] = $receipt->id;

            foreach ($receipt_single->services as $service_single) {
                if ($service_single['current_counter_id'] == 0) {
                    $result['not_full'][$receipt->id][$service_single['service_id']] = array(
                        'receipt_id' => $receipt->id,
                        'abonent' => Abonent::find($receipt->abonent_id),
                        'error_service' => Service::find($service_single['service_id'])
                    );
                    Receipt::destroy([$receipt->id]);
                } else {

                    $service = new ReceiptData();
                    $service->receipt_id = $receipt->id;
                    $service->service_id = $service_single['service_id'];
                    $service->last_counters_id = $service_single['last_counter_id'];
                    $service->current_counters_id = $service_single['current_counter_id'];
                    $service->balance = $service_single['balance'];
                    $service->to_pay = $service_single['to_pay'];
                    $service->save();
                    $result['success'][$receipt->id][$service_single['service_id']] = array(
                        'receipt_id' => $receipt->id,
                        'abonent' => Abonent::find($receipt->abonent_id),
                        'service' => Service::find($service_single['service_id'])
                    );
                }
            }


        }

        return view('receipts/result', [
            'result' => $result,
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = Receipt::find($id);

        return $this->sendResponse(new ReceiptResource($receipt), 'receipt retrieved successfully');
    }

    public function getCounterValue($id) {
        $val = Counter::find($id);

        if ($val) {
            $result = $val['value'];
        } else {
            $result = 0;
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {

        if ($request->id) {
            $receipts_arr = Receipt::where('id', $request->id)->with('services')->get();
        } else {
            $receipts_arr = Receipt::where('status_id', 1)->with('services')->get();
        }


        foreach ($receipts_arr as $receipt_single) {
            $receipt = new Receipt();
            $receipt->abonent = Abonent::find($receipt_single->abonent_id);
            $receipt->abonent_id = $receipt_single->abonent_id;
            $receipt->abonent_name = $receipt->abonent->name;
            $receipt->author_id = $receipt_single->author_id;
            $receipt->status_id = $receipt_single->status_id;
            $receipt->archived = $receipt_single->archived;
            Carbon::setLocale('uk');
            $created_at = Carbon::parse($receipt_single->created_at)->subMonth()->format('m.Y');
            $receipt->date = $created_at;
            $receipt->created_at = Carbon::parse($receipt_single->created_at);
            $receipt->last_receipt_date = $receipt->created_at->subMonth()->format('Y-m-d');
            $receipt->last_month = Carbon::now()->subMonth()->translatedFormat('F');
            $receipt->last_month_year = Carbon::now()->subMonth()->translatedFormat('Y');
            $total = 0;
            foreach ($receipt_single->services as $service_single) {
                    $last_payment = PaymentModel::where('abonent_id', $receipt->abonent_id)->where('service_id', $service_single['service_id'])->whereBetween('created_at', array($receipt->last_receipt_date, $receipt->created_at->format('Y-m-d')))->sum('value');
                    if (!$last_payment) {
                        $last_payment = 0;
                    }

                    $meter = Counter::find($service_single['last_counters_id']);

                    if(!isset($meter)) {
                        $meter = null;
                    } else {
                        $meter = $meter->meter;
                    }

                    $service = new ReceiptData();
                    $service->service_id = $service_single['service_id'];
                    $service->service_title = Service::where('id', $service_single['service_id'])->first()['name'];
                    $service->service_provider = Service::find($service_single['service_id'])->provider;
                    $service->service_provider_title = Service::find($service_single['service_id'])->provider[0]['title'];
                    $service->meter = $meter;
                    $service->last_counters = $this->getCounterValue($service_single['last_counters_id']);
                    $service->last_counters_id = $service_single['last_counters_id'];
                    $service->current_counters = $this->getCounterValue($service_single['current_counters_id']);
                    $service->current_counters_id = $service_single['current_counters_id'];
                    $service->used_counter = $service->current_counters - $service->last_counters;
                    $service->tariff = Tariff::where('abonent_type', $receipt->abonent->type[0]->id)->where('city_id', $receipt->abonent->city_id)->where('service_id', $service_single['service_id'])->first()['value'];
                    $service->generated = ($service->current_counters -  $service->last_counters) * $service->tariff;
                    $service->last_payment = $last_payment;
                    $service->balance = $service_single['balance'];
                    $service->to_pay = $service_single['to_pay'];
                    $total = $total + $service->to_pay;
                    $service->total = $total;
                    $receipt->services->push($service);
            }


            $receipt->services = $receipt->services->groupBy(['service_provider_title', 'service_id']);

            $receipt->total_used = $receipt->services->map(function ($row) {
                return $row->map(function ($row1) {
                    return $row1->sum('used_counter');
                });
            });

            $receipt->total_generated = $receipt->services->map(function ($row) {
                return $row->map(function ($row1) {
                    return $row1->sum('generated');
                });
            });




            $receipts[] = $receipt;

            $pdf = PDF::loadView('invoice', [
                'receipt' => $receipt
            ])->setPaper('a4', 'portrait');;

            $path = public_path('pdfs/');
            $filename = str_replace('/', '_', $receipt->abonent['address']) . ' - ' . $created_at . '.pdf';
            $pdf->save($path . $filename);

        }


        return 'success';
    }


}
