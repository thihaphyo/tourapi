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

class ComboChartController extends Controller
{
    function __construct()
    {
    }

    public function index(){

        $lava = new Lavacharts; // See note below for Laravel

        $sql = "SELECT COUNT(*) as total,
			SUM(CASE WHEN tbl_creditcard.operator = 'Ooreedoo' OR tbl_creditcard.operator = 'Ooredoo' THEN 1 ELSE 0 END) ooredoo_pay,
            SUM(CASE WHEN tbl_creditcard.operator = 'MPT' THEN 1 ELSE  0 END) mpt_pay,
            SUM(CASE WHEN  tbl_creditcard.operator = 'Telenor' THEN 1 ELSE 0 END) telenor_pay,
            SUM(CASE WHEN tbl_creditcard.operator = ' ' THEN 1 ELSE 0 END) unknown_pay,
            SUM(CASE WHEN tbl_creditcard.operator = 'MEC' THEN 1 ELSE 0 END) mec_pay,
			DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') as date_date
   	    	FROM tbl_creditcard
   	        WHERE tbl_creditcard.datetime <> ''
   	    	group by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d')
   	    	order by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') DESC";

        $res = DB::select($sql);

//        dd($res);

        $finances = $lava->DataTable();

        try {
            $finances->addDateColumn('Year')
                ->addNumberColumn('Ooredoo')
                ->addNumberColumn('MPT')
                ->addNumberColumn('Telenor')
                ->addNumberColumn('MEC');

            foreach ($res as $key=>$value)
            {

                $finances->addRow([$value->date_date,$value->ooredoo_pay,$value->mpt_pay,$value->telenor_pay,$value->mec_pay]);
            }

        } catch (InvalidCellCount $e) {
        } catch (InvalidColumnType $e) {
        } catch (InvalidLabel $e) {
        } catch (InvalidRowDefinition $e) {
        } catch (InvalidRowProperty $e) {
        }

        $lava->ComboChart('Finances', $finances, [
            'title' => 'Company Performance',
            'titleTextStyle' => [
                'color'    => 'rgb(123, 65, 89)',
                'fontSize' => 16
            ],
            'legend' => [
                'position' => 'in'
            ],
            'seriesType' => 'line'
        ]);

        return view('combo_chart_view',compact('lava'));
    }
}
