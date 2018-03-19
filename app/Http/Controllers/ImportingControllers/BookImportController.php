<?php

namespace App\Http\Controllers\ImportingControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use DB;

class BookImportController extends Controller
{
    private $view;
    private $master_array=array();
    private $CommonFunction;

    function __construct()
    {
        parent::__construct();
        $this->view = "Importing.BookImportView";
        $this->CommonFunction = new CommonFunctions;

    }

    public function index(){

        \Session::put('CurrentPage','bookImport');

        return $this->CommonFunction->Redirect($this->view,$this->master_array);

    }


    public function Import(Request $request){


        $file = $request->file('file');
        $file_path = $file->getRealPath();

        $data = \Excel::load($file_path)->get();
        try{

        DB::beginTransaction();

        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = ['publisher_id' => $value->publisher_id, 'book_uniq_idx' => $value->book_uniq_idx,'price' => $value->price,'book_name' => $value->book_name];

                $sql = "SELECT book_uniq_idx FROM tbl_book WHERE book_uniq_idx = ?";

                $res = DB::select($sql,[$value->book_uniq_idx]);

                    if(count($res) > 0)
                    {
                        $sql = "UPDATE tbl_book 
                                SET
                                tbl_book.publisher_id=?,tbl_book.book_uniq_idx=?,tbl_book.Price=?,tbl_book.book_name=?
                                WHERE tbl_book.book_uniq_idx =?";

                        DB::select($sql,[$value->publisher_id,$value->book_uniq_idx,$value->price,$value->book_name,$value->book_uniq_idx]);

                    }else{
                        //TO INSERT
                        $sql = "INSERT INTO tbl_book(publisher_id, book_uniq_idx, Price, book_name) VALUES (?,?,?,?)";
                        DB::select($sql,[$value->publisher_id,$value->book_uniq_idx,$value->price,$value->book_name,$value->book_uniq_idx]);
                    }
            }

            DB::commit();

            return "Successfully Imported!";

        }

        }catch (\Exception $exception)
        {
            DB::rollback();
            return $exception->getMessage();
        }







    }
}
