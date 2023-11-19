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
        {{ Breadcrumbs::render('user.add') }}
      </div>

      <div class="container-fluid">
        <h2>Add User</h2>
        <div class="row g-3">
          
          <div class="alert alert-dismissible alert-info fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Note !</strong> After saving, the default password is `<strong>cashier</strong>` or `<strong>admin1234</strong>`, depending on what role is choosen. They can Reset Password later.
          </div>

          <form action="{{route('user.store')}}" method="POST" class="row g-3">
            @csrf
            
            {{-- @if (isset($user)) --}}
              <div class="row g-3">
                <div class="col-md-3">
                  <label for="role" class="form-label">Select Role</label>
                  <select class="form-select" name="role" id="role" aria-label="Default select example">
                    <option value="cashier">Cashier</option>
                    <option value="admin">Admin</option>
                  </select>
                  @error('role') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="fullname" class="form-label">Full Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="fullname" value="{{old('name')}}">
                  @error('name') <span class="invalid-feedback">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail4" value="{{old('email')}}">
                @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{old('username')}}">
                @error('username') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-4">
                <label for="inputPhone" class="form-label">Phone No.</label>
                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="inputPhone" maxlength="11" placeholder="09xxxxxxxxx" value="{{old('phone_number')}}">
                @error('phone_number') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
              <div class="col-8">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress" placeholder="1234 Main St, Brgy. San Juan, Sample City, Surigao del Norte, 8400" value="{{old('address')}}">
                @error('address') <span class="invalid-feedback">{{$message}}</span> @enderror
              </div>
            {{-- @endif --}}

            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a href="{{route('/users')}}" type="button" class="btn btn-outline-danger">Cancel</a>
            </div>
          </form>
        </div>
      </div>

    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {
          var input = document.querySelectorAll('input');
          var role = document.getElementById('role');
          role.addEventListener('change', function(e) {
            e.preventDefault();
            if(this.value === 'admin') {
              input.forEach(el => {
                switch (el.getAttribute('name')) {
                  case 'name':
                    el.setAttribute("disabled", "");
                    break;
                  case 'phone_number':
                    el.setAttribute("disabled", "");
                    break;
                  case 'address':
                    el.setAttribute("disabled", "");
                  break;
                  default:
                    el.removeAttribute("disabled", "");
                    break;
                }
              });
            } else {
              input.forEach(el => {
                switch (el.getAttribute('name')) {
                  case 'name':
                    el.removeAttribute("disabled", "");
                    break;
                  case 'phone_number':
                    el.removeAttribute("disabled", "");
                    break;
                  case 'address':
                    el.removeAttribute("disabled", "");
                  break;
                  default:
                    break;
                }
              });
            }
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