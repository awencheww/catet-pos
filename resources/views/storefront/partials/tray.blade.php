{{-- FORM CHECKOUT --}}
<form action="{{ route('tray.checkout') }}" method="post">
  @csrf

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasTray" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    
    @guest
        <h5 class="offcanvas-title">Your Tray</h5>
    @endguest

      @auth
        @if(count($tray) > 0)
          <a href="{{ route('customer.tray') }}" class="btn btn-primary" id="offcanvasTrayLabel">
            <i class="bi bi-eye"></i>
            View Your Tray
          </a>

          <h4 id="subtotal-header" style="margin-left: 2em;">Subtotal: <strong style="font-size: 1.3em;" name="subtotal" id="subtotal"></strong></h4>

          {{-- //TODO: Checkout function Note: add invoice id for tracking and saving it to sales order --}}
          <button type="submit" class="btn btn-success" style="margin-left: 2em;">Checkout</button>
        @endif
      @endauth

      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

      @isset($tray)

        <div class="table-responsive small caption-top">
          <caption>List of Products</caption>
            <table class="table table-hover table-borderless align-middle table-sm">
            <thead>
              <tr>
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
                    <td>
                      <input type="hidden" name="tray_id[]" value="{{ $item->tray_id }}">
                      <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                      <img src="{{ asset('images/'. $item->image) }}" alt="{{ $item->description }}" width="100" height="100">
                      {{ $item->product_name }}
                      {{ $item->variant }}
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
        </div>

      @endisset
      
    </div>
  </div>

@push('home-scripts')
  @isset($tray)
  <script>
    function currencyFormat(amount) {
      // Parse the text content as a float
      // var amount = parseFloat(myElement.innerText);
      // Format the amount as currency
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

    // @isset($tray)
    //   var btn = document.getElementById('checkout')
    //   btn.addEventListener('submit', function() {

    //   })
    // @endisset

  </script>
  @endisset
@endpush