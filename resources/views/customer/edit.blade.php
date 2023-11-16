@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">

      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><svg class="bi"><use xlink:href="#house-fill"></use></svg> <a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
      </nav>
      <div class="container">
        <h2>Edit Customer</h2>
        <div class="row g-3">
          <form action="{{route('/customer/update', $user->user_id)}}" method="POST" class="row g-3">
            @csrf
            @if (isset($user))
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="fullname" class="form-label">Full Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="fullname" value="{{$user->name}}">
                  @error('name') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail4" value="{{$user->email}}">
                @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{$user->username}}">
                @error('username') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-4">
                <label for="inputPhone" class="form-label">Phone No.</label>
                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="inputPhone" maxlength="11" placeholder="09xxxxxxxxx" value="{{$user->phone_number}}">
                @error('phone_number') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-8">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress" placeholder="1234 Main St, Brgy. San Juan, Sample City, Surigao del Norte, 8400" value="{{$user->address}}">
                @error('address') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
            @endif
            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a href="{{route('/customers')}}" type="button" class="btn btn-outline-danger">Cancel</a>
            </div>
          </form>
        </div>
      </div>

    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {
          var form = document.querySelectorAll(".deleteUser");
          form.forEach(element => {
            element.addEventListener('submit', function(e) {
              e.preventDefault();
              if(e.currentTarget) {
                var form = e.currentTarget;
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!',
                }).then(function (result) {
                  if (result.isConfirmed) {
                    form.submit();
                  }
                })
              }
            })
          });

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