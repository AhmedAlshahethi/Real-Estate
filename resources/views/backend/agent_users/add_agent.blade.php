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

			<h6 class="card-title">Add Agent  </h6>

			<form method="POST" action="{{ route('store.agent') }}" class="forms-sample">
				@csrf
 

				<div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Agent Name  </label>
					 <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror " >
           @error('name')
           <span class="text-danger">{{ $message }}</span>
           @enderror
				</div>

			 	<div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Agent Username   </label>
					 <input type="text" name="username" value="{{old('username')}}" class="form-control @error('username') is-invalid @enderror " >
           @error('username')
           <span class="text-danger">{{ $message }}</span>
           @enderror
				</div> 

                <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Agent Email   </label>
					 <input type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror " >
           @error('email')
           <span class="text-danger">{{ $message }}</span>
           @enderror
				</div>
                
                <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Agent Phone   </label>
					 <input type="text" name="phone" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror " >
           @error('phone')
           <span class="text-danger">{{ $message }}</span>
           @enderror
				</div>
                
                <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Agent Address   </label>
					 <input type="text" name="address" value="{{old('address')}}" class="form-control @error('address') is-invalid @enderror " >
           @error('address')
           <span class="text-danger">{{ $message }}</span>
           @enderror
				</div>

                <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Agent Password   </label>
					 <input type="password" name="password" class="form-control @error('password') is-invalid @enderror " >
           @error('password')
           <span class="text-danger">{{ $message }}</span>
           @enderror
				</div>

                <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">Confirem Password   </label>
					 <input type="password" name="password_confirmation" class="form-control @error('confirem_password') is-invalid @enderror " >
           @error('confirem_password')
           <span class="text-danger">{{ $message }}</span>
           @enderror
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