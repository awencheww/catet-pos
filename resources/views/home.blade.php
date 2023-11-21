<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <x-theme-js-link></x-theme-js-link>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Home &#x2022; Catet's Sweets & Cakes</title>

        <x-fav-icon></x-fav-icon>
        <x-css-link></x-css-link>
        <script src="{{asset('assets/sweetalert2/sweetalert2.min.js')}}"></script>
        <style>
          .carousel-item > img {
            max-height: 40em;
          }
          .carousel-caption {
            background-image: linear-gradient(60deg, rgba(86, 114, 185, 0.5), rgba(232, 50, 131, 0.5)) !important;
            left: 0px;
            bottom: 230px;
          }
          #offcanvasTray {
            width: 650px;
          }
          .offcanvas-body {
            padding-top: 0px;
          }
        </style>
    </head>
    <body>
      <x-toggle-theme>
        <x-slot:title>{{'Toggle Theme'}}</x-slot:title>
      </x-toggle-theme>

        <!-- Navigation -->
        @include('storefront.partials.nav')

        <!-- Header -->
        @include('storefront.partials.header')

        <!-- Tray -->
        @include('storefront.partials.tray')


        <!-- Section Products-->
        <section>
            <div class="container mt-4">
                <div class="row gx-3 gx-md-3 mx-2 gx-lg-3 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">

                    @foreach ($products as $product)
                      
                      <div class="col">
                        <div class="card mb-3">
                            <!-- Sale badge-->
                            {{-- <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div> --}}
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ asset('images/'.$product->image) }}" alt="{{ $product->description }}" style="max-height: 200px" />
                            <!-- Product details-->
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h4 class="card-title">{{ $product->product_name }}</h4>
                                    <h6 class="card-subtitle text-muted">{{ $product->description }}</h6>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    {{-- <span class="text-muted text-decoration-line-through">$20.00</span> --}}
                                    <h5 class="card-text">
                                      @php
                                        $fmt = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
                                        $code = $fmt->getTextAttribute(NumberFormatter::CURRENCY_CODE);
                                        $formattedCurrency = $fmt->formatCurrency($product->unit_price, $code);
                                        echo $formattedCurrency;
                                      @endphp
                                    </h5>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer pt-0 border-top-0 bg-transparent text-center">
                              <form action="{{ route('add.tray') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <button type="submit" class="btn btn-success mt-auto">Add to tray</button>
                              </form>
                            </div>
                        </div>
                      </div>

                    @endforeach
                    
                </div>
            </div>
        </section>
        
        @include('storefront.partials.footer')

        <x-body-js-link></x-body-js-link>
        {{-- sweetalert toast --}}
          <script type="text/javascript">

            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 2000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

            @if ($message = Session::get('info'))
              Swal.fire({
                icon: 'info',
                title: 'Login Account',
                text: "{{session()->get('info')}}",
                showCancelButton: true,
                confirmButtonText: "Confirm"
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  window.location.href = "{{ route('login') }}";
                }
              });
            @endif

            @if ($message = Session::get('success'))
              Toast.fire({
                icon: "success",
                title: "{{ $message }}",
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

          </script>
    </body>
</html>
