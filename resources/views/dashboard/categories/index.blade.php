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
        {{ Breadcrumbs::render('categories') }}
      </div>

      <h2>List of Categories</h2>
      <div class="row">
        {{-- Search --}}
        <div class="col-lg-6">
          <div class="row">
            <div class="col-lg-4 mb-1">
              <a href="{{route('categories.create')}}" type="button" class="btn btn-primary"><i class="bi bi-person-plus"></i> Add New</a>
            </div>
            <div class="col-lg-8">
              <form method="GET" action="{{ route('categories.index') }}" accept-charset="UTF-8" role="search">
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
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
          @if (count($categories) > 0)
            @foreach ($categories as $category)  
              <tr>
                <th scope="row">{{$category->id}}</th>
                <td>{{$category->name}}</td>
                <td class="d-flex justify-content-center p-sm-1">
                  <a href="{{route('categories.edit', $category)}}" class="btn btn-primary btn-sm" style="margin-right: 2px">
                      <i class="bi bi-pencil-square"></i> 
                  </a>
                  <form action="{{route('categories.destroy', $category)}}" method="POST" class="delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btnDelete btn btn-danger btn-sm">
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
        {{ $categories->links() }}
      </div>
    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {

          var form = document.querySelectorAll(".delete");
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