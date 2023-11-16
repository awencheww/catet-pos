@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">

      {{-- Breadcrumbs --}}
      <div class="row p-2">
        {{ Breadcrumbs::render('admin.settings') }}
      </div>

      <div class="container-fluid">
        <h2>Update Admin Settings</h2>
        <div class="row g-3">
          <form action="{{route('admin.update')}}" method="POST" class="row g-3">
            @csrf
            @if ($admin = Auth::user())
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{$admin->username}}">
                  @error('username') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail4" value="{{$admin->email}}">
                  @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
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