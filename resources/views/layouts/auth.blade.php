<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <x-theme-js-link></x-theme-js-link>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    {{-- named $slot can be used as component and call it as <x-slot:title></x-slot:title> to any blade.php file --}}
    <title>@yield('title')</title>
    
    <x-fav-icon></x-fav-icon>
    <x-css-link></x-css-link>
    
    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/custom/css/login-register.css') }}" rel="stylesheet">
  </head>
  <body class="d-flex py-4 bg-body-tertiary">
    
    @yield('theme')

    @yield('content')


    <x-body-js-link></x-body-js-link>

    </body>
</html>
