<?php

namespace App\Http\Controllers\BookControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BookUpdateController extends Controller
{
    private $book_idx;
    private $book_uniq_id;
    private $book_name;
    private $author_id;
    private $price;
    private $view;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;

    function __construct()
    {
        $this->view = "Book.BookUpdate";
        $this->CommonFunction = new CommonFunctions;

    }

    public function BookUpdate(Request $request)
    {
        try{


            $book_id = $request->get('id');

            $sql = "SELECT 
                    tbl_book.idx,
                    tbl_book.book_uniq_idx,
                    tbl_book.book_name,
                    tbl_book.publisher_id,
                    tbl_book.Price as price
                    from tbl_book
                    WHERE book_uniq_idx = ?
                    LIMIT 1";


            $res = DB::select($sql,[$book_id]);

            $sql = "SELECT 
                    publisher.idx,
                    publisher.name
                    FROM publisher";

            $publisher = DB::select($sql);


            $this->master_array=array('book_data'=>$res[0],'publisher_data' => $publisher);


            return $this->CommonFunction->Redirect($this->view,$this->master_array);

        }catch (\Exception $exception)
        {
            return json_encode('500 Error');
        }
    }


    public function Upadte(Request $request)
    {
        try{

            $this->book_idx = $request->get('hddBookIDX');
            $this->book_uniq_id = $request->get('book_id');
            $this->book_name = $request -> get('book_name');
            $this->author_id = $request->get('author_id');
            $this->price = $request->get('book_price');


            $sql = "UPDATE
                    tbl_book
                    SET tbl_book.book_uniq_idx=?,
                        tbl_book.book_name = ?,
                        tbl_book.publisher_id = ?,
                        tbl_book.Price = ?
                    WHERE tbl_book.idx = ?";

          DB::select($sql,[$this->book_uniq_id,$this->book_name,$this->author_id,$this->price,$this->book_idx]);

          $this->status = true;

          return redirect('BookListing');


        }catch (\Exception $exception)
        {

            $this->status = false;
            return redirect()->back()->withInput();

        }
    }
}
