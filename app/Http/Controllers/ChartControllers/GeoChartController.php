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

class GeoChartController extends Controller
{
    function __construct()
    {
    }

    public function index(){


        $lava = new Lavacharts;

        $popularity = $lava->DataTable();

        $sql = "SELECT COUNT(*) as total 
                FROM tbl_creditcard";

        $res = DB::select($sql);

        try {
            $popularity->addStringColumn('Country')
                ->addNumberColumn('Top Up')
                ->addRow(array('Myanmar', $res[0]->total));

        } catch (InvalidCellCount $e) {
        } catch (InvalidColumnType $e) {
        } catch (InvalidLabel $e) {
        } catch (InvalidRowDefinition $e) {
        } catch (InvalidRowProperty $e) {
        }

        $lava->GeoChart('Popularity', $popularity);


        return view('geo_chart_view',compact('lava'));




    }
}
