@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><svg class="bi"><use xlink:href="#house-fill"></use></svg> <a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
      </nav>
      <h2>List of User</h2>
      <div class="row">
        {{-- Search --}}
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-3">
              <button type="button" class="btn btn-primary"><i class="bi bi-person-plus"></i> Add User</button>
            </div>
            <div class="col-md-9">
              <form method="GET" action="{{ route('users.index') }}" accept-charset="UTF-8" role="search">
                <div class="input-group mb-3">
                  <button class="btn btn-outline-primary" type="submit" id="button-addon1"><i class="bi bi-search"></i></button>
                  <input type="text" class="form-control border-primary-subtle" name="search" value="{{ request('search') }}" placeholder="Search list.." aria-label="Search list" aria-describedby="button-addon1">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive small">
        <table class="table table-striped table-hover">
          <thead class="border-black border-bottom">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Address</th>
              <th scope="col">Phone #</th>
              <th scope="col">Username</th>
              <th scope="col">@Email</th>
              <th scope="col">Role</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
          @if (count($users) > 0)
            @foreach ($users as $user)  
              <tr>
                <th scope="row">{{$user->user_id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->address}}</td>
                <td>{{$user->phone_number}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}}</td>
                <td class="d-flex justify-content-center p-sm-1">
                  <a href="{{route('users.edit', $user->user_id)}}" class="btn btn-primary btn-sm" style="margin-right: 2px">
                      <i class="bi bi-pencil-square"></i> 
                  </a>
                  <form action="{{route('users.destroy', $user->user_id)}}" id="deleteUser">
                    @csrf
                    <button class="btn btn-danger btn-sm" onclick="deleteConfirm(event)">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="8" class="text-center">No record found</td>
            </tr>
          @endif
          </tbody>
        </table>
        {{-- PAGINATION --}}
        {{ $users->links() }}
      </div>
    </main>

    {{-- <script>
      window.deleteConfirm = function(e) {
        e.preventDefault();
        var form = e.target.form;
        if(window.confirm("Are you sure you want delete this User?")) {
          form.submit();
        }
        // Swal.fire({
        //   title: 'Are you sure?',
        //   text: "You won't be able to revert this!",
        //   icon: 'warning',
        //   showCancelButton: true,
        //   confirmButtonColor: '#3085d6',
        //   cancelButtonColor: '#d33',
        //   confirmButtonText: 'Yes, delete it!'
        // }).then((result) => {
        //   if (result.isConfirmed) {
        //     form.submit();
        //   }
        // })
      }

      @if ($message = Session::get('success'))
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
    
        Toast.fire({
          icon: 'success',
          title: {{Session::get('success')}}
        })
      @endif
    </script> --}}
@endsection