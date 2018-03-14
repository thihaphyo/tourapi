<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Exceptions\InvalidCellCount;
use Khill\Lavacharts\Exceptions\InvalidColumnType;
use Khill\Lavacharts\Exceptions\InvalidLabel;
use Khill\Lavacharts\Exceptions\InvalidRowDefinition;
use Khill\Lavacharts\Exceptions\InvalidRowProperty;
use Khill\Lavacharts\Lavacharts;
use DB;


class ChartController extends Controller
{
  

	public function chart(){

	$sql = "SELECT COUNT(*) as total,
			SUM(CASE WHEN tbl_creditcard.operator = 'Ooreedoo' OR tbl_creditcard.operator = 'Ooredoo' THEN 1 ELSE 0 END) ooredoo_pay,
            SUM(CASE WHEN tbl_creditcard.operator = 'MPT' THEN 1 ELSE  0 END) mpt_pay,
            SUM(CASE WHEN  tbl_creditcard.operator = 'Telenor' THEN 1 ELSE 0 END) telenor_pay,
            SUM(CASE WHEN tbl_creditcard.operator = ' ' THEN 1 ELSE 0 END) unknown_pay,
			DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') as date_date
   	    	FROM tbl_creditcard
   	    	group by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d')
   	    	order by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') DESC";

   	$res = DB::select($sql);	



    $lava = new Lavacharts; 


	$popularity = $lava->DataTable();
    $data = $res;


        try {
            $popularity->addStringColumn('date_date')
                ->addNumberColumn('total')
                ->addNumberColumn('Ooredoo')
                ->addNumberColumn('MPT')
                ->addNumberColumn('Telenor')
                ->addNumberColumn('Unknown');
        } catch (InvalidColumnType $e) {
        } catch (InvalidLabel $e) {
        }

        foreach ($data as $key => $value)
    {

        try {
            $popularity->addRow([$value->date_date, $value->total, $value->ooredoo_pay, $value->mpt_pay, $value->unknown_pay]);
        } catch (InvalidCellCount $e) {
        } catch (InvalidRowDefinition $e) {
        } catch (InvalidRowProperty $e) {
        }
    }




	$lava->LineChart('Temps', $popularity, ['title' => 'Weather in October']);


    return view('chart_view',compact('lava'));
    
    
      
   }


   public function response(){

   	    $sql = "SELECT COUNT(*) as total
   	    		FROM tbl_creditcard
   	    		group by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d')";

   	    $res = DB::select($sql);

   		// $chart = new SampleChart;
   		// $chart->dataset('Sample Test','line',[1,4,3])->color('#00ff00');
   		//$chart ->dataset('Sample Test2','line',[1,4,3])->color('#ff0000');

   		//$chart -> database($res,'bar')->title("Chart")->elementLabel("Test")->groupByMonth(date('Y'),true);



   		return $chart->api();
   }
//    public function response()
//  {
//   $chart = new SampleChart;
//   $chart->dataset('Sample Test', 'bar', [3,4,1])->color('#00ff00');
//   $chart->dataset('Sample Test', 'line', [1,4,3])->color('#ff0000');
//   return $chart->api();
//  }
}
