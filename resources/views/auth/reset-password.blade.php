@extends('layouts.auth')
@section('title')
  {{"Reset Password · Catet's Sweets & Cakes"}}
@endsection
@section('theme')
    <x-toggle-theme>
      <x-slot:title>{{ 'Toggle Theme' }}</x-slot:title>
    </x-toggle-theme>
@endsection
@section('content')
  <main class="form-register w-100 m-auto text-center">
    <form method="POST" action="{{route('password.store')}}">
      @csrf
      <!-- Password Reset Token -->
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      {{-- component form-logo --}}
      <x-form-logo></x-form-logo>

      <h1 class="h2 mb-3 fw-normal">RESET YOUR PASSWORD</h1>

      <div class="form-floating mb-2">
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email', $request->email)}}" placeholder="email@example.com" readonly>
        <label for="email">Email</label>
        @error('email') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>

      <div class="form-floating mb-2">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" autofocus autocomplete="new-password">
        <label for="password">New Password</label>
        @error('password') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>
      <div class="form-floating mb-4">
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="Confirm Password">
        <label for="password_confirmation">Confirm New Password</label>
        @error('password_confirmation') <span class="invalid-feedback">{{$message}}</span> @enderror
      </div>

      <button class="btn btn-primary w-100 py-2 mb-2" type="submit">Reset Password</button>
    </form>
    <a href="{{route('home')}}">
      <button class="btn btn-outline-secondary w-100 py-2 mb-2">
        <i class="bi bi-arrow-left-square"> Cancel </i>
      </button>
    </a>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
  </main>
@endsection
