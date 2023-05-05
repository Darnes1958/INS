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
use App\Http\Controllers\pdfController;
use App\Http\Livewire\Buy\RepOrderBuy;
use App\Http\Controllers\Masr\MasrController;
use App\Http\Controllers\bank\BankController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\email\EmailPdf;
use App\Http\Controllers\Exls\ExController;
use \App\Http\Controllers\ZipController;
use App\Http\Controllers\Salary\SalaryController;
use App\Http\Controllers\Tar\TarController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('downzip', [ZipController::class, 'build'])->name('downzip');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::controller(ExController::class)->group(function () {
    Route::get('mosdadaex/{bank?},{baky?}', 'MosdadaEx')->name('mosdadaex');
    Route::get('khamlaex/{bank?},{months?}', 'KhamlaEx')->name('khamlaex');
    Route::get('repmakex/{place_type?},{place_no?},{withzero?}', 'RepMakEx')->name('repmakex');

});
Route::controller(EmailPdf::class)->group(function () {
    Route::get('send-mail', 'KlasaPdf')->name('sendmail');
});
Route::get('status', [UserController::class, 'userOnlineStatus']);

Route::get('/home',function () {    return view('admin.index');});

Route::get('/livewirerep/',[RepOrderBuy::class,'printView'])->name('livego');

Route::controller(ExcelController::class)->group(function (){

  route::get('/impfromsheet/{filename?}/{TajNo?}', 'ImportFromSheet')->name('impfromsheet')->middleware('auth');
  route::get('/impfromsheet2/{filename?}/{TajNo?}', 'ImportFromSheet2')->name('impfromsheet2')->middleware('auth');
});



Route::controller(pdfController::class)->group(function (){
    route::get('/reporderbuypdf/{order_no?}/{jeha_name?}/{place_name?}', 'RepOrderPdf')->name('reporderbuypdf') ;
    route::get('/repordersellpdf/{order_no?}/{jeha_name?}/{place_name?}', 'RepOrderSellPdf')->name('repordersellpdf') ;
    route::get('/pdfmosdada/{bank_no?}/{baky?}/{bank_name?}', 'PdfMosdada')->name('pdfmosdada') ;
    route::get('/dobackup', 'DoBackup')->name('dobackup') ;
    route::get('/dodownload', 'DoDownload')->name('dodownload') ;

});
Route::controller(AdminController::class)->group(function (){
  route::get('/admin/logout', 'destroy')->name('admin.logout') ;
  route::get('/admin/profile', 'Profile')->name('admin.profile') ;
  route::get('/edit/profile', 'EditProfile')->name('edit.profile')->middleware('auth');
  route::post('/store/profile', 'StoreProfile')->name('store.profile')->middleware('auth') ;

  route::get('/manager', 'ManagerPage')->name('manager')->middleware('auth') ;
  route::get('/oper', 'RepOper')->name('oper')->middleware('auth') ;
  route::get('/SeeWelcomePage', 'SeeWelcomePage')->name('SeeWelcomePage')->middleware('auth') ;
});
Route::controller(AKsatController::class)->group(function (){
  route::get('/kst/input', 'InpKst')->name('kst.input')->middleware('auth') ;
  route::get('/kst2/input', 'InpKst2')->name('kst2.input')->middleware('auth') ;
  route::get('/haf/input', 'InpHaf')->name('haf.input')->middleware('auth') ;
  route::get('/main/input/{NewOld}', 'MainInp')->name('main.input')->middleware('auth') ;
  route::get('/main/Edit/{EditDel}', 'MainEdit')->name('main.edit')->middleware('auth') ;



});
Route::controller(MasrController::class)->group(function (){
  route::get('/inpmasr', 'MasrInp')->name('inpmasr')->middleware('auth') ;

});
Route::controller(SalaryController::class)->group(function (){
  route::get('/inpsalary', 'SalaryInp')->name('inpsalary')->middleware('auth') ;
  route::get('/idrajsalary', 'IdrajSalary')->name('idrajsalary')->middleware('auth') ;
  route::get('/salarytrans', 'SalaryTrans')->name('salarytrans')->middleware('auth') ;
  route::get('/salarysaheb', 'SalarySaheb')->name('salarysaheb')->middleware('auth') ;
  route::get('/repsalary', 'RepSalary')->name('repsalary')->middleware('auth') ;
  route::get('/repsaltran', 'RepSalTran')->name('repsaltran')->middleware('auth') ;

});

