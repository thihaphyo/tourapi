<?php

namespace App\Http\Controllers\StatusControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class StatusUpdateController extends Controller
{
    private $status_id;
    private $status_name;
    private $view;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;

    function __construct()
    {
        $this->view = "Status.StatusUpdate";
        $this->CommonFunction = new CommonFunctions;


    }

    public function  index(Request $request){

        try{


            \Session::put('CurrentPage','statusEntry');

            $this->status_id = $request->get('id');

            $sql = "SELECT * FROM tbl_status WHERE tbl_status.idx = ?";

            $res=DB::select($sql,[$this->status_id]);


            $this->master_array = array('Status_data' => $res[0]);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {
            return json_encode($exception->getMessage());
        }



    }

    public function Update(Request $request)
    {
        try{

            $this->status_id = $request->get('hddStatusIDX');
            $this->status_name = $request->get('status_name');

            DB::beginTransaction();

            $sql = "UPDATE
                    tbl_status
                    SET tbl_status.status_name=?
                    WHERE tbl_status.idx = ?";

            DB::select($sql,[$this->status_name,$this->status_id]);

            DB::commit();

            $this->status = true;

            return redirect('GetStatusList');


        }catch (\Exception $exception)
        {
            DB::rollback();

            $this->status = false;
            return redirect()->back()->withInput();

        }
    }
}
