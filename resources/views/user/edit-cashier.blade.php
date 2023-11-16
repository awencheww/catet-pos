@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">
      <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-circle"></i> Profile </li>
          </ol>
        </nav>
        <h2>Update Profile</h2>
        <div class="row">

          @if ($cashier->address == null || $cashier->name == null || $cashier->phone_number == null)
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong>Welcome {{$cashier->name}}!</strong> Please complete your Profile Information for record data purposes.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
    
          <form action="{{route('cashier.update')}}" method="POST" class="row g-3">
            @csrf
            @if (isset($cashier))
              <div class="row">
                <div class="col-md-6">
                  <label for="fullname" class="form-label">Full Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="fullname" value="{{$cashier->name}}">
                  @error('name') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail4" value="{{$cashier->email}}">
                @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{$cashier->username}}">
                @error('username') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-4">
                <label for="inputPhone" class="form-label">Phone No.</label>
                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="inputPhone" maxlength="11" placeholder="09xxxxxxxxx" value="{{$cashier->phone_number}}">
                @error('phone_number') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-8">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress" placeholder="1234 Main St, Brgy. San Juan, Sample City, Surigao del Norte, 8400" value="{{$cashier->address}}">
                @error('address') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
            @endif
            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a class="btn btn-primary" href="{{route('cashier.forgot.password')}}" id="btnResetPassword">Reset Password</a>
            </div>
          </form>
        </div>
      </div>
    </main>

    @push('dashboard-scripts')
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
                  window.location.href = "{{route('customer.forgot.password')}}";
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