@extends('layouts.auth')
@section('title')
  {{"Login · Catet's Sweets & Cakes"}}
@endsection
@section('theme')
    <x-toggle-theme>
      <x-slot:title>{{'Toggle Theme'}}</x-slot:title>
    </x-toggle-theme>
@endsection
@section('content')
<main class="form-signin w-100 m-auto text-center">
    <form>
      @csrf
      {{-- component form-logo --}}
      <x-form-logo></x-form-logo>
      
      <h1 class="h2 mb-3 fw-normal">Please Login</h1>

      <div class="form-floating">
        <input type="text" class="form-control" id="username" placeholder="name@example.com">
        <label for="username">Email / Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="password" placeholder="Password">
        <label for="password">Password</label>
      </div>

      {{-- <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Remember me 
        </label>
      </div> --}}
      <button class="btn btn-primary w-100 py-2 mb-2" type="submit">Login</button>
    </form>
    <a href="{{route('home')}}">
      <button class="btn btn-outline-secondary w-100 py-2 mb-2">
        <i class="bi bi-arrow-left-square"> Cancel </i>
      </button>
    </a>
    <p>Don't have an account yet? <a href="{{route('register')}}">Register now</a> </p>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
  </main>
@endsection