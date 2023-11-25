@extends('layouts.home')
@section('storefront-main')
    <!-- Products Homepage -->
    @includeWhen(request()->routeIs('home'), 'storefront.partials.products')
@endsection