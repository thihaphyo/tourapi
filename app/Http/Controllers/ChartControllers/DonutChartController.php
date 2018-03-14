<?php

namespace App\Http\Controllers\ChartControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Exceptions\InvalidCellCount;
use Khill\Lavacharts\Exceptions\InvalidColumnType;
use Khill\Lavacharts\Exceptions\InvalidLabel;
use Khill\Lavacharts\Exceptions\InvalidRowDefinition;
use Khill\Lavacharts\Exceptions\InvalidRowProperty;
use Khill\Lavacharts\Lavacharts;
use DB;

class DonutChartController extends Controller
{
    function __construct()
    {
    }

    public function index(){

        $lava = new Lavacharts;

        $popularity = $lava->DataTable();

        $sql = "SELECT 
                COUNT(tbl_creditcard.operator) as total,
                (CASE WHEN tbl_creditcard.operator ='' THEN 'unknown' ELSE tbl_creditcard.operator END)as operator 
   	    	    FROM tbl_creditcard
   	    	    group by tbl_creditcard.operator";

        $res = DB::select($sql);

        try {
            $popularity->addStringColumn('Reasons')
                ->addNumberColumn('Percent');

            foreach ($res as $key=>$value)
            {
                $key = key($value);

                $popularity->addRow([$value->operator,$value->total]);
            }


        } catch (InvalidCellCount $e) {
        } catch (InvalidColumnType $e) {
        } catch (InvalidLabel $e) {
        } catch (InvalidRowDefinition $e) {
        } catch (InvalidRowProperty $e) {
        }




        $lava->DonutChart('DONUT', $popularity);


        return view('donut_chart_view',compact('lava'));
    }
}
