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
          {{ Breadcrumbs::render('customer.tray') }}
        </div>

{{-- FORM CHECKOUT --}}
      <form action="{{ route('tray.checkout') }}" method="post">
        @csrf
        
        @if (count($tray) > 0)
          <div class="row mb-3 bg-secondary sticky-top" style="top: 3.3em;" data-bs-theme="light">
            <div class="col d-inline-flex justify-content-end align-items-center p-0">
              <h4 id="subtotal-header" class="p-0 m-0">Subtotal: <strong style="font-size: 1.3em; color: black; margin-right: 1em;" name="subtotal" id="subtotal"></strong></h4>
              <button type="submit" class="btn btn-success">Checkout</button>
            </div>
          </div>
        @endif
        
        
        <div class="row">

        @isset($tray)
          @php
            $count = 1;
          @endphp
          <div class="table-responsive small caption-top">
            <caption>List of Products</caption>
              <table class="table table-hover table-borderless align-middle table-sm">
              <thead>
                <tr>
                  <th>No.</th>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                @forelse ($tray as $item)
                    <tr>
                      <td>{{ $count++ }}</td>
                      <td>
                        <input type="hidden" name="tray_id[]" value="{{ $item->tray_id }}">
                        <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                        <img src="{{ asset('images/'. $item->image) }}" alt="{{ $item->description }}" width="100" height="100">
                        {{ $item->product_name }}
                        @if ($item->variant != null)
                          <span class="badge bg-info">{{ $item->variant }}</span>
                        @endif
                      </td>
                      <td class="price">
                        <input type="hidden" name="price[]" value="{{ $item->unit_price }}">
                        {{ $item->unit_price }}
                      </td>
                      <td>
                        <input type="number" min="1" name="quantity[]" class="quantity"  value="1" style="max-width: 6em; min-height: 3em; text-align:center;">
                      </td>
                      <td class="total" name="total">
                        <input type="hidden" name="total" value="{{ $item->unit_price * 1 }}">
                        {{ $item->unit_price * 1 }}.00
                      </td>

                    </form><!-- form checkout -->

                      <td>
                        <form action="{{ route('tray.destroy', $item->tray_id) }}" method="POST">
                          @csrf
                          <button type="submit" class="nav-link text-danger">
                            <i class="bi bi-x-lg"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                @empty
                    <tr>
                      <td class="text-center" colspan="20">No items to display. <a href="{{ route('storefront.index') }}">Continue Shopping</a></td>
                    </tr>
                @endforelse
              </tbody>
            </table>
            <div class="d-flex justify-content-end px-3">
              {{ $tray->links() }}
            </div>
          </div>

        @endisset


        </div>
      </div>
    </main>

    <script>
      function currencyFormat(amount) {
        var formattedAmount = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP' // You can change this to your desired currency code
        }).format(amount);
        return formattedAmount;
      }
    
      function updateSubtotal() {
        var price = document.querySelectorAll('.price');
        var total = document.querySelectorAll('.total');
        var subtotal = document.getElementById('subtotal');
        var qty = document.querySelectorAll('.quantity');
    
        let sum = 0;
    
        qty.forEach(function (el, key) {
            let val = el.value;
            total[key].textContent = (val * price[key].textContent).toFixed(2);
        });
    
        total.forEach(function (e) {
            sum += parseFloat(e.textContent);
        });
    
        return subtotal.textContent = currencyFormat(sum.toFixed(2));
      }
    
      // Add event listeners for quantity changes
      var qty = document.querySelectorAll('.quantity');
      qty.forEach(function (el) {
        el.addEventListener('change', updateSubtotal);
      });
      // Call updateSubtotal on initial page load
      updateSubtotal();
    
    </script>
@endsection