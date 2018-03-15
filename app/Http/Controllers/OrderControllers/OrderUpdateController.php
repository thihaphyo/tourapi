<?php

namespace App\Http\Controllers\OrderControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;



class OrderUpdateController extends Controller
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
    private  $bookID;

    function __construct()
    {
        parent::__construct();
        $this->view = "Order.OrderUpdate";
        $this->CommonFunction = new CommonFunctions;

    }

    public function index(Request $request){


        try{


            $this->order_uniq_id = $request->get('id');

            $sql = "SELECT
                    tbl_book.book_uniq_idx as book_id,
                    tbl_book.book_name as book_name,
                    tbl_book.Price as price 
                    FROM tbl_book
                    ORDER BY tbl_book.book_uniq_idx DESC";

            $res = DB::select($sql);

            $order_sql = "SELECT
                          tbl_order.order_item as item_arr,
                          DATE_FORMAT(FROM_UNIXTIME(tbl_order.order_date),'%Y/%m/%d') as order_date,
                          tbl_order.cust_name as cust_name,
                          tbl_order.cust_ph as cust_ph,
                          tbl_order.cust_address as cust_address,
                          tbl_order.remark as remark,
                          tbl_order.current_status_id as status_id,
                          tbl_order.e_postcode as postcode
                          FROM
                          tbl_order
                          WHERE tbl_order.order_uniq_idx=?";

            $order_res = DB::select($order_sql,[$this->order_uniq_id]);




            $order_log_sql = "SELECT
                              tbl_order_log.book_uniq_idx
                              FROM
                              tbl_order_log
                              WHERE tbl_order_log.order_id = ?";

            $order_log_res = DB::select($order_log_sql,[$this->order_uniq_id]);

            $status_log = "SELECT 
                           tbl_status_log.status_id as status_id,
                           DATE_FORMAT(FROM_UNIXTIME(tbl_status_log.status_changed_time),'%Y/%m/%d') as status_time
                           FROM tbl_status_log
                           WHERE tbl_status_log.order_id = ?";

            $status_log_res = DB::select($status_log,[$this->order_uniq_id]);

            $status_list = "SELECT * FROM tbl_status";

            $status_list = DB::select($status_list);



            $order_items = json_decode($order_res[0]->item_arr);

//            dd($order_items);

            $book_id_arr = '';
            $book_name_arr ='';
            $book_price_arr = '';

            foreach ($order_items as $key=>$val)
            {
                $book_id=key($val);
                $book_name =key($val->$book_id);
                $book_price = $val->$book_id->$book_name;
                $book_name_arr.=$book_name.',';
                $book_id_arr.=$book_id.',';
                $book_price_arr.=$book_price.',';
            }

            $book_id_arr=rtrim($book_id_arr,',');
            $book_name_arr=rtrim($book_name_arr,',');
            $book_price_arr=rtrim($book_price_arr,',');


            $this->master_array=array('book_data'=>$res,'order_id' => $this->order_uniq_id,'order_items'=>$order_items,'data'=>$order_res[0],'status_log'=>$status_log_res,'status_list'=>$status_list,'book_names'=>$book_name_arr,'book_ids'=>$book_id_arr,'book_prices'=>$book_price_arr);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {

        }
    }


    public function UpdateCustomerInfo(Request $request)
    {


        $order_uniq_id = $request->get('order_id');
        $cust_name = $request->get('cust_name');
        $cust_phone = $request->get('cust_phone');
        $cust_address = $request->get('cust_address');
        $remark = $request->get('remark');
        $postcode = $request->get('postcode');

        try{

            $sql = "UPDATE
                tbl_order
                SET 
                tbl_order.cust_name = ?,
                tbl_order.cust_ph = ?,
                tbl_order.cust_address = ?,
                tbl_order.remark = ?,
                tbl_order.e_postcode = ?
                WHERE order_uniq_idx = ?";

            DB::select($sql,[$cust_name,$cust_phone,$cust_address,$remark,$postcode,$order_uniq_id]);

            return json_encode("Success");

        }catch (\Exception $exception)
        {
            return json_encode("Error");
        }



    }


    public function UpdateItemInfo(Request $request){

        try{

            $this->bookID=explode(',',$request->get('book_ids'));
            $book_arr = explode(',',$request->get('book_names'));
            $book_price = explode(',',$request->get('book_prices')) ;
            $this->order_date = $request->get('order_date');
            $this->order_uniq_id = $request->get('order_id');

            for($i=0;$i<sizeof($book_arr);$i++)
            {
                $json_array[]=array($book_arr[$i]=>$book_price[$i]);
            }

            for ($z =0; $z < sizeof($json_array);$z++)
            {
                $json_array2[]=array($this->bookID[$z]=>$json_array[$z]);

            }

            $this->order_item = json_encode($json_array2);

            $sql = "UPDATE tbl_order 
                SET tbl_order.order_date = ? ,
                tbl_order.order_item = ?
                WHERE tbl_order.order_uniq_idx = ?";

            DB::select($sql,[strtotime($this->order_date),$this->order_item,$this->order_uniq_id]);

            $order_log_del_sql = "DELETE FROM tbl_order_log WHERE tbl_order_log.order_id = ?";

            DB::select($order_log_del_sql,[$this->order_uniq_id]);

            $order_sql = "INSERT INTO
                         tbl_order_log
                         (order_id, book_uniq_idx, timetick)
                         VALUES(?,?,?)";

            foreach ($this->bookID as $key => $value)
            {
                DB::select($order_sql,[$this->order_uniq_id,$value,strtotime('now')]);
            }

            return json_encode("Success");


        }catch (\Exception $exception)
        {
            return json_encode($exception->getMessage());
        }




    }
}
