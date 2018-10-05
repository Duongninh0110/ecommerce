@extends ('layouts.frontLayout.front_design')
@section ('content')

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="#">Home</a></li>
			  <li class="active">Check out</li>
			</ol>
		</div><!--/breadcrums-->

		<div class="review-payment">
			<h1>Buyer Information</h1>
		</div>

		<div class="shopper-informations">
			<div class="row">				
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Billing To</h2>
						<form id="accountForm" name="accountForm" action="{{url('checkout')}}" method="post">
							@csrf
							
							<input value="{{$userDetails->name}}" name="name" id="name" type="text" placeholder="Name" />
							<input value="{{$userDetails->address}}" name="address" id="address" type="text" placeholder="Address" />
							<input value="{{$userDetails->city}}" name="city" id="city" type="text" placeholder="City" />
							<input value="{{$userDetails->state}}" name="state" id="state" type="text" placeholder="State" />

							
							<select name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
								<option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif>{{$country->country_name}}</option>
								@endforeach
							</select>
							<input style="margin-top: 10px" value="{{$userDetails->pincode}}" name="pincode" id="pincode" type="text" placeholder="Pincode" />
							<input value="{{$userDetails->mobile}}" name="mobile" id="mobile" type="text" placeholder="Mobile" />
							<button type="submit" class="btn btn-default">Checkout</button>
							

							
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class=""></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						{{-- <h2>Shipping To</h2> --}}
						
					</div>
				</div>					
			</div>
		</div>
		<div class="review-payment">
			<h1>Review & Payment</h1>
		</div>

		<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image" >Item</td>
							<td class="description" style="width:350px; margin-right:50px;"></td>
							<td class="price" style="width:100px; margin-left:50px;">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>

						<?php $total_amount = 0?>

						@foreach ($userCarts as $userCart)
						<tr>
							<td class="cart_product" style="width:50px">
								<a href=""><img style="width:80px !important;" src="{{asset('images/backend_images/products/small/'.$userCart->image)}}" alt=""></a>
							</td>
							<td class="cart_description" style="width:350px; margin-right:50px;">
								<h4><a href="">{{$userCart->product_name}}</a></h4>
								<p>{{$userCart->product_code}} | {{$userCart->size}}</p>
								
							</td>
							<td class="cart_price" style="width:100px; margin-left:50px;">
								<p>{{$userCart->price}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href="{{url('/cart/update-quantity/'.$userCart->id.'/1')}}"> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="{{$userCart->quantity}}" autocomplete="off" size="2">
									@if($userCart->quantity>1)
									<a class="cart_quantity_down" href="{{url('/cart/update-quantity/'.$userCart->id.'/-1')}}"> - </a>
									@endif
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{$userCart->quantity*$userCart->price}}</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/cart/delete-product/'.$userCart->id)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>

						<?php $total_amount = $total_amount + $userCart->quantity*$userCart->price?>
						
						@endforeach						
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-sm-6">
					
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							@if(!empty(Session::get('CouponAmount')))
							<li>Sub Total <span>${{$total_amount}}</span></li>
							<li>Coupon Discount <span>${{Session::get('CouponAmount')}}</span></li>
							<li>Grand Total <span>${{$total_amount - Session::get('CouponAmount')}}</span></li>
							@else()
							<li>Total <span>${{$total_amount}}</span></li>
							@endif
						</ul>
							{{-- <a class="btn btn-default update" href="">Update</a>
							<a class="btn btn-default check_out" href="checkout">Check Out</a> --}}
					</div>
				</div>
			</div>

		<div class="payment-options">
				<span>
					<label><input type="checkbox"> Direct Bank Transfer</label>
				</span>
				<span>
					<label><input type="checkbox"> Check Payment</label>
				</span>
				<span>
					<label><input type="checkbox"> Paypal</label>
				</span>
			</div>
	</div>
</section> <!--/#cart_items-->

@endsection