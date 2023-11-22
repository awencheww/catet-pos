@extends('layouts.auth')
@section('title')
  {{"Register · Catet's Sweets & Cakes"}}
@endsection
@section('theme')
    <x-toggle-theme>
      <x-slot:title>{{ 'Toggle Theme' }}</x-slot:title>
    </x-toggle-theme>
@endsection
@section('content')
  <main class="form-register w-100 m-auto text-center">
    @if (Session::has('success'))
      <div class="alert alert-success" role="alert">
        {{session()->get('success')}}
      </div>
    @endif
    <form method="POST" action="{{route('customer.register')}}">
      @csrf
      {{-- component form-logo --}}
      <x-form-logo></x-form-logo>

      <h1 class="h2 mb-3 fw-normal">Register an account</h1>
      <p>and get exciting deals!</p>

      <div class="form-floating mb-2">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Juan Dela Cruz">
        <label for="name">Name</label>
        @error('name') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>
      <div class="form-floating mb-2">
        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{old('username')}}" placeholder="juan_user">
        <label for="username">Username</label>
        @error('username') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>

      <div class="form-floating mb-2">
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email')}}" placeholder="email@example.com">
        <label for="email">Email</label>
        @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>

      <div class="form-floating mb-2">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="{{old('password')}}" placeholder="Password">
        <label for="password">Password</label>
        @error('password') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>
      <div class="form-floating mb-4">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="password-confirm" autocomplete="new-password" placeholder="Password">
        <label for="password-confirm">Confirm Password</label>
      </div>

      <button class="btn btn-primary w-100 py-2 mb-2" type="submit">Register</button>
    </form>
    <a href="{{route('home')}}">
      <button class="btn btn-outline-secondary w-100 py-2 mb-2">
        <i class="bi bi-arrow-left-square"> Cancel </i>
      </button>
    </a>
    <p>Already have an account? <a href="{{route('login')}}" class="text-decoration-none text-primary">Login instead</a> </p>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
  </main>
@endsection
