<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <x-theme-js-link></x-theme-js-link>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Dashboard ·Catet's Sweets & Cakes</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <x-fav-icon></x-fav-icon>
    <x-css-link></x-css-link>
    <script src="{{asset('assets/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/custom/css/dashboard.css') }}" rel="stylesheet">
  </head>
  <body>
    <x-toggle-theme>
      <x-slot:title>{{'Toggle Theme'}}</x-slot:title>
    </x-toggle-theme>
    {{-- sweetalert toast --}}
    @if ($message = Session::get('success'))
      <script type="text/javascript">
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          title: '{{ $message }}'
        })
      </script>
    @endif

@yield('header')

<div class="container-fluid">
  <div class="row">

    @yield('content')

  </div>
</div>
<script src="{{ asset('assets/bootstrap-5.3.2/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<script src="{{ asset('assets/custom/js/dashboard.js') }}"></script>

<script>
  window.deleteConfirm = function(e) {
    e.preventDefault();
    var form = e.target.form;
    if(window.confirm("Are you sure you want delete this User?")) {
      form.submit();
    }
    // Swal.fire({
    //   title: 'Are you sure?',
    //   text: "You won't be able to revert this!",
    //   icon: 'warning',
    //   showCancelButton: true,
    //   confirmButtonColor: '#3085d6',
    //   cancelButtonColor: '#d33',
    //   confirmButtonText: 'Yes, delete it!'
    // }).then((result) => {
    //   if (result.isConfirmed) {
    //     form.submit();
    //   }
    // })
  }

  @if ($message = Session::get('success'))
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })

    Toast.fire({
      icon: 'success',
      title: {{Session::get('success')}}
    })
  @endif
</script>
</html>
