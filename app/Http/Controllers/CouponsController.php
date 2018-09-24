<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Coupon;

class CouponsController extends Controller
{
    public function addCoupon(Request $request){

    	if($request->isMethod('post')){
    		$data = $request->all();

    		$coupon = new Coupon;
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];

    		if(empty($data['status'])){
    			$status = 0;
    		}else{
    			$status = 1;	
    		}
    		$coupon->status = $status;

    		$coupon->save();
    		return redirect('admin/view-coupons')->with('flash_message_success', 'The Coupon is successfully added');

    	}

    	return view ('admin.coupons.add_coupon');
  	}

  	public function viewCoupons(){

  		$allCoupons = Coupon::get();
  		return view ('admin.coupons.view_coupons')->with('allCoupons', $allCoupons);

  	}

  	public function editCoupon(Request $request, $id = null){

  		$coupon = Coupon::find($id);

  		if($request->isMethod('post')){
  			$data = $request->all();
  			$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];

    		if(empty($data['status'])){
    			$status = 0;
    		}else{
    			$status = 1;	
    		}
    		$coupon->status = $status;

    		$coupon->save();
    		return redirect('admin/view-coupons')->with('flash_message_success', 'The Coupon is successfully updated');

  		}

  		
  		return view('admin.coupons.edit_coupon')->with('coupon', $coupon);

  	}

  	public function deleteCoupon($id = null){
  		$coupon = Coupon::find($id);
		$coupon->delete();
		return redirect()->back()->with('flash_message_success', 'The Coupon is successfully deleted');

  		
  	}

}
