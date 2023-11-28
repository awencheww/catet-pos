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
        {{ Breadcrumbs::render('admin.orders') }}
      </div>

      {{-- <h2>List of Orders</h2> --}}
      <div class="row">
        {{-- Search --}}
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-lg-8">
              <form method="GET" action="{{ route('admin.orders') }}" accept-charset="UTF-8" role="search">
                <div class="input-group mb-3">
                  <button class="btn btn-outline-primary" type="submit" id="button-addon1"><i class="bi bi-search"></i></button>
                  <input type="text" class="form-control border-primary-subtle" name="search" value="{{ request('search') }}" placeholder="Search list.." aria-label="Search list" aria-describedby="button-addon1">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @php
        $count = 1;
      @endphp
      <div class="table-responsive small">
        <table class="table table-hover table-borderless table-striped align-middle table-sm">
          <thead class="border-black border-bottom">
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Transaction No.</th>
              <th scope="col">Customer Name</th>
              <th scope="col">Total Quantity</th>
              <th scope="col">Total Amount</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Status</th>
              <th scope="col">Payment</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            
            @forelse ($orders as $item)

                <tr>
                  <td>{{ $count++ }}</td>

                  <td>{{ $order_totals[$item->user_id]['transactionNo'] }}</td>
                  <td>{{ $item->name }}</td>
                  <td>
                    {{ $order_totals[$item->user_id]['totalQuantity'] }}
                  </td>
                  <td>
                    @money($order_totals[$item->user_id]['totalAmount'])
                  </td>
                  <td>{{ $order_totals[$item->user_id]['orderDate'] }}</td>
                  <td><span class='badge {{ $order_totals[$item->user_id]['paymentStatus'] == 'paid' ? 'bg-success' : ($order_totals[$item->user_id]['paymentStatus'] == 'partially paid' ? 'bg-warning' : 'bg-danger') }}'>{{ ucwords($order_totals[$item->user_id]['paymentStatus']) }}</span></td>
                  <td>{{ $order_totals[$item->user_id]['paymentMethod'] }}</td>
                  
                  <td class="d-flex justify-content-center align-items-center p-sm-1">
                    <a href="{{ route('admin.orders.show', $item->user_id) }}" class="btn btn-primary btn-sm" style="margin-right: 2px">
                        <i class="bi bi-eye"></i>
                        View Orders
                    </a>
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
        {{ $orders->links() }}
      </div>
    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {

          var form = document.querySelectorAll(".complete");
          form.forEach(element => {
            element.addEventListener('submit', function(e) {
              e.preventDefault();
              if(e.currentTarget) {
                var form = e.currentTarget;
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You want to complete this order!",
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, proceed!',
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