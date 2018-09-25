@extends ('layouts.frontLayout.front_design')
@section ('content')

<section id="form" style="margin-top:20px "><!--form-->
		<div class="container">
			<div class="row">

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

				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Update Account</h2>
						<form id="accountForm" name="accountForm" action="{{url('account')}}" method="post">
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
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Update Password</h2>
						<form id="passwordForm" name="passwordForm" action="{{url('update-user-pwd')}}" method="post">
							@csrf
							
							<input value="" name="current_pwd" id="current_pwd" type="password" placeholder="Current Password" />
							<span id="chkPwd"></span>
							<input value="" name="new_pwd" id="new_pwd" type="password" placeholder="New Password" />
							<input value="" name="confirm_password" id="confirm_password" type="password" placeholder="Confirm Password" />
													
							
							<button type="submit" class="btn btn-default">Update</button>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection