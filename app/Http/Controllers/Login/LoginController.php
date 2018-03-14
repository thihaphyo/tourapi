<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CommonFunctions;
use App\Models\UserModel;
use DB;
use PhpParser\Builder\Declaration;

class LoginController extends Controller
{
    /**
     * @var Declaration
     */
    private $view;
    private $master_array=array();
    private $CommonFunctions;

    /**
     * To Show Login View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->CommonFunctions  = new CommonFunctions;

        $this->view="Login";

        return $this->CommonFunctions->Redirect($this->view,$this->master_array);
    }

    /**
     * Perform Login Check & Redirect
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function Login(Request $request){

        try{

            $username = $request -> get('username');
            $password = md5($request->get('password'));

            $res = DB::table('tbl_user')
                       ->where('username',$username)
                       ->where('password',$password)
                       ->get();

           if(count($res) > 0)
           {
               \Session::put('User',$res);
               return redirect('Dashboard');
           }else{
               \Session::flash('Err','Wrong Username or Password.');
               return redirect()->back();
           }

        }catch (\Exception $exception)
        {
            return response()->view('errors.500', [], 500);
        }

    }

    /**
     * Sign Out
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function SignOut()
    {
      try{
               \Session::flush('User');
               return redirect('/');

        }catch (\Exception $exception)
        {
            return response()->view('errors.500', [], 500);
        }
    }
}
