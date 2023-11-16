@extends('layouts.app')
@section('header')
    @include('dashboard.partials.svg')
    @include('customer.partials.header')
    @endsection
@section('content')
    @include('customer.partials.sidebar')
    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">
      <div class="container-fluid">
        {{-- Breadcrumbs --}}
        <div class="row p-2">
          {{ Breadcrumbs::render('customer.profile') }}
        </div>

        <h2>Update Profile</h2>
        <div class="row">

          @if ($customer->address == null || $customer->name == null || $customer->phone_number == null)
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong>Welcome {{$customer->name}}!</strong> Please complete your Profile Information to continue shopping.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
    
          <form action="{{route('customer.update')}}" method="POST" class="row g-3">
            @csrf
            @if (isset($customer))
              <div class="row">
                <div class="col-md-6">
                  <label for="fullname" class="form-label">Full Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="fullname" value="{{$customer->name}}">
                  @error('name') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email <span class="text-danger">*Recommended for Resetting Password</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail4" value="{{$customer->email}}">
                @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{$customer->username}}">
                @error('username') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-4">
                <label for="inputPhone" class="form-label">Phone No.</label>
                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="inputPhone" maxlength="11" placeholder="09xxxxxxxxx" value="{{$customer->phone_number}}">
                @error('phone_number') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-8">
                <label for="inputAddress" class="form-label">Complete Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress" placeholder="1234 Main St, Brgy. San Juan, Sample City, Surigao del Norte, 8400" value="{{$customer->address}}">
                @error('address') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
            @endif
            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a class="btn btn-primary" href="{{route('customer.reset.password')}}" id="btnResetPassword">Reset Password</a>
            </div>
          </form>
        </div>
      </div>
    </main>

    @push('app-scripts')
      <script>
        document.addEventListener('readystatechange', function() {

          var resetPass = document.querySelector("#btnResetPassword");
          resetPass.addEventListener('click', function(e) {
            e.preventDefault();
            if(e.currentTarget) {
              Swal.fire({
                title: 'Reset Password',
                text: "This will log you out and make sure you have your Email login to Access reset link.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continue',
              }).then(function (result) {
                if (result.isConfirmed) {
                  window.location.href = "{{route('customer.reset.password')}}";
                }
              })
            }
          })

          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: function (toast) {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
          })
          
          @if ($message = Session::get('success'))
            Toast.fire({
              icon: "success",
              title: "{{Session::get('success')}}",
            })
          @endif

        });
      </script>
    @endpush
@endsection