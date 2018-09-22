@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Products Images</a> </div>
    <h1>Product Images</h1>

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

  </div>
  <div class="container-fluid"><hr>
    
    <div class="row-fluid">
      
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Product Images</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{url('/admin/add-images/'.$productDetails->id )}}" name="add_attribute" id="add_attribute" enctype="multipart/form-data">
              	@csrf
                <div class="control-group">
                  <label class="control-label">Product Name</label>
                  <label class="control-label"><strong>{{$productDetails->product_name}}</strong></label>
                </div>

                


                <div class="control-group">
                  <label class="control-label">Product Code</label>
                  <label class="control-label"><strong>{{$productDetails->product_code}}</strong></label>
                </div>

               <div class="control-group">
                  <label class="control-label">Product Image</label>
                  <div class="controls">
                    <input type="file" name="image" id="image" multiple="multiple" />
                  </div>
                </div>

                


                <div class="form-actions">
                  <input type="submit" value="Add Attributes" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
   
        <div class="widget-box">

          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>View Products Images</h5>
          </div>
          

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Image_ID</th>
                  <th>Product_ID</th>
                  <th>Image</th>                  
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($productDetails->images as $image)
                <tr class="gradeX">

                  <td>{{$image->id}}</td>
                  <td>{{$image->product_id}}</td>

                  <td><img src="{{asset('/images/backend_images/products/small/'.$image->image)}}" alt="" style="width: 200px"></td>
         
                  <td class="center">
                    
                  
                    <a 
                    rel="{{$image->id}}" rel1="delete-alt-image"  href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
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