Route::controller(OverTarController::class)->group(function (){
    route::get('/overtar/inpover/{Proc}', 'OverInp')->name('over.input')->middleware('auth') ;
    route::get('/stopkst2', 'StopKst2')->name('stopkst2')->middleware('auth') ;

});
Route::controller(PasswordController::class)->group(function (){
    route::get('/pass/edit', 'EditPass')->name('pass.edit')->middleware('auth') ;

});
Route::controller(TransController::class)->group(function (){
  route::get('/trans/input}', 'TransInp')->name('trans.input')->middleware('auth') ;
});
Route::controller(RepAksatController::class)->group(function (){
  route::get('/repMain/all', 'RepMain')->name('repmain.all')->middleware('auth');
  route::get('/repMainall', 'RepMainAll')->name('repmainall')->middleware('auth');
  route::get('/repMain/arc', 'RepMainArc')->name('repmain.arc')->middleware('auth') ;
  route::get('/rep/okod/{rep}', 'RepOkod')->name('rep.okod')->middleware('auth') ;
  route::get('/pdfmain/{no}', 'PdfMain')->name('pdfmain') ;
  route::get('/pdfbanksum/{RepChk?}/{date1?}/{date2?}', 'PdfBankSum')->name('pdfbanksum') ;
  route::get('/pdfplacesum/{RepChk?}/{date1?}/{date2?}', 'PdfPlaceSum')->name('pdfplacesum') ;
  route::get('/pdfhafmini/{hafitha?}/{rep_type?}/{DisRadio?}', 'PdfHafMini')->name('pdfhafmini') ;
  route::get('/pdfwrong/{bank_no?}/{wrong_date1?}/{wrong_date2?}/{bank_name?}', 'PdfWrong')->name('pdfwrong') ;
  route::get('/pdfkamla/{bank_no?}/{months?}/{bank_name?}', 'PdfKamla')->name('pdfkamla') ;
  route::get('/pdfstop/{bank_no?}/{stop_date1?}/{stop_date2?}/{bank_name?}', 'PdfStop')->name('pdfstop') ;
  route::get('/pdfstoponeall/{bank_no?}/{stop_date1?}/{stop_date2?}/{bank_name?}', 'PdfStopOneAll')->name('pdfstoponeall') ;
  route::get('/pdfstopone/{name?}/{bank_tajmeeh?}/{acc?}/{kst?}', 'PdfStopOne')->name('pdfstopone') ;
  route::get('/pdfbefore/{bank_no?}/{month?}/{bank_name?}/{Not_pay?}', 'PdfBefore')->name('pdfbefore') ;
  route::get('/pdfchk/{bank_name?}/{name?}/{acc?}/{chk_count?}/{wdate?}', 'PdfChk')->name('pdfchk') ;
  route::get('/pdfover/{bank_no?}/{over_date1?}/{over_date2?}/{bank_name?}/{Table?}/{letters?}', 'PdfOver')->name('pdfover') ;
  route::get('/pdftar/{bank_no?}/{tar_date1?}/{tar_date2?}/{bank_name?}/{tar_type?}', 'PdfTar')->name('pdftar') ;
  route::get('/pdfksm/{bank_no?}/{rep_date1?}/{rep_date2?}/{bank_name?}/{RepRadio?}', 'PdfKsm')->name('pdfksm') ;
  route::get('/pdfbankone/{bank_no?}/{column?}/{sort?}', 'PdfBankOne')->name('pdfbankone') ;
});
Route::controller(RepAmaaController::class)->group(function (){
  route::get('/repamma/{rep}', 'RepAmma')->name('repamma')->middleware('auth');
  route::get('/pdfklasa/{date1?}/{date2?}', 'PdfKlasa')->name('pdfklasa') ;
  route::get('/pdfklasamail/{company}', 'PdfKlasaMail')->name('pdfklasamail') ;
});

Route::controller(CustomerController::class)->group(function (){
    route::get('/customer/all', 'CustomerAll')->name('customer.all')->middleware('auth') ;
    route::get('/customer/add', 'CustomerAdd')->name('customer.add')->middleware('auth') ;
    route::post('/customer/store', 'CustomerStore')->name('customer.store')->middleware('auth') ;
    route::get('/customer/edit/{jeha_no}', 'CustomerEdit')->name('customer.edit')->middleware('auth') ;
    route::post('/customer/update', 'CustomerUpdate')->name('customer.update')->middleware('auth') ;
    route::get('/customer/delete{jeha_no}', 'CustomerDelete')->name('customer.delete')->middleware('auth') ;
    route::get('/search_customerall','SearchCustomerall')->name('search-customerall')->middleware('auth');
    route::get('/pdfjehatran/{jeha_no?}/{tran_date?}/{Mden?}/{MdenBefore?}/{Daen?}/{DaenBefore?}', 'PdfJehaTran')->name('pdfjehatran') ;
    route::get('/inpcust/{jeha_type}', 'InpCust')->name('inpcust')->middleware('auth') ;
    route::get('/pdfcustomer', 'PdfCustomer')->name('pdfcustomer')->middleware('auth') ;
    route::get('/pdfrepcustomer', 'PdfRepCustomer')->name('pdfrepcustomer')->middleware('auth') ;

});
Route::controller(BankController::class)->group(function (){

  route::get('/banksinput/{who}','BanksInput')->name('banksinput')->middleware('auth');
});
Route::controller(BankReportsController::class)->group(function (){
    route::get('/rep_banks/sum', 'Rep_Banks')->name('rep_banks.sum')->middleware('auth') ;

    route::get('/pagi_rep_bank/{bankno}','PagiRepBank')->name('pagi-rep_bank')->middleware('auth');
    route::get('/search_rep_bank','SearchRepBank')->name('search-rep_bank')->middleware('auth');

});

Route::controller(TarController::class)->group(function (){

    route::get('/tarbuy','TarBuy')->name('tarbuy')->middleware('auth');
});
Route::controller(OrderBuyController::class)->group(function (){
    route::get('order_buy',  App\Http\Livewire\buy\OrderBuyAdd::class)->name('order_buy')->middleware('auth') ;
    route::get('/get-items-in-store','GetItemsInStore')->name('get-items-in-store')->middleware('auth');
    route::get('/order_buy/add','OrderBuy')->name('order_buy.add')->middleware('auth');
    route::get('/order_buy/edit','OrderBuyEdit')->name('order_buy.edit')->middleware('auth');
    route::get('/order_buy/rep','OrderBuyRep')->name('order_buy.rep')->middleware('auth');
    route::get('/orderbuy','OrderBuy')->name('orderbuy')->middleware('auth');
});
Route::controller(OrderSellController::class)->group(function (){
     route::get('/order_sell/add/{price_type}','OrderSell')->name('order_sell.add')->middleware('auth');
     route::get('/order_sell/edit','OrderSellEdit')->name('order_sell.edit')->middleware('auth');
     route::get('/order_sell/rep','OrderSellRep')->name('order_sell.rep')->middleware('auth');
});
Route::controller(StoresController::class)->group(function (){
  route::get('/stores/add/{from_to}','StoresAdd')->name('stores.add')->middleware('auth');
  route::get('/pdfitemtran/{item_no?}/{item_name?}/{tran_date?}', 'PdfItemTran')->name('pdfitemtran') ;
  route::get('/itemprices','ItemPrices')->name('itemprices')->middleware('auth');
  Route::get('repmakpdf/{place_type?},{place_no?}', 'RepMakPdf')->name('repmakpdf');
  Route::get('repmakpdf2/{place_type?},{place_no?},{withzero?}', 'RepMakPdf2')->name('repmakpdf2');
  route::get('/jaradraseed','JaradRaseed')->name('jaradraseed')->middleware('auth');
  Route::get('repperpdf/{per_no}', 'RepPerPdf')->name('repperpdf');
});


