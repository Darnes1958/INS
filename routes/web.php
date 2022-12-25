<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\jeha\customercontroller;
use App\Http\Controllers\bank\BankReportsController;
use App\Http\Controllers\buy\OrderBuyController;
use App\Http\Controllers\sell\OrderSellController;
use App\Http\Controllers\aksat\AksatController;
use App\Http\Controllers\aksat\RepAksatController;
use App\Http\Controllers\RepAmaaController;
use App\Http\Controllers\trans\TransController;
use App\Http\Controllers\Aksat\OverTarController;
use App\Http\Controllers\Stores\StoresController;
use App\Http\Controllers\PasswordController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home',function () {    return view('admin.index');});

Route::controller(AdminController::class)->group(function (){
    route::get('/admin/logout', 'destroy')->name('admin.logout') ;
    route::get('/admin/profile', 'Profile')->name('admin.profile') ;
    route::get('/edit/profile', 'EditProfile')->name('edit.profile')->middleware('auth');
    route::post('/store/profile', 'StoreProfile')->name('store.profile')->middleware('auth') ;
});
Route::controller(AKsatController::class)->group(function (){
  route::get('/kst/input', 'InpKst')->name('kst.input')->middleware('auth') ;
  route::get('/haf/input', 'InpHaf')->name('haf.input')->middleware('auth') ;
  route::get('/main/input/{NewOld}', 'MainInp')->name('main.input')->middleware('auth') ;
  route::get('/main/Edit/{EditDel}', 'MainEdit')->name('main.edit')->middleware('auth') ;

});
Route::controller(OverTarController::class)->group(function (){
  route::get('/overtar/inpover/{Proc}', 'OverInp')->name('over.input')->middleware('auth') ;

});
Route::controller(PasswordController::class)->group(function (){
    route::get('/pass/edit', 'EditPass')->name('pass.edit')->middleware('auth') ;

});
Route::controller(TransController::class)->group(function (){
  route::get('/trans/input}', 'TransInp')->name('trans.input')->middleware('auth') ;
});
Route::controller(RepAksatController::class)->group(function (){
  route::get('/repMain/all', 'RepMain')->name('repmain.all')->middleware('auth');
  route::get('/repMain/arc', 'RepMainArc')->name('repmain.arc')->middleware('auth') ;

  route::get('/rep/okod/{rep}', 'RepOkod')->name('rep.okod')->middleware('auth') ;

});
Route::controller(RepAmaaController::class)->group(function (){
  route::get('/repamma/{rep}', 'RepAmma')->name('repamma')->middleware('auth');
});

Route::controller(CustomerController::class)->group(function (){
    route::get('/customer/all', 'CustomerAll')->name('customer.all')->middleware('auth') ;
    route::get('/customer/add', 'CustomerAdd')->name('customer.add')->middleware('auth') ;
    route::post('/customer/store', 'CustomerStore')->name('customer.store')->middleware('auth') ;
    route::get('/customer/edit/{jeha_no}', 'CustomerEdit')->name('customer.edit')->middleware('auth') ;
    route::post('/customer/update', 'CustomerUpdate')->name('customer.update')->middleware('auth') ;
    route::get('/customer/delete{jeha_no}', 'CustomerDelete')->name('customer.delete')->middleware('auth') ;
    route::get('/search_customerall','SearchCustomerall')->name('search-customerall')->middleware('auth');

});
Route::controller(BankReportsController::class)->group(function (){
    route::get('/rep_banks/sum', 'Rep_Banks')->name('rep_banks.sum')->middleware('auth') ;
    route::get('/pagi_rep_bank/{bankno}','PagiRepBank')->name('pagi-rep_bank')->middleware('auth');
    route::get('/search_rep_bank','SearchRepBank')->name('search-rep_bank')->middleware('auth');
});

Route::controller(OrderBuyController::class)->group(function (){
    route::get('order_buy',  App\Http\Livewire\buy\OrderBuyAdd::class)->name('order_buy')->middleware('auth') ;
    route::get('/get-items-in-store','GetItemsInStore')->name('get-items-in-store')->middleware('auth');
    route::get('/order_buy/add','OrderBuy')->name('order_buy.add')->middleware('auth');
    route::get('/order_buy/edit','OrderBuyEdit')->name('order_buy.edit')->middleware('auth');
});
Route::controller(OrderSellController::class)->group(function (){
     route::get('/order_sell/add/{price_type}','OrderSell')->name('order_sell.add')->middleware('auth');
     route::get('/order_sell/edit','OrderSellEdit')->name('order_sell.edit')->middleware('auth');
});
Route::controller(StoresController::class)->group(function (){
  route::get('/stores/add/{from_to}','StoresAdd')->name('stores.add')->middleware('auth');

});


