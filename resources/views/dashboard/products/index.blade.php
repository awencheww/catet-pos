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
        {{ Breadcrumbs::render('products') }}
      </div>

      <h2>List of Products</h2>
      <div class="row">
        {{-- Search --}}
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-lg-4 mb-1">
              <a href="{{route('products.create')}}" type="button" class="btn btn-primary"><i class="bi bi-cart-plus"></i> Add New</a>
            </div>
            <div class="col-lg-8">
              <form method="GET" action="{{ route('products.index') }}" accept-charset="UTF-8" role="search">
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
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Code</th>
              <th scope="col">Category</th>
              <th scope="col">Supplier</th>
              <th scope="col">Variant</th>
              <th scope="col">Qty.</th>
              <th scope="col">Cost</th>
              <th scope="col">Total</th>
              <th scope="col">Price</th>
              <th scope="col">Expiry</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            
            @forelse ($products as $product)  
              <tr>
                <td scope="row"><img src="{{asset('images/'.$product->image)}}" alt="{{ $product->description }}" srcset="" width="50" height="50"></td>
                <td>{{$product->product_name}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->code}}</td>
                <td>{{$product->category_name}}</td>
                <td>{{blank($product->company) ? $product->contact_name : $product->company}}</td>
                <td>{{$product->variant}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->unit_cost}}</td>
                <td>{{$product->total_cost}}</td>
                <td>{{$product->unit_price}}</td>
                <td>{{$product->expiry}}</td>

                <td class="d-flex justify-content-center align-items-center p-sm-1">
                  <a href="{{route('products.edit', $product->product_id)}}" class="btn btn-primary btn-sm" style="margin-right: 2px">
                      <i class="bi bi-pencil-square"></i> 
                  </a>
                  <form action="{{route('products.destroy',  $product->product_id)}}" method="POST" class="delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btnDelete btn btn-danger btn-sm">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>

              </tr>
            @empty
              <tr>
                <td colspan="20" class="text-center">No record found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
        {{-- PAGINATION --}}
        {{ $products->links() }}
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
            timer: 2500,
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

          @if ($message = Session::get('error'))
            Toast.fire({
              icon: "error",
              title: "{{ $message }}",
            })
          @endif

          @if ($message = Session::get('warning'))
            Toast.fire({
              icon: "warning",
              title: "{{ $message }}",
            })
          @endif

        });
      </script>
    @endpush
@endsection