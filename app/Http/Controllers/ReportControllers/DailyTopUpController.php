<?php

namespace App\Http\Controllers\ReportControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DailyTopUpController extends Controller
{
    /**
     * @var Declarations
     */
    private $dateRange;
    private $startdate;
    private $enddate;
    private $view;
    private $master_array=array();
    protected $CommonFunction;

    /**
     * DailyTopUpController constructor.
     */
    function __construct()
    {
        $this->view = "DailyTopUpView";
        $this->CommonFunction = new CommonFunctions;

    }

    /**
     * To Return DailyTopUpView
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(){

        try{
            $this->master_array=array('DailyCount'=>null,'DateRange' => null);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {
            return json_encode('500 Error');
        }

    }

    /**
     * Load the Daily Top-Up Count.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function LoadData(Request $request){

        try{


            DB::enableQueryLog();

            $this->dateRange = explode('-',$request->get('daterange'));

            $this->startdate = $this->CommonFunction->ChangeDateFormat(trim($this->dateRange[0]));

            $this->enddate =$this->CommonFunction->ChangeDateFormat(trim($this->dateRange[1]));


            $sql = "select count(*) as total,
                        DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d') as payment_date ,
                        SUM(CASE WHEN tbl_creditcard.operator = 'Ooreedoo' OR tbl_creditcard.operator = 'Ooredoo' THEN 1 ELSE 0 END) ooredoo_pay,
                        SUM(CASE WHEN tbl_creditcard.operator = 'MPT' THEN 1 ELSE  0 END) mpt_pay,
                        SUM(CASE WHEN  tbl_creditcard.operator = 'Telenor' THEN 1 ELSE 0 END) telenor_pay,
                        SUM(CASE WHEN tbl_creditcard.operator = ' ' THEN 1 ELSE 0 END) unknown_pay,
                        SUM(CASE WHEN tbl_creditcard.operator = 'MEC' THEN 1 ELSE 0 END) mec_pay
                        from `tbl_creditcard`
                        where `datetime` 
                        between UNIX_TIMESTAMP(?) and UNIX_TIMESTAMP(?)
                        group by DATE_FORMAT(FROM_UNIXTIME(tbl_creditcard.datetime),'%Y/%m/%d')";

            $res = DB::select($sql,[$this->startdate,$this->enddate.' 23:59:59']);


            $datatables =  Datatables::of($res);

            return $datatables->make(true);

        }catch (\Exception $exception)
        {
        	dd($exception);
            return json_encode('500 Error');
        }

    }

    /**
     * Destructor
     */
    function __destruct()
    {
        unset($this->dateRange,$this->view,$this->startdate,$this->enddate,$this->master_array,$this->CommonFunction);
    }


}
