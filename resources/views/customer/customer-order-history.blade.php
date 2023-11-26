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
          {{ Breadcrumbs::render('order.history') }}
        </div>

{{-- FORM CHECKOUT --}}
      {{-- <form action="{{ route('order.checkout') }}" method="post" id="completeOrderForm">
        @csrf --}}

        <div class="row">

        @isset($orders)
          @php
            $count = 1;
          @endphp
          <div class="table-responsive small caption-top">
            <caption>List of Products</caption>

              <table class="table table-hover table-striped table-borderless align-middle table-sm">
              <thead class="border-black border-bottom">
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Invoice No. </th>
                  <th scope="col">Transaction No. </th>
                  <th scope="col">Payment</th>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th scope="col">Date Ordered</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                @forelse ($orders as $item)
                    <tr>
                      <td>{{ $count++ }}</td>
                      <td>{{ $item->sales_invoice_number }}</td>
                      <td>{{ $item->transaction_number }}</td>
                      <td>{{ $item->payment_method }}</td>
                      <td>
                        <input type="hidden" name="order_id[]" value="{{ $item->order_id }}">
                        <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                        <img class="img-thumbnail" src="{{ asset('images/'. $item->image) }}" alt="{{ $item->description }}" width="60" height="60">
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
                        <input type="number" min="1" name="quantity[]" class="quantity" disabled  value="{{ $item->order_quantity }}" style="max-width: 6em; min-height: 3em; text-align:center;">
                      </td>
                      <td class="total" name="total">
                        <input type="hidden" name="total" value="{{ $item->unit_price * 1 }}">
                        {{ $item->unit_price * 1 }}.00
                      </td>
                      <td>
                        {{ $item->sales_date }}
                      </td>
                      <td>
                        <span class='badge {{ $item->so_status == 'complete' ? 'bg-success' : 'bg-danger' }}'>{{ ucwords($item->so_status) }}</span>
                      </td>
                    </tr>

        {{-- </form><!-- form checkout --> --}}
                
                @empty
                    <tr>
                      <td class="text-center" colspan="20">No order history to display. <a href="{{ route('storefront.index') }}">Continue Shopping</a></td>
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
    
@endsection