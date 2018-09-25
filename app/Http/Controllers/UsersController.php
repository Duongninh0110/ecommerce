<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use App\Country;

class UsersController extends Controller
{


	public function userLoginRegister(){

		return view('users.login_register');

	}
    public function register(Request $request){


    	if($request->isMethod('post')){
			$data = $request->all();

	    	
	    	// echo "<pre>"; print_r($data); die;
	    	$userCount = User::where(['email'=>$data['email']])->count();
	    	
	    	if($userCount>0){return redirect()->back()->with('flash_message_error', 'The email is already registed');}

	    	$user = new User;
	    	$user->name = $data['name'];
	    	$user->email = $data['email'];
	    	$user->password = Hash::make($data['password']);
	    	$user->save();

	    	if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
	    		Session::put('frontSession', $data['email']);
	    		return redirect('/cart');
	    	}
    	}

    	

    }


    public function checkEmail(Request $request){

    	$data = $request->all();
    	$userCount = User::where(['email'=>$data['email']])->count();
    	if($userCount>0){
		 	echo "false";
		}else{
			echo "true";
		}

    }

    public function logout(){
    	Session::forget('frontSession');
    	Auth::logout();
    	return redirect('/');
    }

    public function login(Request $request){

    	if($request->isMethod('post')){
    	$data = $request->all();

	    	if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
	    		Session::put('frontSession', $data['email']);
				return redirect('/cart');
			}else {
				return redirect()->back()->with('flash_message_error', 'The email or password is incorrect');
			}

		}
    }

    public function account(Request $request){

    	$user_id = Auth::user()->id;
    	$userDetails = User::find($user_id);
    	// $userDetails = json_decode(json_encode($userDetails));
    	// echo "<pre>"; print_r($userDetails); die;
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$userDetails->name = $data['name'];
    		$userDetails->address = $data['address'];
    		$userDetails->city = $data['city'];
    		$userDetails->state = $data['state'];
    		$userDetails->country = $data['country'];
    		$userDetails->pincode = $data['pincode'];
    		$userDetails->mobile = $data['mobile']; 
    		$userDetails->save();

    	return redirect()->back()->with('flash_message_success', 'The account is successfully updated');	
    	}

    	$countries = Country::get();

    	return view('users.account')->with('countries', $countries)->with('userDetails', $userDetails);
    }

    public function chkUserPassword(Request $request){
    	$data = $request->all();
    	// echo "<pre>"; print_r($data); die;
    	$current_password = $data['current_pwd'];
    	$user_id = Auth::user()->id;
    	$userDetails = User::find($user_id);
    	$check_password = $userDetails->password;
    	if(Hash::check($current_password, $check_password)){
         echo 'true'; die;
      	}else {
         	echo 'false'; die;
      	}

    }

    public function updateUserPassword(Request $request){
    	if($request->isMethod('post')){

     	$data=$request->all();
     	$current_password=$data['current_pwd'];
     	$user_id = Auth::user()->id;
    	$userDetails = User::find($user_id);
    	$check_password = $userDetails->password;
	     	if(Hash::check($current_password, $check_password)){
	        $password = bcrypt($data['new_pwd']);
	        $userDetails->update(['password'=> $password]);
	        return redirect('account')->with('flash_message_success', 'Password is successfully updated');
	    
	     	}else {
	        return redirect('account')->with('flash_message_error', 'Current Password is Incorrect');
	     	}

	  	}
    }
}
