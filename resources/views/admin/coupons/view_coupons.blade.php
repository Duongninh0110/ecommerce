@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" >Coupons</a><a href="#" class="current">View Coupons</a> </div>
    <h1>Coupons</h1>

    @if (session('flash_message_success'))

	    <div class="alert alert-success alert-block">
	        <button type="button" class="close" data-dismiss="alert">×</button> 
	        <strong>{!!session('flash_message_success')!!}</strong>
	    </div>
    @endif 

  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
   
        <div class="widget-box">

          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View Coupons</h5>
          </div>
          

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Coupon_ID</th>
                  <th>Coupon Code </th>

                  <th>Amount</th>

                  <th>Amount Type</th>
                  <th>Expiry Date</th>
                  <th>Created Date</th>                  
                  <th>Status</th>                  
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>

              	@foreach ($allCoupons as $allCoupon)
                <tr class="gradeX">
                  <td>{{$allCoupon->id}}</td>
                  <td>{{$allCoupon->coupon_code}}</td>

                  <td>{{$allCoupon->amount}}

                    @if($allCoupon->amount_type == 'Percentage') % @else Dollas @endif

                  </td>

                  <td>{{$allCoupon->amount_type}}</td>
                  <td>{{$allCoupon->expiry_date}}</td>
                  <td>{{$allCoupon->created_at}}</td>
                  <td>@if($allCoupon->status == 1) Active @else Inactive @endif</td>                  
                  
                  <td class="center">                   
                    <a href="{{url('admin/edit-coupon/'.$allCoupon->id)}}" class="btn btn-primary btn-mini" title="edit">Edit</a> 
                    <a 
                    rel="{{$allCoupon->id}}" rel1="delete-coupon"  href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="delete">Delete</a></td>
                </tr>

                
                
  

                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  



@endsection