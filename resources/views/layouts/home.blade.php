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
            bottom: 210px;
          }
          #filter {
            top: 5.5em;
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
      
      <div class="container-fluid">
        <div class="row">
      
            <!-- Section Products-->
            @yield('storefront-main')
      
        </div>
      </div>
      
      <!-- Footer -->
      @include('storefront.partials.footer')

        <x-body-js-link></x-body-js-link>
        {{-- custom scripts --}}
        @stack('home-scripts')
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
