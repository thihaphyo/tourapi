<?php

namespace App\Http\Controllers\OrderControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class OrderEntryController extends Controller
{


    private $order_uniq_id;
    private $order_date;
    private $order_item = array();
    private $cust_name;
    private $cust_ph;
    private $cust_address;
    private $current_status_id;
    private $remark;
    private $postcode;
    private $master_array=array();
    protected $view;
    protected $CommonFunction;
    protected $status;

    function __construct()
    {
        parent::__construct();
        $this->view = "Order.OrderEntry";
        $this->CommonFunction = new CommonFunctions;
    }

    public function index(){

        try{

            $sql = "SELECT
                    tbl_book.book_name as book_name,
                    tbl_book.Price as price 
                    FROM tbl_book
                    ORDER BY tbl_book.book_uniq_idx DESC";

            $res = DB::select($sql);

            $last_id = "SELECT
                        COUNT(*) as count
                        FROM tbl_order";



            $this->order_uniq_id=DB::select($last_id);

            $this->order_uniq_id = $this->CommonFunction->AutoGenerateOrderID($this->order_uniq_id[0]->count+1);

            $this->master_array = array('book_data' => $res,'auto_id' => $this->order_uniq_id);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }
        catch (\Exception $exception)
        {
            return json_encode("View Not Found");
        }

    }
}
