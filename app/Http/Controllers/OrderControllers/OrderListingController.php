<?php

namespace App\Http\Controllers\OrderControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class OrderListingController extends Controller
{
    private $view;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;

    function __construct()
    {
        parent::__construct();
        $this->view = "Order.OrderListing";
        $this->CommonFunction = new CommonFunctions;


    }

    public function index(){

        try{

            \Session::put('CurrentPage','orderListing');

            $this->master_array=array('book_data'=>null);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {
            return json_encode('500 Error');
        }

    }

    public function LoadOrder(Request $request)
    {
        try{

            $sql = "SELECT
                    DISTINCT
                    tbl_order.order_uniq_idx as order_id,
                    DATE_FORMAT(FROM_UNIXTIME(tbl_order.order_date),'%Y/%m/%d') as order_date,
                    tbl_status.status_name as current_status,    
                    DATE_FORMAT(FROM_UNIXTIME(tbl_status_log.status_changed_time),'%Y/%m/%d') as status_date,
                    tbl_order.order_item as json_items,
                    JSON_LENGTH(tbl_order.order_item) as item_count,
                    JSON_EXTRACT(tbl_order.order_item,'$[*].price') as price
                    from tbl_order,tbl_status_log,tbl_status
                    WHERE tbl_order.order_uniq_idx = tbl_status_log.order_id
                    AND tbl_order.current_status_id = tbl_status_log.status_id
                    AND tbl_order.current_status_id = tbl_status.idx;
                    ";

            $res = DB::select($sql);


            foreach ($res as $key => $val)
            {
                $total = 0;
                $book_price= array_sum(json_decode($val->price));
                $total = $total+$book_price;
                $val->total_price=$total;

            }

            $datatables =  Datatables::of($res)->addColumn('action', function ($result) {
                return '<a id="#'.$result->order_id.'" href="OrderUpdate?id='.$result->order_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })->editColumn('order_id', '{{$order_id}}');

            return $datatables->make(true);

        }catch (\Exception $exception)
        {
            dd($exception->getMessage());
            return json_encode('500 Error');
        }
    }
}
