<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
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
        
        Auth::guard('api')->user()->AauthAcessToken()->delete(); 
        $reaponseData['status'] = "success";
        $reaponseData['errors']= [];
        $reaponseData['result'] = $user;
        $reaponseData['result']['token']="Bearer ".$user->createToken("Laravel API")->accessToken;
        return response()->json(['data' => $reaponseData], 200);
        
    }
	public function DashboardData(){
		$reaponseData['status'] = "success";
        $reaponseData['errors']= [];
        $reaponseData['result'] = [
									"BUDGET"=>"$24,500",
									"TOTAL_HOURS"=>"763.5",
									"PROGRESS"=>"84.5%",
									"COST_UNIT"=>"$5.50",
									"EARNINGS"=>"$19.2k",
									"SESSIONS"=>"$92.1k",
									"BOUNCE"=>"50.2%",
									

								];
		return response()->json(['data' => $reaponseData], 200);
	}

}
