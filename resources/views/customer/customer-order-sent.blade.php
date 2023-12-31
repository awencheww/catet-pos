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
          {{ Breadcrumbs::render('customer.order') }}
        </div>

{{-- FORM CHECKOUT --}}
      <form action="{{ route('order.checkout') }}" method="post" id="completeOrderForm">
        @csrf
        

      @isset($orders)
      @php
        $so_status = '';
        foreach ($orders as $key => $item) {
          $so_status = $item->so_status;
        }
      @endphp
        
        @if (count($orders) > 0)
          <div class="row mb-3 sticky-top" style="top: 3.3em;">
            {{-- //TODO: Checkout function Note: add invoice id for tracking and saving it to sales order --}}
            <div class="col d-inline-flex justify-content-end align-items-center p-0">
              <h4 id="subtotal-header" class="p-0 m-0">Subtotal: <strong style="font-size: 1.3em; margin-right: 1em;" name="subtotal" id="subtotal"></strong></h4>
            </div>
          </div>
        @endif
        
        
        <div class="row">

        
          @php
            $count = 1;
          @endphp
          <div class="table-responsive small caption-top">
            <caption>List of Products</caption>

              <table class="table table-hover table-borderless align-middle table-sm">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Transaction No. </th>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th scope="col">Sugar Content (Less 10 to 50%)</th>
                  <th scope="col">Writing</th>
                  <th scope="col">Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                @forelse ($orders as $item)
                    <tr>
                      <td>{{ $count++ }}</td>
                      <td>
                        {{ $item->transaction_number }}
                      </td>
                      <td>
                        <input type="hidden" name="order_id[]" value="{{ $item->order_id }}">
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
                        <input type="number" min="1" name="quantity[]" class="quantity"  value="{{ $item->order_quantity }}" {{ $item->so_status === 'preparing' ? 'disabled' : '' }} style="max-width: 6em; min-height: 3em; text-align:center;">
                      </td>
                      <td class="total" name="total">
                        {{ $item->unit_price * 1 }}.00
                      </td>

                      @if ($item->category_name === 'Cakes')
                        <td>
                          <input type="hidden" name="transaction_number[]" value="{{ $item->transaction_number }}">
                          <input type="number" min="10" max="50" name="sugar_content[]" class="sugar_content" onchange="isMax(event)"  value="{{ $item->sugar_content }}" {{ $item->so_status === 'preparing' ? 'disabled' : '' }} style="max-width: 6em; min-height: 3em; text-align:center;">
                        </td>
                        <td>
                          <textarea name="writing[]" class="writing" cols="30" rows="3" maxlength="100" wrap="hard" {{ $item->so_status === 'preparing' ? 'disabled' : '' }}> {{ $item->writing }} </textarea>
                        </td>
                      @else
                        <td></td>
                        <td></td>
                      @endif
                      
                      <td>
                        <input type="hidden" name="so_status[]" value="{{ $item->so_status }}">
                        {{ $item->so_status }}
                      </td>

                    </form><!-- form checkout -->

                      <td>
                        @if ($item->so_status === 'pending')
                          <form action="{{ route('order.destroy', $item->order_id) }}" method="POST" class="deleteTransaction">
                            @csrf
                            <button type="submit" class="nav-link text-danger btnDelete">
                              <i class="bi bi-x-lg"></i>
                            </button>
                          </form>
                        @endif
                      </td>
                    </tr>
                @empty
                    <tr>
                      <td class="text-center" colspan="20">No sent orders to display. <a href="{{ route('storefront.index') }}">Continue Shopping</a></td>
                    </tr>
                @endforelse
              </tbody>
            </table>
            <div class="d-flex justify-content-end px-3">
              {{ $orders->links() }}
            </div>
          </div>

        @endisset


        </div>
      </div>
    </main>

    <script>
      function isMax(e) {
        e.preventDefault();
        if(e.currentTarget.value > 50) {
          e.currentTarget.value = 50;
          window.alert('Maximum 50% less sugar allowed!');
        }
        if(e.currentTarget.value < 10) {
          e.currentTarget.value = 10;
          window.alert('Minimum 10% less sugar allowed!');
        }
      }

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