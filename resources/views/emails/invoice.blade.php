<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Invoice Email &#x2022; Catet's Sweets & Cakes</title>

    <x-fav-icon></x-fav-icon>
    <x-css-link></x-css-link>
  </head>
  <style>
    .main {
      background-color: #ffffff;
      padding-bottom: 60px;
      border-spacing: 0;
      font-family: sans-serif;
      color: #171a1b;
      text-align: left;
    }
  </style>
  <body>


    {{-- @dd($invoice[0]['name']) --}}
    <h3>Invoice Number: {{ $invoice[0]['sales_invoice_number'] }}</h3>
    <h4>Customer Name: {{ $invoice[0]['name'] }}</h4>
  
    <table style="border: 1px solid black;" class="main">
        <thead>
            <tr style="background-color: gray">
                <th style="text-align: left; border: #171a1b 1px solid; adding: 5px;" scope="col">Product ID</th>
                <th style="text-align: left; border: #171a1b 1px solid; adding: 5px;" scope="col">Item</th>
                <th style="text-align: left; border: #171a1b 1px solid; adding: 5px;" scope="col">Quantity</th>
                <th style="text-align: left; border: #171a1b 1px solid; adding: 5px;" scope="col">Price</th>
                <th style="text-align: left; border: #171a1b 1px solid; adding: 5px;" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
              $subtotal = 0;
            @endphp
            @foreach($invoice as $item)
                
                <tr>
                    <td style="text-align: left; border: #171a1b 1px solid; adding: 5px;">{{ $item->product_id }}</td>
                    <td style="text-align: left; border: #171a1b 1px solid; adding: 5px;">{{ $item->product_name }}</td>
                    <td style="text-align: left; border: #171a1b 1px solid; adding: 5px;">{{ $item->order_quantity }}</td>
                    <td style="text-align: left; border: #171a1b 1px solid; adding: 5px;">{{ $item->price }}</td>
                    <td style="text-align: left; border: #171a1b 1px solid; adding: 5px;">{{ $item->total_amount }}</td>
                </tr>
                @php
                  $subtotal += $item->total_amount;
                @endphp
            @endforeach
        </tbody>
    </table>
  
    <h4>Total Amount: {{ $subtotal }}.00</h4>
    <h4>Date Ordered: {{ $invoice[0]['sales_date'] }}</h4>


  <script src="{{ asset('assets/bootstrap-5.3.2/js/bootstrap.bundle.min.js') }}"></script>

  </body>
</html>
