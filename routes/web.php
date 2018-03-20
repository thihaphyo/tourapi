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
})->middleware('user_check');


Route::get('BookEntry','BookControllers\BookEntryController@index')->middleware('user_check');

Route::post('BookSave','BookControllers\BookEntryController@SaveBook')->middleware('user_check');

Route::get('BookListing','BookControllers\BookListingController@index')->middleware('user_check');

Route::get('GetBookList' , 'BookControllers\BookListingController@LoadBook')->middleware('user_check');

Route::get('BookUpdate','BookControllers\BookUpdateController@BookUpdate')->middleware('user_check');

Route::post('UpdateBook','BookControllers\BookUpdateController@Upadte')->middleware('user_check');

Route::get('GetStatusList','StatusControllers\StatusListingController@index')->middleware('user_check');

Route::get('GetStatus','StatusControllers\StatusListingController@LoadStatus')->middleware('user_check');

Route::get('StatusEntry','StatusControllers\StatusEntryController@index')->middleware('user_check');

Route::post('StatusSave','StatusControllers\StatusEntryController@SaveStatus')->middleware('user_check');

Route::get('StatusUpdate','StatusControllers\StatusUpdateController@index')->middleware('user_check');

Route::post('UpdateStatus','StatusControllers\StatusUpdateController@Update')->middleware('user_check');

Route::get('OrderEntry','OrderControllers\OrderEntryController@index')->middleware('user_check');

Route::post('OrderSave','OrderControllers\OrderEntryController@Save')->middleware('user_check');

Route::get('OrderListing','OrderControllers\OrderListingController@index')->middleware('user_check');

Route::get('GetOrderList','OrderControllers\OrderListingController@LoadOrder')->middleware('user_check');

Route::get('OrderUpdate','OrderControllers\OrderUpdateController@index')->middleware('user_check');

Route::get('CustUpdate','OrderControllers\OrderUpdateController@UpdateCustomerInfo')->middleware('user_check');

Route::get('ItemUpdate','OrderControllers\OrderUpdateController@UpdateItemInfo')->middleware('user_check');

Route::get('OrderStatusUpdate','OrderControllers\OrderUpdateController@UpdateStatusInfo')->middleware('user_check');

Route::get('GetStatusLog','OrderControllers\OrderUpdateController@GetStatusLog')->middleware('user_check');

Route::get('ExcelImport','ImportingControllers\BookImportController@index')->middleware('user_check');

Route::post('BookImport','ImportingControllers\BookImportController@Import')->middleware('user_check');
