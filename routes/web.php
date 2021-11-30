<?php

use App\Http\Controllers\API\CorrectionController;
use App\Http\Controllers\API\ReceiptController;
use App\Http\Controllers\API\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\AbonentController;
use App\Http\Controllers\API\CounterController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\MeterController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\CostController;

use App\Models\Abonent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('login', function () {
    return view('login');
});*/

/*Route::middleware('auth:api')->group( function () {
	Route::group(['middleware' => ['role:admin|inspector']], function () {
		Route::resource('abonents', AbonentController::class);
	});
});*/

/* Роути для дій з абонентами */

Route::middleware('auth:web')->get('/abonents', [AbonentController::class, 'index']);         // список абонентів
Route::middleware('auth:api')->get('/abonents/search', [AbonentController::class, 'search']);   // пошук абонента
Route::middleware('auth:api')->get('/abonents/types', [AbonentController::class, 'types']);   // типи абонента
Route::middleware('auth:web')->get('/abonents/{id}', [AbonentController::class, 'show']);     // картка абонента
Route::middleware('auth:web')->post('/abonents', [AbonentController::class, 'store']);       // створення абонента
Route::middleware('auth:web')->post('/abonents/{id}', [AbonentController::class, 'update']);   // редагування картки абонента
Route::middleware('auth:api')->delete('/abonents/{id}', [AbonentController::class, 'destroy']);   // видалення абонента
Route::middleware('auth:api')->get('/abonents/{id}/counters', [CounterController::class, 'show']);     // показники абонента
Route::middleware('auth:api')->get('/abonents/{id}/meters', [MeterController::class, 'show']);     // лічильники абонента
Route::middleware('auth:api')->get('/abonents/{id}/payments', [PaymentController::class, 'show']);     // платежі абонента
Route::middleware('auth:api')->get('/abonents/{id}/services', [ServiceController::class, 'show']);     // послуги абонента
Route::middleware('auth:api')->get('/abonents/counters/empty', [CounterController::class, 'getAbonentsWithoutCounters']);


Route::middleware('auth:api')->get('/cities', [CityController::class, 'index']);    //список міст

/* Роути для квитанцій */
Route::middleware('auth:api')->get('/receipts', [ReceiptController::class, 'index']);    //список квитанцій
Route::middleware('auth:api')->get('/receipts/status/{id}', [ReceiptController::class, 'receiptByStatus']);    //список квитанцій по статусу
Route::middleware('auth:api')->get('/receipts/preview', [ReceiptController::class, 'preview']);    //список квитанцій перед генерацією
Route::middleware('auth:api')->post('/receipts/save', [ReceiptController::class, 'saveReceipt']);    //збереження квитанцій
Route::middleware('auth:api')->post('/receipts/generate', [ReceiptController::class, 'generate']);    //генерація PDF

/* Роути для звітів */
Route::middleware('auth:api')->get('/report/month', [ReportController::class, 'showmonth']);
Route::middleware('auth:api')->get('/report/day', [ReportController::class, 'showday']);
Route::middleware('auth:api')->get('/report/year', [ReportController::class, 'showyear']);

/* Роути для списань */
Route::middleware('auth:api')->get('/costs/generate', [CostController::class, 'generate']);

/* Роути для показників */
Route::get('/counters', [CounterController::class, 'index']);
Route::middleware('auth:api')->get('/counters/empty', [CounterController::class, 'getAbonentsWithoutCounters']);
Route::middleware('auth:api')->post('/counters/empty/generate', [CounterController::class, 'addCounters']);  //додаємо показники для абонентів, котрі не передали їх
Route::middleware('auth:api')->get('/counters/meter/{id}', [CounterController::class, 'getCountersByMeter']);
Route::middleware('auth:api')->get('/counters/meter/{id}/last', [CounterController::class, 'getLastCounterByMeter']);

/* Роути для корекції */
Route::middleware('auth:api')->post('/corrections', [CorrectionController::class, 'store']);


/* Роути для чекбокса */
Route::get('/shifts', [PaymentController::class, 'getShift']);

Route::middleware('auth:api')->get('/generate', [InvoiceController::class, 'generate']);

Route::middleware('auth:api')->group( function () {
    Route::resource('counters', CounterController::class);
});

Route::middleware('auth:api')->group( function () {
    Route::resource('meters', MeterController::class);
});

Route::middleware('auth:api')->group( function () {
    Route::resource('payments', PaymentController::class);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    $userData = $request->user();
    $request->user()->getRoleNames();
    $request->user()->getAllPermissions();
    $abonent_id = Abonent::where('user_id', $request->user()->id)->first();
    if ($abonent_id) {
        $userData['personal_account'] = $abonent_id['personal_account'];
    }
    return $userData;
});

Route::middleware('auth:api')->get('/userRole', function (Request $request) {
    return $request->user()->getRoleNames();
});

Route::middleware('auth:api')->group( function () {
    Route::resource('services', ServiceController::class);
});

Route::middleware('auth:api')->get('/import', [\App\Http\Controllers\API\ImportExport::class, 'import']);

Route::middleware('auth:api')->get('/custom', [TestController::class, 'func1']);
Route::get('/invoice-pdf', [InvoiceController::class, 'createPdf']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
