<?php

namespace App\Http\Controllers\ReportControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Log;
use PhpParser\Builder\Declaration;
use Yajra\DataTables\Facades\DataTables;

class DailyQuestionController extends Controller
{
    /**
     * @var Declaration
     */
    private $dateRange;
    private $startdate;
    private $enddate;
    private $view;
    private $master_array=array();
    protected $CommonFunction;

    /**
     * DailyQuestionController constructor.
     */
    function __construct() {
       $this->view = "DailyQuestionCount";
       $this->CommonFunction = new CommonFunctions;

    }

    /**
     * To Show DailyQuestionCount Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
      try{

          $this->master_array=array('DailyCount'=>null,'DateRange' => null);

          return $this->CommonFunction->Redirect($this->view,$this->master_array);

      }catch (\Exception $exception)
      {
          return json_encode('500 Error');
      }

    }

    /**
     * For Ajax Loading for Datatable
     * @param Request $request
     * @return Data Type JSON
     * @throws \Exception
     */
    public function LoadData(Request $request)
    {
        try{
            $this->dateRange = explode('-',$request->get('daterange'));
        
            $this->startdate = $this->CommonFunction->ChangeDateFormat(trim($this->dateRange[0]));

            $this->enddate =$this->CommonFunction->ChangeDateFormat(trim($this->dateRange[1]));


            $sql = "select count(*) as total,
                        DATE_FORMAT(FROM_UNIXTIME(tbl_question.question_date),'%Y/%m/%d') as question_date ,
                        sum(case when status = 0 then 1 else 0 end) as status_zero,
                        sum(case when status = 1 then 1 else 0 end) as status_one,
                        sum(case when status = 2 then 1 else 0 end) as status_two,
                        sum(case when status = 3 then 1 else 0 end) as status_three,
                        sum(case when status = 4 then 1 else 0 end) as status_four,
                        sum(case when status = 5 then 1 else 0 end) as status_five,
                        sum(case when status = 6 then 1 else 0 end) as status_six,
                        sum(case when status = 7 then 1 else 0 end) as status_seven,
                        sum(case when status = 8 then 1 else 0 end) as status_eight,
                        sum(case when status = 9 then 1 else 0 end) as status_nine,
                        sum(case when status = 10 then 1 else 0 end) as status_ten,
                        sum(case when status = 11 then 1 else 0 end) as status_eleven,
                        sum(case when status = 12 then 1 else 0 end) as status_twelve,
                        sum(case when status = 13 then 1 else 0 end) as status_thirteen,
                        sum(case when status = 14 then 1 else 0 end) as status_fourteen,
                        sum(case when status = 15 then 1 else 0 end) as status_fiftheen,
                        sum(case when status = 16 then 1 else 0 end) as status_sixtheen,
                        sum(case when status = 17 then 1 else 0 end) as status_seventheen
                        from `tbl_question`
                        where `question_date` 
                        between UNIX_TIMESTAMP(?) and UNIX_TIMESTAMP(?) 
                        group by DATE_FORMAT(FROM_UNIXTIME(tbl_question.question_date),'%Y/%m/%d')";

            $res = DB::select($sql,[$this->startdate,$this->enddate.' 23:59:59']);
                  
                     
            $datatables =  Datatables::of($res); 
            
            return $datatables->make(true); 
        }catch(\Exception $ex)
        {
                return json_encode('500 Error');
        }
                    
    }

    /**
     * Destructor
     */
    function  __destruct() {
       unset($this->dateRange,$this->view,$this->startdate,$this->enddate,$this->master_array,$this->CommonFunction);
    }
}