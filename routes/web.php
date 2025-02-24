<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FawryPayController;
use App\Http\Controllers\FawryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/fawry', function () {
//     return view('fawry');
// });



// Route::get('pay', [FawryPayController::class, 'generate'])->name('pay');

// Route::post('/fawry-payment', function (Request $request) {


//     $signature = hash(
//         'sha256',
//         env('FAWRY_MERCHANT_CODE')
//             . 'ORDER12345'
//             . $request->input('customer_id')
//             . number_format($request->input('amount'), 2, '.', '')
//             . env('FAWRY_SECRET_KEY')
//     );
//     // بيانات الدفع
//     $paymentData = [
//         'merchantCode' => env('FAWRY_MERCHANT_CODE'),
//         'merchantRefNum' => 'ORDER12345',
//         'customerProfileId' => $request->input('customer_id'),
//         'amount' => $request->input('amount'),
//         'paymentExpiry' => '3600',
//         'chargeItems' => [
//             [
//                 'itemId' => '111',
//                 'description' => 'Product Description',
//                 'price' => number_format($request->input('amount'), 2, '.', ''),
//                 'quantity' => 1,
//             ],
//         ],
//         'paymentMethod' => 'PAYATFAWRY',
//         'authCaptureModePayment' => false,
//         // 'signature' => hash('sha256', env('FAWRY_MERCHANT_CODE') . 'ORDER12345' . $request->input('customer_id') . number_format($request->input('amount'), 2, '.', '')  . env('FAWRY_SECRET_KEY')),
//         'signature' => '2ca4c078ab0d4c50ba90e31b3b0339d4d4ae5b32f97092dd9e9c07888c7eef36',


//     ];

//     // إرسال الطلب إلى Fawry API
//     $apiUrl = env('FAWRY_API_URL');
//     $response = Http::post($apiUrl, $paymentData);

//     // return response()->json([
//     //     'data' => $response->json(),

//     //     ]);

//     Log::info(json_encode($response->json()));
//     if ($response->successful()) {
//         // تحديث حالة الطلب
//         return response()->json([
//             'message' => 'Payment initiated successfully',
//             'data' => $response->json(),

//         ]);
//     } else {
//         return response()->json([
//             'error' => 'Payment failed',
//             'data' => $response->json(),

//         ], 400);
//     }
// });



Route::get('/pay', [FawryController::class, 'pay'])->name('fawry.pay');
Route::get('/payment-callback', [FawryController::class, 'callback'])->name('fawry.callback');
