@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">

       
        <div class="row profile-body">
          <!-- left wrapper start -->
          
          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
             <div class="card">
              <div class="card-body">

			<h6 class="card-title">Update Site Setting</h6>

			<form id="myForm" method="POST" action="{{ route('update.site.setting') }}" enctype="multipart/form-data" class="forms-sample">
				@csrf

                <input type="hidden" name="id" value="{{$setting->id}}">
 

				<div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Support Phone</label>
					 <input type="text" name="support_phone" value="{{$setting->support_phone}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Company Address</label>
					 <input type="text" name="company_address" value="{{$setting->company_address}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Email</label>
					 <input type="text" name="email" value="{{$setting->email}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Facebook</label>
					 <input type="text" name="facebook" value="{{$setting->facebook}}" class="form-control" >
				</div>
  
                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Twitter</label>
					 <input type="text" name="twitter" value="{{$setting->twitter}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Copyright</label>
					 <input type="text" name="copyright" value="{{$setting->copyright}}" class="form-control" >
				</div>

                <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Logo   </label>
	 <input class="form-control"  name="logo" type="file" id="image">
				</div>

	<div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">    </label>
	<img id="showImage" class="wd-80 rounded-circle" src="{{  asset($setting->logo) }}" alt="profile">
				</div>

			 
				 
	 <button type="submit" class="btn btn-primary me-2">Save Changes </button>
			 
			</form>

              </div>
            </div>




            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
         
          <!-- right wrapper end -->
        </div>

			</div>
 
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#image').change(function(e){
                        var reader = new FileReader();
                        reader.onload = function(e){
                            $('#showImage').attr('src',e.target.result);
                        }
                        reader.readAsDataURL(e.target.files['0']);
                    });
                });
            
            
            </script>



@endsection