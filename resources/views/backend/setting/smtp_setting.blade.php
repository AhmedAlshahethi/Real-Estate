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

			<h6 class="card-title">Update SMTP Setting</h6>

			<form id="myForm" method="POST" action="{{ route('update.smtp.setting') }}" class="forms-sample">
				@csrf

                <input type="hidden" name="id" value="{{$setting->id}}">
 

				<div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Mailer</label>
					 <input type="text" name="mailer" value="{{$setting->mailer}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Host</label>
					 <input type="text" name="host" value="{{$setting->host}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Port</label>
					 <input type="text" name="port" value="{{$setting->port}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Username</label>
					 <input type="text" name="username" value="{{$setting->username}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Password</label>
					 <input type="text" name="password" value="{{$setting->password}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">Encryption</label>
					 <input type="text" name="encryption" value="{{$setting->encryption}}" class="form-control" >
				</div>

                <div class="form-group mb-3">
 <label for="exampleInputEmail1" class="form-label">From Address</label>
					 <input type="text" name="from_address" value="{{$setting->from_address}}" class="form-control" >
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
 



@endsection