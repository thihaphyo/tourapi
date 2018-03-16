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
    private  $bookID;

    function __construct()
    {
        parent::__construct();
        $this->view = "Order.OrderEntry";
        $this->CommonFunction = new CommonFunctions;

    }

    public function index(){

        try{

            \Session::put('CurrentPage','orderEntry');

            $sql = "SELECT
                    tbl_book.book_uniq_idx as book_id,
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


    public function Save(Request $request)
    {

//        dd(json_decode(DB::table('tbl_order')->select('order_item')->get()->toArray()[0]->order_item));

       try{


           $this->bookID=$request->get('hddBookID');
           $book_arr = $request->get('hddBookName');
           $book_price = $request->get('hddBookPrice');

           for($i=0;$i<sizeof($book_arr);$i++)
           {
               $json_array[]=array($book_arr[$i]=>$book_price[$i]);
           }

           for ($z =0; $z < sizeof($json_array);$z++)
           {
               $json_array2[]=array($this->bookID[$z]=>$json_array[$z]);

           }


           $this->order_uniq_id = $request->get('hddOrderUniqID');
           $this->order_date = $request->get('dateRange');
           $this->order_item = json_encode($json_array2);
           $this->cust_name = $request->get('cust_name');
           $this->cust_ph = $request->get('cust_phone');
           $this->cust_address = $request->get('cust_address');
           $this->remark = $request->get('cust_remark');
           $this->current_status_id = 0;
           $this->postcode = 0;



           $sql = "INSERT INTO
                tbl_order
                (order_uniq_idx, order_date, order_item, cust_name, cust_ph, cust_address, current_status_id, remark, e_postcode)
                VALUES(?,?,?,?,?,?,?,?,?)";

           DB::select($sql,[$this->order_uniq_id,strtotime($this->order_date),$this->order_item,$this->cust_name,$this->cust_ph,$this->cust_address,$this->current_status_id,$this->remark,$this->postcode]);

           $log_sql = "INSERT INTO
                    tbl_status_log
                    (order_id, status_id, status_changed_time)
                    VALUES (?,?,?)";

           DB::select($log_sql,[$this->order_uniq_id,$this->current_status_id,strtotime('now')]);

           $order_sql = "INSERT INTO
                         tbl_order_log
                         (order_id, book_uniq_idx, timetick)
                         VALUES(?,?,?)";

           foreach ($this->bookID as $key => $value)
           {
                DB::select($order_sql,[$this->order_uniq_id,$value,strtotime('now')]);
           }


           $this->status = true;


           return redirect('OrderListing');

       }catch (\Exception $exception)
       {
           dd($exception);
           $this->status=false;

           return json_encode($exception->getMessage());
       }



    }
}
