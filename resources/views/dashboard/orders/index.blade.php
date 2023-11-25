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
        <table class="table table-hover table-borderless align-middle table-sm">
          <thead class="border-black border-bottom">
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Transaction No.</th>
              <th scope="col">Invoice #</th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total</th>
              <th scope="col">Date Ordered</th>
              <th scope="col">Status</th>

              <th scope="col">Sugar Content (Less 10 to 50%)</th>
              <th scope="col">Writing</th>

              {{-- @foreach ($orders as $item)
                @if ($item->category_name === 'Cakes')
                  <th scope="col">Sugar Content (Less 10 to 50%)</th>
                  <th scope="col">Writing</th>
                @endif
              @endforeach --}}
              
              <th scope="col">Payment</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            
            @forelse ($orders as $item)  
              <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $item->transaction_number }}</td>
                <td>
                  <input type="hidden" name="sales_invoice" value="{{ $item->sales_invoice_number }}">
                  {{ $item->sales_invoice_number }}
                </td>
                <td>
                  <input type="hidden" name="order_id" value="{{ $item->order_id }}">
                  <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                  <img src="{{ asset('images/'. $item->image) }}" alt="{{ $item->description }}" width="100" height="100">
                  {{ $item->product_name }}
                  @if ($item->variant != null)
                    <span class="badge bg-info">{{ $item->variant }}</span>
                  @endif
                </td>
                <td class="price">
                  <input type="hidden" name="price" value="{{ $item->unit_price }}">
                  {{ $item->unit_price }}
                </td>
                <td>
                  <input type="number" min="1" name="quantity" class="quantity" disabled  value="{{ $item->oder_quantity }}" style="max-width: 6em; min-height: 3em; text-align:center;">
                </td>
                <td class="total" name="total">
                  <input type="hidden" name="total" value="{{ $item->unit_price * 1 }}">
                  {{ $item->unit_price * 1 }}.00
                </td>
                <td>
                  {{ $item->sales_date }}
                </td>
                <td>
                  {{ $item->so_status }}
                </td>

                @if ($item->category_name === 'Cakes')
                <form action="{{route('admin.orders.complete',  $item->order_id)}}" method="POST" class="complete">
                  @csrf
                  
                  <td>
                    <input type="hidden" name="transaction_number" value="{{ $item->transaction_number }}">
                    <input type="number" min="10" max="50" name="sugar_content" class="sugar_content" onchange="isMax(event)"  value="{{ $item->sugar_content }}" style="max-width: 6em; min-height: 3em; text-align:center;">
                  </td>
                  <td>
                    <textarea name="writing" class="writing" cols="30" rows="3" maxlength="100" wrap="hard"> {{ $item->sugar_content }} </textarea>
                  </td>
                @else
                  <td></td>
                  <td></td>
                @endif

                <td>
                  <div class="form-floating">
                    <select name="payment_method_tobeupdate" class="form-select border border-success" id="selectMethod">
                      <option value="cash">Cash</option>
                      <option value="e-wallet" >E-wallet (Gcash)</option>
                      <option value="cod" selected>COD (Cash on Delivery)</option>
                    </select>
                    <label for="floatingSelectGrid">Select Payment Method</label>
                  </div>  
                </td>
                
                <td class="d-flex justify-content-center align-items-center p-sm-1">
                  {{-- <a href="{{route('orders.edit', $product->product_id)}}" class="btn btn-primary btn-sm" style="margin-right: 2px">
                      <i class="bi bi-pencil-square"></i> 
                  </a> --}}
                  
                    <input type="hidden" name="payment_method" value="{{ $item->payment_method }}">
                    <input type="hidden" name="unit_price" value="{{ $item->unit_price }}">
                    <input type="hidden" name="order_quantity" value="{{ $item->order_quantity }}">
                    <button type="submit" class="btnComplete btn btn-success btn-sm">
                      Complete
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