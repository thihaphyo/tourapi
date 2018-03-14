<?php

namespace App\Http\Controllers\BookControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class BookListingController extends Controller
{

    private $view;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;

    function __construct()
    {
        $this->view = "Book.BookListing";
        $this->CommonFunction = new CommonFunctions;

    }

    public function index(){

        try{
            $this->master_array=array('book_data'=>null);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {
            return json_encode('500 Error');
        }
    }

    public function LoadBook(Request $request)
    {
        try{

            $sql = "SELECT 
                    tbl_book.book_uniq_idx as book_id,
                    tbl_book.book_name as book_name,
                    publisher.name as pub_name,
                    tbl_book.Price as price
                    FROM tbl_book
                    INNER JOIN publisher 
                    ON tbl_book.publisher_id = publisher.idx
                    ";

            $res = DB::select($sql);


            $datatables =  Datatables::of($res)->addColumn('action', function ($result) {
                return '<a id="#'.$result->book_id.'" href="BookUpdate?id='.$result->book_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })->editColumn('book_id', '{{$book_id}}');

            return $datatables->make(true);

        }catch (\Exception $exception)
        {

            return json_encode('500 Error');
        }

    }
}
