<?php

use App\Http\ControllersCorrectionController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\AbonentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CorrectionController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\MeterController;
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


/* Роути для дій з абонентами */

Route::middleware('auth:web')->get('/abonents', [AbonentController::class, 'index']);         // список абонентів
Route::middleware('auth:web')->get('/abonents/add', [AbonentController::class, 'storePage']);         // сторінка створення абонента
Route::middleware('auth:web')->get('/abonents/search', [AbonentController::class, 'search']);   // пошук абонента
Route::middleware('auth:web')->get('/abonents/{id}', [AbonentController::class, 'show']);     // картка абонента
Route::middleware('auth:web')->post('/abonents', [AbonentController::class, 'store']);       // створення абонента
Route::middleware('auth:web')->post('/abonents/{id}', [AbonentController::class, 'update']);   // редагування картки абонента
Route::middleware('auth:web')->delete('/abonents/{id}', [AbonentController::class, 'destroy']);   // видалення абонента
Route::middleware('auth:web')->get('/abonents/{id}/services', [ServiceController::class, 'show']);     // послуги абонента
Route::middleware('auth:web')->get('/abonents/{id}/meters', [MeterController::class, 'show']);     // лічильники абонента
Route::middleware('auth:web')->get('/abonents/{id}/payments', [PaymentController::class, 'show']);     // платежі абонента
Route::middleware('auth:web')->get('/abonents/{id}/balances', [AbonentController::class, 'getBalance']);     // баланс абонента
Route::middleware('auth:web')->get('/abonents/counters/empty', [CounterController::class, 'getAbonentsWithoutCounters']);


/* Роути для квитанцій */
Route::middleware('auth:web')->get('/receipts', [ReceiptController::class, 'index']);    //список квитанцій
Route::middleware('auth:web')->get('/receipts/status/{id}', [ReceiptController::class, 'receiptByStatus']);    //список квитанцій по статусу
Route::middleware('auth:web')->get('/receipts/preview', [ReceiptController::class, 'previewPage']);    //список квитанцій перед генерацією
Route::middleware('auth:web')->post('/receipts/save', [ReceiptController::class, 'saveReceipt']);    //збереження квитанцій
Route::middleware('auth:web')->post('/receipts/generate', [ReceiptController::class, 'generate']);    //генерація PDF


/* Роути для списань */
Route::middleware('auth:api')->get('/costs/generate', [CostController::class, 'generate']);

/* Роути для показників */
Route::middleware('auth:web')->get('/counters', [CounterController::class, 'index']);
Route::middleware('auth:web')->post('/counters', [CounterController::class, 'store']);
Route::middleware('auth:api')->get('/counters/empty', [CounterController::class, 'getAbonentsWithoutCounters']);
Route::middleware('auth:api')->post('/counters/empty/generate', [CounterController::class, 'addCounters']);  //додаємо показники для абонентів, котрі не передали їх
Route::middleware('auth:api')->get('/counters/meter/{id}', [CounterController::class, 'getCountersByMeter']);
Route::middleware('auth:api')->get('/counters/meter/{id}/last', [CounterController::class, 'getLastCounterByMeter']);

/* Роути для корекції */
Route::middleware('auth:web')->get('/corrections', [CorrectionController::class, 'index']);
Route::middleware('auth:web')->post('/corrections', [CorrectionController::class, 'store']);

/* Роути для платежів */
Route::middleware('auth:web')->get('/payments', [PaymentController::class, 'index']);
Route::middleware('auth:web')->post('/payments', [PaymentController::class, 'store']);


/* Роути для чекбокса */
Route::get('/shifts', [PaymentController::class, 'getShift']);

/* Роути для звіту */
Route::middleware('auth:web')->get('/home/{date}', [HomeController::class, 'show']);

/* Роути для лічильників */
Route::middleware('auth:web')->post('/meters/remove/{id}', [MeterController::class, 'destroy']);
Route::middleware('auth:web')->post('/meters/add', [MeterController::class, 'store']);   //створення лічильника абонента

Route::middleware('auth:api')->get('/generate', [InvoiceController::class, 'generate']);



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


Route::middleware('auth:api')->get('/custom', [TestController::class, 'func1']);
Route::get('/invoice-pdf', [InvoiceController::class, 'createPdf']);

Auth::routes();

Route::get('/logout', function (){
       auth()->logout();
        return redirect('/');
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
