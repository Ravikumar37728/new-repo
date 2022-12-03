<?php


use App\Http\Controllers\Api_Controllers\cityapicontroller;
use App\Http\Controllers\Api_Controllers\Statesapicontroller;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api_Controllers\productApicontroller;
use App\Http\Controllers\Api_Controllers\ContactusApicontroller;
use App\Http\Controllers\Api_Controllers\coupanApicontroller;
use App\Http\Controllers\Api_Controllers\FestivalApicontroller;
use App\Http\Controllers\Api_Controllers\StatApiController;
use App\Http\Controllers\Api_Controllers\userdataApicontroller;
use App\Http\Controllers\Api_Controllers\usercontroller;
use App\Http\Controllers\Api_Controllers\vacancyApicontroller;
use App\Http\Controllers\PaymentApiController;
use App\Http\Controllers\CountryApiController;
use Illuminate\Routing\Router;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Router $router) {
    return collect($router->getRoutes()->getRoutesByMethod()["GET"])->map(function ($value, $key) {
        return url($key);
    })->values();
});

route::POST('storeproduct', [productApicontroller::class, 'store'])->name('storeproduct_details');
route::get('show/{id?}', [productApicontroller::class, 'show']);
route::GET('showproduct/{id?}', [productApicontroller::class, 'showdata'])->name('show_product_details');

route::delete('deleteproduct/{id}', [productApicontroller::class, 'deletedata'])->name('delete_product');
route::GET('list', [productApicontroller::class, 'list']);


route::post('update/{id}', [productApicontroller::class, 'updatedata'])->name('update_product');

route::POST('createcoupen', [coupanApicontroller::class, 'create'])->name('create_coupen');
route::POST('checkcoupen/{id}', [coupanApicontroller::class, 'coupencheck'])->name('coupen_check');
route::delete('deletecoupen/{id}', [coupanApicontroller::class, 'deletecoupen'])->name('coupen_delete');
route::post('updatecoupen/{id}', [coupanApicontroller::class, 'updatecoupen'])->name('coupen_update');
route::get('showcoupen/{type?}', [coupanApicontroller::class, 'showcoupen'])->name('coupen_show');


route::POST('storeuserdata/{id}', [userdataApicontroller::class, 'store'])->name('store_userdata');
route::GET('showuserdata/{type?}', [userdataApicontroller::class, 'show'])->name('show_userdata');


Route::post('paymentstatus/{id}{product_id}', [userdataApicontroller::class, 'update_payment_status'])->name('update_payment_status');

Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('register', [UserController::class, 'register']);


route::middleware('auth:api')->group(function () {
    Route::GET('logout', [usercontroller::class, 'logout']);
    Route::GET('details', [Usercontroller::class, 'details'])->name('user_details');
});


route::post('candidateform/{id}', [userdataApicontroller::class, 'candidateform']);
route::get('showcandidate', [userdataApicontroller::class, 'showcandidate']);

route::post('addvacancy', [vacancyApicontroller::class, 'addvacancy']);
route::get('showvacancy/{type?}', [vacancyApicontroller::class, 'showvacancy']);
route::delete('deletevacancy/{id}', [vacancyApicontroller::class, 'deletevacancy']);
route::post('updatevacancy/{id}', [vacancyApicontroller::class, 'updatevacancy']);

route::post('contactdetails', [ContactusApicontroller::class, 'storecontactus']);
route::get('showcontactus/{type?}', [ContactusApicontroller::class, 'showcontactus']);


route::post('changepassword', [usercontroller::class, 'changepassword'])->name('change_password');

Route::post('forgotpassword', [usercontroller::class, 'forgotpassword'])->name('admin.forgotpassword');
Route::post('otpverify', [usercontroller::class, 'otpverify'])->name('admin.otp_verify');


// Routes  of location 


Route::get('countries', [CountryApiController::class, 'show']);
Route::get('countries/{id}', [CountryApiController::class, 'single']);

route::get('states', [StatApiController::class, 'show']);
route::get('states/{id}', [StatApiController::class, 'single']);
route::get('states_of_country/{stateid}', [StatApiController::class, 'countrywise']);
route::get('cities', [cityapicontroller::class, 'show']);
route::get('cities/{id}', [cityapicontroller::class, 'single']);
route::get('cities_of_state/{stateid}', [cityapicontroller::class, 'statewise']);






route::post('payment/{id}', [PaymentApiController::class, 'payments']);
route::post('paymentstatusupdate', [PaymentApiController::class, 'updatestatus']);
route::post('showpayment_product_details/{id}', [PaymentApiController::class, 'payment_product_details']);
route::get('showpayment_details/{type?}', [PaymentApiController::class, 'showpayment']);


Route::post('storefestival',[FestivalApicontroller::class,'storefestival']);
Route::get('showfestival',[FestivalApicontroller::class,'readallfestival']);
Route::get('showfestival/{id}',[FestivalApicontroller::class,'showfestival']);
Route::post('updatefestival/{id}',[FestivalApicontroller::class,'updatefestival']);
Route::delete('deletefestival/{id}',[FestivalApicontroller::class,'deletefestival']);


Route::post('storecreative',[FestivalApicontroller::class,'storecreative']);
Route::get('showcreatives',[FestivalApicontroller::class,'readallcreatives']);
Route::get('showcreative/{id}',[FestivalApicontroller::class,'showcreative']);
Route::post('updatecreative/{id}',[FestivalApicontroller::class,'updatecreative']);
Route::delete('deletecreative/{id}',[FestivalApicontroller::class,'deletecreative']);

