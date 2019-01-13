<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Login;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function register(Request $request){

    	$request->validate([
    		'name'=>'required',
    		'email'=>'required',
    		'password'=>'required'
    	]);

    	$user =new User();

    	$user->name=$request->name;
    	$user->email=$request->email;
    	$user->password=bcrypt($request->password);
    	$user->dctc_id=$request->dctc_id;
    	$user->cell_phone=$request->cell_phone;
    	$user->driver_license=$request->driver_license;
    	$user->license_expiration_date=$request->license_expiration_date;
    	$user->insurance_name=$request->insurance_name;
    	$user->registration_date=$request->registration_date;
    	$user->information_modify_date=$request->information_modify_date;
    	$user->save();

    	// $success['token'] =  $user->createToken('MyApp')->accessToken;
    	// $success['message']=

    	$response=[
    		'token'=>$user->createToken($request->email)->accessToken,
    		'message'=>'user registration successfulll',
    		'success'=>true
    	];
        

        //return response()->json('user registration successfully');
         return response()->json($response);
        //return $this->sendResponse($success, 'User register successfully.');
    }
    public function login(Request $request)
    {
    	$request->validate([
    		'email'=>'required',
    		'password'=>'required'
    	]);

    	$user=User::where('email',$request->email)->first();
    	if($user)
    	{
    		if(Hash::check($request->password,$user->password))
    		{
    			$login=new Login();
    			$login->name=$user->name;
    			$login->email=$request->email;
    			$date = Carbon::now()->toDateTimeString();
    			$login->logged_in_time=$date;

    			$login->save();
    			return response()->json('user is found');
    		}
    		else
    			return response()->json('password is not correct');
    	}
    	else
    		return response()->json('email is not correct');
    }
}
