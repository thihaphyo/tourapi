<?php

namespace App\Http\Controllers\StatusControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class StatusEntryController extends Controller
{
    private $status_name;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;

    function __construct()
    {
        $this->view = "Status.StatusEntry";
        $this->CommonFunction = new CommonFunctions;

    }


    public function  index(){
        try{


            $this->master_array=array('publisher_data'=>null);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);


        }catch(\Exception $ex)
        {

        }
    }

    public function SaveStatus(Request $request)
    {
        $this->status_name = $request->get('status_name');


        try{
            $sql = "INSERT
                INTO tbl_status
                (status_name)
                VALUES(?)";

            DB::select($sql,[$this->status_name]);

            $this->status = true;

        }catch (\Exception $exception)
        {
            $this->status = false;
        }

        if($this->status)
        {
            \Session::flash('success','Successfully saved!');
            return redirect('GetStatusList');


        }else{
            \Session::flash('error','Error Occured during save process');
            return redirect()->back()->withInput();
        }
    }
}
