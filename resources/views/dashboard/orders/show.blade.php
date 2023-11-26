@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">

      <div class="container-fluid">
        {{-- //TODO: Breadcrumbs for show orders per user --}}
        {{-- <div class="row p-2">
          {{ Breadcrumbs::render('admin.orders.show') }}
        </div> --}}

  @isset($orders)

  <form action="{{ route('admin.orders.complete') }}" method="post" id="completeOrderForm">
    @csrf
    @isset($orders[0])
        <h2>Show Orders for  {{ $orders[0]['name'] }}</h2>
        <div class="row g-3">
          <div class="row mb-3 sticky-top" style="top: 3.3em;">
            {{-- //TODO: Checkout function Note: add invoice id for tracking and saving it to sales order --}}

            <div class="col-2">
              <div class="mt-3">
                <label for="exampleFormControlInput1" class="form-label">Sales Invoice:</label>
                <h3>{{ $orders[0]['sales_invoice_number'] }}</h3>
              </div>
            </div>
            <div class="col-2">
              <div class="mt-3">
                <label for="exampleFormControlInput2" class="form-label">Customer Contact:</label>
                <h3>{{ $orders[0]['phone_number'] }}</h3>
              </div>
            </div>
            <div class="col-3">
              <div class="mt-3">
                <label for="exampleFormControlInput3" class="form-label">Address:</label>
                <h3>{{ $orders[0]['address'] }}</h3>
              </div>
            </div>

            <div class="col mt-3 d-inline-flex justify-content-end align-items-center p-0">
              <input type="hidden" name="subtotal" id="hidden-subtotal">
              <h4 id="subtotal-header" class="p-0 m-0">Subtotal: <strong style="font-size: 1.3em;" name="subtotal" id="subtotal"></strong></h4>
    
              <button type="submit" class="btn btn-success btn-lg mx-2">Complete Order</button>
            </div>

          </div>
      @endisset

            @php
              $count = 1;
            @endphp
            <div class="table-responsive small">
              <table class="table table-hover table-borderless table-striped align-middle table-sm">
                <thead class="border-black border-bottom">
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Transaction No.</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date Ordered</th>
                    <th scope="col">Sugar Content (Less 10 to 50%)</th>
                    <th scope="col">Writing</th>
                    <th scope="col">Status</th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Note</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  

                    @forelse ($orders as $item)  
                      
                      <tr>
                        <input type="hidden" name="order_id[]" value="{{ $item->order_id }}">
                        <td>{{ $count++ }}</td>
                        <td>{{ $item->transaction_number }}</td>
                        <td>
                          <img src="{{ asset('images/'. $item->image) }}" alt="{{ $item->description }}" width="50" height="50" class="img-thumbnail">
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
                          <input type="number" min="1" name="order_quantity[]" onchange="onChangeQuantity(event, {{$item->order_id}})" class="quantity form-control form-control-sm"  value="{{ $item->order_quantity }}" style="max-width: 5em; min-height: 2em; text-align:center;">
                        </td>
                        <td class="total" name="total">
                          {{ $item->unit_price * 1 }}.00
                        </td>
                        <td>{{ $item->sales_date }}</td>
                        {{-- for cakes --}}
                        @if ($item->category_name === 'Cakes')
                          <td>
                            <input type="hidden" name="transaction_number[]" value="{{ $item->transaction_number }}">
                            <input type="number" min="10" max="50" name="sugar_content[]" onchange="onChangeSugarContent(event, {{$item->order_id}})" class="sugar_content" value="{{ $item->sugar_content }}" style="max-width: 5em; min-height: 3em; text-align:center;">
                          </td>
                          <td>
                            <textarea name="writing[]" onchange="onChangeWriting(event, {{$item->order_id}})" class="writing" cols="20" rows="2" maxlength="100" wrap="hard"> {{ $item->writing }} </textarea>
                          </td>
                        @else
                          <td></td>
                          <td></td>
                        @endif

                        <td>
                          <select name="payment_status[]" onchange="onChangeStatus(event, {{$item->order_id}})" class="form-select border border-success form-select-sm" id="selectPaymentStatus{{$count++}}">
                            <option value="unpaid" {{ $item->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $item->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partially paid" {{ $item->status == 'partially paid' ? 'selected' : '' }}>Partially</option>
                            <option value="fully paid" {{ $item->status == 'fully paid' ? 'selected' : '' }}>Fully Paid</option>
                          </select>
                        </td>
                        <td>
                          <input type="number" min="1" max="{{ $item->sales_total_amount }}" name="paid_amount[]" onchange="onChangePaidAmount(event, {{$item->order_id}})" oninput="validateInput(this)" class="paid_amount" value="{{ $item->paid_amount }}" style="max-width: 5.5em; min-height: 3em; text-align:center;">
                        </td>
                        <td>
                          <select name="payment_method[]" onchange="onChangePaymentMethod(event, {{$item->order_id}})" class="form-select border border-success form-select-sm" id="selectPaymentMethod{{$count++}}" style="max-width: 10em;">
                            <option value="cash" {{ $item->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="e-wallet" {{ $item->payment_method == 'e-wallet' ? 'selected' : '' }}>E-wallet (Gcash)</option>
                            <option value="cod" {{ $item->payment_method == 'cod' ? 'selected' : '' }}>COD (Cash on Delivery)</option>
                          </select>
                        </td>
                        <td>
                          <textarea name="note" onchange="onChangeNote(event, {{$item->order_id}})" class="note" cols="20" rows="2" maxlength="255" wrap="hard"> {{ $item->note }} </textarea>
                        </td>
                      </form> 
                      {{-- form complete  --}}                    
                        <td>
                          <form action="{{ route('admin.orders.destroy', $item->order_id) }}" method="POST" class="deleteTransaction mx-2" id="formDelete{{$count++}}">
                            @csrf
                            <button type="submit" class="nav-link text-danger btnDelete">
                              <i class="bi bi-x-lg"></i>
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
              {{-- {{ $sales_orders->links() }} --}}
            </div>
              
            <div class="col-12">
              <a class="btn btn-danger" href="{{route('admin.orders')}}">Cancel</a>
            </div>

        </div>

        
  @endisset

      </div>
    </main>

    @push('dashboard-scripts')
        <script>
          function validateInput(input) {
              var minValue = parseFloat(input.min);
              var maxValue = parseFloat(input.max);

              // Parse the entered value as a float
              var enteredValue = parseFloat(input.value);

              // Check if the entered value is above the maximum
              if (!isNaN(enteredValue) && enteredValue > maxValue) {
                  // If above the maximum, set the value to the maximum
                  input.value = maxValue.toFixed(2);
              }

              // Check if the entered value is below the minimum
              if (!isNaN(enteredValue) && enteredValue < minValue) {
                  // If below the minimum, set the value to the minimum
                  input.value = minValue.toFixed(2);
              }
          }

          function onChangePaidAmount(e, id) {
            e.preventDefault();
            var value = e.target.value;

            // Fetch API request to update the status
            fetch('/order-update-paid-amount/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  paidAmount: value
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: "{{Session::get('success')}}",
                })
            });
          }
          
          function onChangeQuantity(e, id) {
            e.preventDefault();
            var value = e.target.value;

            // Fetch API request to update the status
            fetch('/order-update-qty/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  qty: value
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: "{{Session::get('success')}}",
                })
            });
          }

          function onChangeStatus(e, id) {
            e.preventDefault();
            var selectedStatus = e.target.value;

            // Fetch API request to update the status
            fetch('/order-update/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  status: selectedStatus
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: "{{Session::get('success')}}",
                })
            });
          }

          function onChangeSugarContent(e, id) {
            e.preventDefault();
            var value = e.target.value;

            if(value > 50) {
              window.alert('Maximum 50% less sugar allowed!');
              value = 50;
            }
            if(value < 10) {
              window.alert('Minimum 10% less sugar allowed!');
              value = 10;
            }

            // Fetch API request to update the status
            fetch('/order-update-sugar-content/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  sugarContent: value
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: error,
                })
            });

          }

          function onChangeWriting(e, id) {
            e.preventDefault();
            var value = e.target.value;

            // Fetch API request to update the status
            fetch('/order-update-writing/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  writing: value
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: error,
                })
            });
          }

          function onChangePaymentMethod(e, id) {
            e.preventDefault();
            var value = e.target.value;

            // Fetch API request to update the status
            fetch('/order-update-payment-method/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  paymentMethod: value
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: error,
                })
            });
          }

          function onChangeNote(e, id) {
            e.preventDefault();
            var value = e.target.value;

            // Fetch API request to update the status
            fetch('/order-update-payment-note/' + id, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                  paymentNote: value
                })
            })
            .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                Toast.fire({
                  icon: "success",
                  title: data.success,
                })
            })
            .catch(error => {
                Toast.fire({
                  icon: "success",
                  title: error,
                })
            });
          }
          
          
          document.addEventListener('readystatechange', function() {

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

            var form = document.querySelectorAll(".deleteTransaction");
            form.forEach(element => {
              element.addEventListener('submit', function(e) {
                e.preventDefault();
                if(e.currentTarget) {
                  var form = e.currentTarget;
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Cancel Order!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!',
                  }).then(function (result) {
                    if (result.isConfirmed) {
                      form.submit();
                    }
                  })
                }
              })
            });

            var formComplete = document.getElementById('completeOrderForm');
            formComplete.addEventListener('submit', function(e) {
                e.preventDefault();
                if(e.currentTarget) {
                  var form = e.currentTarget;
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to complete this transaction. Make sure items are correct.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!',
                  }).then(function (result) {
                    if (result.isConfirmed) {
                      formComplete.submit();
                    }
                  })
                }
              })

          });
        </script>
    @endpush

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
        var hSubtotal = document.getElementById('hidden-subtotal');
        var qty = document.querySelectorAll('.quantity');
    
        let sum = 0;
    
        qty.forEach(function (el, key) {
            let val = el.value;
            total[key].textContent = (val * price[key].textContent).toFixed(2);
        });
    
        total.forEach(function (e) {
            sum += parseFloat(e.textContent);
        });
        hSubtotal.value = sum.toFixed(2);
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