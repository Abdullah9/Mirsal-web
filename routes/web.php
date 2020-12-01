<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false, 'reset' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('language/{locale}', 'HomeController@language')->name('language');

Route::resource('hyper-payment','HyperPayPaymentController');
Route::get('pay-invoice', 'HyperPayPaymentController@payInvoice')->name('products.pa-invoice');
Route::get('return-url', 'HyperPayPaymentController@returnUrl')->name('products.return-url');

Route::middleware(['auth','csrf'])->group(function () {
    
    Route::namespace('Dashboard\Admin')->prefix('admins')->name('admins.')->group(function()
    {
        Route::resource('vet-requests','VetRequestController');
        Route::resource('vet-offers','VetOfferController');
        Route::resource('driver-requests','DriverRequestController');
        Route::resource('driver-offers','DriverOfferController');
        Route::resource('time-slots','TimeSlotController');
        Route::resource('animals','AnimalController');
        Route::resource('sizes','SizeController');
        Route::resource('durations','DurationController');
        Route::resource('cars','CarController');
        Route::resource('invoices','InvoiceController');
        Route::resource('products','ProductController');
        Route::put('products/accept/{product}', 'ProductController@accept')->name('products.accept');

        Route::resource('client-offers','ClientOfferController');

        Route::resource('admin-settings','AdminSettingController');
        Route::resource('veterinarians','UserVeterinarianController');
        Route::put('veterinarians/accept/{veterinarian}', 'UserVeterinarianController@accept')->name('veterinarians.accept');

        Route::resource('drivers','UserDriverController');
        Route::resource('clients','UserClientController');
        Route::resource('service-provider-report','ServiceProviderReportController');
    });

});


// Route::get('test', function(){
    // $user = \App\User::find(28);
    // $vet = User::find(3);
    // event(new VeterinarianAccepted($vet));

    // exit;
    // event(new OnRegister($user));

    // echo public_path();

    // $factory = (new Factory)->withServiceAccount(public_path().'\mirsal-c162c-firebase-adminsdk-65ru1-d51b1fe76d.json');
    // $factory = $factory->withDatabaseUri('https://mirsal-c162c.firebaseio.com/');
    // $authFirebase = $factory->createAuth();

    // $uid = '3';
    // $customToken = $authFirebase->createCustomToken($uid);
    // echo public_path().'/mirsal-c162c-firebase-adminsdk-65ru1-d51b1fe76d.json';
    // echo 1000 + 1000 * 0.2;
// }); 

// Route::get('returnUrl', function(Request $request){
//     // $user = \App\User::find(28);
//     // event(new OnRegister($user));
//     // echo $request->payment_reference;exit;
//     $response = \App\Helpers\HyperPayCopyAndPay::paymentStatus($request->resourcePath);
    
//     return view('pages.returnUrl')->with(compact('response'));
// });

