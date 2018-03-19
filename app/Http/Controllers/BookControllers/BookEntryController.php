<?php

namespace App\Http\Controllers\BookControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BookEntryController extends Controller
{
    
    private $book_uniq_id;
    private $book_name;
    private $author_id;
    private $price;
    private $view;
    private $master_array=array();
    protected $CommonFunction;
    protected $status;


    function __construct(){

    	$this->view = "Book.BookEntry";
        $this->CommonFunction = new CommonFunctions;


    }

    public function index(){

    	try{

            \Session::put('CurrentPage','bookEntry');

    	    $sql = "SELECT 
                    publisher.idx,
                    publisher.name
                    FROM publisher";

    	    $publisher = DB::select($sql);

    		$this->master_array=array('publisher_data'=>$publisher);

            return $this->CommonFunction->Redirect($this->view,$this->master_array);


    	}catch(\Exception $ex)
    	{

    	}
    }

    public function SaveBook(Request $request)
    {

        $this->book_uniq_id = $request->get('book_id');
        $this->book_name = $request->get('book_name');
        $this->author_id = $request -> get('author_id');
        $this->price = $request->get('book_price');

        try{
            DB::beginTransaction();

            $sql = "INSERT
                INTO tbl_book
                (publisher_id,book_uniq_idx,Price,book_name)
                VALUES(?,?,?,?)";

            DB::select($sql,[$this->author_id,$this->book_uniq_id,$this->price,$this->book_name]);

            DB::commit();

            $this->status = true;

        }catch (\Exception $exception)
        {
            DB::rollback();

            $this->status = false;
        }

        if($this->status)
        {
            \Session::flash('success','Successfully saved!');
            return redirect('BookListing');


        }else{
            \Session::flash('error','Error Occured during save process');
            return redirect()->back()->withInput();
        }



    }
}
