@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">
      <div class="container-fluid">
        {{-- Breadcrumbs --}}
        <div class="row p-2">
          {{ Breadcrumbs::render('payments.create') }}
        </div>

        <h2>Add Payment</h2>
        <div class="row g-3">

          <form action="{{route('payments.store')}}" method="POST" class="row g-3">
            @csrf

            {{-- Render form fields based on the detected fields --}}
            <div class="row g-3">
              @foreach ($fields as $field)
                  @if ($field === 'purchase_order_id')
                    <div class="form-group mb-1 col-md-6">
                        <label for="{{ $field }}" class="form-label">Select Purchase Order</label>
                        <select class="form-select" name="{{ $field }}" id="{{ $field }}" aria-label="Select Purchase Order">
                          <option value="0" selected></option>
                          <option value="1">PO1</option>
                          <option value="2">PO2</option>
                          <option value="3">PO3</option>
                        </select>
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                  @elseif ($field === 'sales_order_id')
                    <div class="form-group mb-1 col-md-6">
                        <label for="{{ $field }}" class="form-label">Select Sales Order</label>
                        <select class="form-select" name="{{ $field }}" id="{{ $field }}" aria-label="Select Sales Order">
                          <option value="0" selected></option>
                          <option value="1">SO1</option>
                          <option value="2">SO2</option>
                          <option value="3">SO3</option>
                        </select>
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                @elseif ($field === 'method')
                  <div class="form-group mb-1 col-md-4">
                    <label for="{{ $field }}" class="form-label">{{ ucwords($field) }}</label>
                    <select class="form-select" name="{{ $field }}" id="{{ $field }}" aria-label="Select Method">
                      <option value="cash" selected>Cash</option>
                      <option value="e-wallet">E-Wallet</option>
                      <option value="cod">COD</option>
                    </select>
                    @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                  </div>
                @elseif ($field === 'status')
                  <div class="form-group mb-1 col-md-4">
                    <label for="{{ $field }}" class="form-label">{{ ucwords($field) }}</label>
                    <select class="form-select" name="{{ $field }}" id="{{ $field }}" aria-label="Select Status">
                      <option value="paid" selected>Paid</option>
                      <option value="unpaid">Unpaid</option>
                      <option value="partially paid">Partially Paid</option>
                      <option value="fully paid">Fully Paid</option>
                    </select>
                    @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                  </div>
                @else
                  <div class="row g-3">
                    <div class="form-group mb-1 col-md-6">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control  @error($field) is-invalid @enderror">{{ old($field) }}</textarea>
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                  </div>
                @endif

              @endforeach
            </div>
              
            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a class="btn btn-outline-danger" href="{{route('payments.index')}}">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {
          //focus #name element
          var el = document.getElementById('purchase_order_id');
              el.focus();
              el.select();

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