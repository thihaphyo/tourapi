<?php

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

Route::get('/','Login\LoginController@Index');

Route::get('DailyQuestion','ReportControllers\DailyQuestionController@Index')->middleware('user_check');

Route::post('DailyQuestionCount','ReportControllers\DailyQuestionController@Search')->middleware('user_check');

Route::get('DailyQuestionCount','ReportControllers\DailyQuestionController@Search')->middleware('user_check');

Route::get('GetDailyQuestionCount','ReportControllers\DailyQuestionController@LoadData')->middleware('user_check');


Route::post('LoginCheck','Login\LoginController@Login');

Route::get('admin',function(){
		return view('admin');
});


Route::get('DailyPhoneTopUp','ReportControllers\DailyTopUpController@Index')->middleware('user_check');

Route::get('SignOut','Login\LoginController@SignOut');

Route::get('GetDailyTopUpCount','ReportControllers\DailyTopUpController@LoadData')->middleware('user_check');


Route::get('TestChart','ChartController@chart');

Route::get('test_data','ChartController@response');

Route::get('LoadChart','ChartController@chart');

Route::get('PieChart','ChartControllers\PieChartController@index');

Route::get('GeoChart','ChartControllers\GeoChartController@index');

Route::get('DonutChart','ChartControllers\DonutChartController@index');

Route::get('ComboChart','ChartControllers\ComboChartController@index');

Route::get('Dashboard',function(){
	return view('Dashboard');
});


Route::get('BookEntry','BookControllers\BookEntryController@index');

Route::post('BookSave','BookControllers\BookEntryController@SaveBook');

Route::get('BookListing','BookControllers\BookListingController@index');

Route::get('GetBookList' , 'BookControllers\BookListingController@LoadBook');

Route::get('BookUpdate','BookControllers\BookUpdateController@BookUpdate');

Route::post('UpdateBook','BookControllers\BookUpdateController@Upadte');

Route::get('GetStatusList','StatusControllers\StatusListingController@index');

Route::get('GetStatus','StatusControllers\StatusListingController@LoadStatus');

Route::get('StatusEntry','StatusControllers\StatusEntryController@index');

Route::post('StatusSave','StatusControllers\StatusEntryController@SaveStatus');

Route::get('StatusUpdate','StatusControllers\StatusUpdateController@index');

Route::post('UpdateStatus','StatusControllers\StatusUpdateController@Update');

Route::get('OrderEntry','OrderControllers\OrderEntryController@index');

Route::post('OrderSave','OrderControllers\OrderEntryController@Save');

Route::get('OrderListing','OrderControllers\OrderListingController@index');

Route::get('GetOrderList','OrderControllers\OrderListingController@LoadOrder');

Route::get('OrderUpdate','OrderControllers\OrderUpdateController@index');

Route::get('CustUpdate','OrderControllers\OrderUpdateController@UpdateCustomerInfo');

Route::get('ItemUpdate','OrderControllers\OrderUpdateController@UpdateItemInfo');
