<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasTray" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasTrayLabel">Your Tray</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

    @isset($tray)
      <form action="{{ route('tray.checkout') }}" method="post">
        @csrf

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
                      <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                      <img src="{{ asset('images/'. $item->image) }}" alt="{{ $item->description }}" width="100" height="100">
                      {{ $item->product_name }}
                    </td>
                    <td class="price">
                      <input type="hidden" name="price" value="{{ $item->unit_price }}">
                      {{ $item->unit_price }}
                    </td>
                    <td>
                      <input type="number" min="1" name="quantity" class="quantity"  value="1" style="max-width: 6em; min-height: 3em; text-align:center;">
                    </td>
                    <td class="total" name="total">
                      <input type="hidden" name="total" value="{{ $item->unit_price * 1 }}">
                      {{ $item->unit_price * 1 }}.00
                    </td>
                    <td>
                      <a href="#" class="text-danger">
                        <i class="bi bi-x-lg"></i>
                      </a>
                    </td>
                  </tr>
              @empty
                  <tr>
                    <td class="text-center" colspan="20">No items to display. <a href="{{ route('storefront.index') }}">Continue Shopping</a></td>
                  </tr>
              @endforelse
                <tr class="align-middle">
                  <td style="text-align: right;" colspan="3"><h5 style="margin: 0px;">Subtotal</h5></td>
                  <td colspan="2" style="font-size: 2em;"><strong name="subtotal" id="subtotal"></strong></td>
                </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-end px-3">
            {{-- //TODO: Checkout function Note: add invoice id for tracking and saving it to sales order --}}
            <button type="submit" id="checkout" class="btn btn-primary btn-lg">Checkout</button>
          </div>
        </div>

      </form>
    @endisset
    
  </div>
</div>

<script>
  var price = document.querySelectorAll('.price')
  var total = document.querySelectorAll('.total')
  var subtotal = document.getElementById('subtotal')
  var qty = document.querySelectorAll('.quantity')
  qty.forEach(function(el, key) {
    el.addEventListener('change', (e) => {
      let sum = 0;
      let val = e.target.value;
      total[key].textContent = val * price[key].textContent+'.00';
      
      total.forEach(function(e, key) {
        sum += parseInt(e.textContent, 10);
      })
      subtotal.innerText = sum+'.00';
    })
  })
  //show subtotal when its loaded
  total.forEach(function(e, key) {
    subtotal.innerText += parseInt(e.textContent, 10)+'.00';
  })

  @isset($tray)
    var btn = document.getElementById('checkout')
    btn.addEventListener('submit', function() {

    })
  @endisset

</script>