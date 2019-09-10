<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $user = User::create([
           // 'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $reaponseData['status'] = "success";
        $reaponseData['errors']= [];
        $reaponseData['result'] = $user;
        $reaponseData['result']['token']="Bearer ".$user->createToken("Laravel API")->accessToken;
        return response()->json(['data' => $reaponseData], 200);
    }
    protected function login(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $userdata = array(
            'email' => $data['email'] ,
            'password' => $data['password']
        );
          // attempt to do the login
        if (Auth::attempt($userdata))
        {
            $user = Auth::user();
            $reaponseData['status'] = "success";
            $reaponseData['errors']= [];
            $reaponseData['result'] = $user ;
            $reaponseData['result']['token']="Bearer ".$user->createToken("Laravel API")->accessToken;
            return response()->json(['data' => $reaponseData], 200);
        }
        else
        {
            $reaponseData['status'] = "fail";
            $reaponseData['errors']= [];
            $reaponseData['result'] = null;
            return response()->json(['data' => $reaponseData], 200);
        }
        
        
    }
    public function logout(Request $request){

        Log::debug("logout - ok");
        Log::debug($request);
        Log::debug($request->header('Authorization'));
       //echo $request->header('Authorization');
        //die("ok");
        ///dd($request->header('Authorization'));
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user()->token();
            $user->revoke();
            //Auth::guard('api')->user()->AauthAcessToken()->delete(); 
            $reaponseData['status'] = "success";
            $reaponseData['errors']= [];
            $reaponseData['result'] = true;
            //$reaponseData['result']['token']="Bearer ".$user->createToken("Laravel API")->accessToken;
            return response()->json(['data' => $reaponseData], 200);
        }else{
            $reaponseData['status'] = "fail";
            $reaponseData['errors']= [];
            $reaponseData['result'] = [];
            return response()->json(['data' => $reaponseData], 200);
        }
        
    }
	public function DashboardData(){
        
        //if(Auth::guard('api')->check()){
            $reaponseData['status'] = "success";
            $reaponseData['errors']= [];
            $reaponseData['result']['stats'] = [
                                        "EARNINGS_MONTHLY"=>"40,000",
                                        "EARNINGS_ANNUAL"=>"215,000",
                                        "TASKS"=>"50",
                                        "PENDING_REQUEST"=>"18",
                                    ];
           $reaponseData['result']['donut_stats']['options']    = [];
           $reaponseData['result']['donut_stats']['series']     = [44, 55, 41, 17, 15];
           $reaponseData['result']['chart_stats']['options']    = [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998];
           $reaponseData['result']['chart_stats']['series']     = [30, 40, 45, 50, 49, 60, 70, 91];
            return response()->json(['data' => $reaponseData], 200);
        /*}else{
            $reaponseData['status'] = "fail";
            $reaponseData['errors']= [];
            $reaponseData['result'] = [];
            return response()->json(['data' => $reaponseData], 200);
        }*/
		
	}

}
