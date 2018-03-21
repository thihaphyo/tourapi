<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/jsonData',function(){

	$sql = "SELECT COUNT(*) as total,
			SUM(CASE WHEN tbl_creditcard.operator = 'Ooreedoo' OR tbl_creditcard.operator = 'Ooredoo' THEN 1 ELSE 0 END) ooredoo_pay,
            SUM(CASE WHEN tbl_creditcard.operator = 'MPT' THEN 1 ELSE  0 END) mpt_pay,
            SUM(CASE WHEN  tbl_creditcard.operator = 'Telenor' THEN 1 ELSE 0 END) telenor_pay,
            SUM(CASE WHEN tbl_creditcard.operator = ' ' THEN 1 ELSE 0 END) unknown_pay,
			DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') as date_date
   	    	FROM tbl_creditcard
   	    	group by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d')
   	    	order by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') DESC";

   	$res = \DB::select($sql);

	$data = array('paymentlist' => $res);

	return json_encode($data);
});


Route::get('/GetHomeMenu',function(){
    $sql = "SELECT * FROM tbl_home_menu";

    $res = \DB::select($sql);

    return json_encode($res);
});

Route::get('/GetBeachTabs',function(){

    $sql = "SELECT tab_name FROM tbl_tabs WHERE activity_id = ?";

    $res = \DB::select($sql,['BeachActivity']);

    return json_encode($res);

});

Route::get('/GetSliderUrl',function(){

    $sql = "SELECT slider_url FROM tbl_slider WHERE silder_category = ?";

    $res = \DB::select($sql,['chaung_thar']);

    return json_encode($res,JSON_UNESCAPED_SLASHES);

});

Route::post('/CustUpdate','OrderControllers\OrderUpdateController@UpdateCustomerInfo');
