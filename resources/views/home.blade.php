@extends('layouts.home')
@section('storefront-main')
    <!-- Header -->
    @includeWhen(request()->routeIs('home'), 'storefront.partials.header')
    <!-- Products Homepage -->
    @includeWhen(request()->routeIs('home'), 'storefront.partials.products')
@endsection