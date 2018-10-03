@extends ('layouts.frontLayout.front_design')
@section ('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>

				  	@if (session('flash_message_error'))

			        <div class="alert alert-danger alert-block">
			            <button type="button" class="close" data-dismiss="alert">×</button> 
			            <strong>{!!session('flash_message_error')!!}</strong>
			        </div>

			           
			    	@endif  

					@if (session('flash_message_success'))

				      <div class="alert alert-success alert-block">
				          <button type="button" class="close" data-dismiss="alert">×</button> 
				          <strong>{!!session('flash_message_success')!!}</strong>
				      </div>
				    @endif 

				</ol>
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
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>What would you like to do next?</h3>
				<p>Choose if you have a coupon code to use.</p>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_option">
							<li>
								
								<label>Coupon Code</label>
								<form action="{{url('cart/apply-coupon/')}}" method="post">
								@csrf
								<input type="text" name="coupon_code">
								<input type="submit" class="btn btn-default" value="Apply">
								</form>
							</li>
						</ul>						
						
					</div>
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
							<a class="btn btn-default update" href="">Update</a>
							<a class="btn btn-default check_out" href="">Check Out</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->


@endsection