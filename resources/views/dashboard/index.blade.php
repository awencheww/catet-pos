@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.header')
@endsection
@section('content')
    @include('dashboard.partials.sidebar')
    @include('dashboard.partials.chart')
@endsection