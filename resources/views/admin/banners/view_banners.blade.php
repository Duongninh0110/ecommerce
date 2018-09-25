@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" >Banners</a><a href="#" class="current">View Banners</a> </div>
    <h1>Banners</h1>

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
            <h5>View Banners</h5>
          </div>
          

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Banner_ID</th>
                  <th>Title </th>
                  <th>Link</th>
                  <th>Image</th>          
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>

              	@foreach ($allBanners as $allBanner)
                <tr class="gradeX">
                  <td>{{$allBanner->id}}</td>
                  <td>{{$allBanner->title}}</td>
                  <td>{{$allBanner->link}}</td>
                  <td><img src="{{asset('/images/frontend_images/banners/'.$allBanner->image)}}" style="width:250px" alt=""></td>                  
                  
                  <td class="center">                   
                    <a href="{{url('admin/edit-banner/'.$allBanner->id)}}" class="btn btn-primary btn-mini" title="edit">Edit</a> 
                    <a 
                    rel="{{$allBanner->id}}" rel1="delete-banner"  href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="delete">Delete</a></td>
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