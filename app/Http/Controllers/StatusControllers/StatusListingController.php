<?php

namespace App\Http\Controllers\StatusControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class StatusListingController extends Controller
{
    private $view;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;

    function __construct()
    {

        $this->view = "Status.StatusListing";
        $this->CommonFunction = new CommonFunctions;


    }

    public function index(){

        try{
            \Session::put('CurrentPage','statusListing');

            $this->master_array=array('book_data'=>null);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {
            return json_encode('500 Error');
        }
    }

    public function LoadStatus(Request $request){

        $sql = "SELECT * FROM tbl_status";

        $res=DB::select($sql);

        $datatables =  Datatables::of($res)->addColumn('action', function ($result) {
            return '<a id="#'.$result->idx.'" href="StatusUpdate?id='.$result->idx.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        });

        return $datatables->make(true);
    }
}
