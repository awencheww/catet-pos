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
    <form>
      @csrf
      {{-- component form-logo --}}
      <x-form-logo></x-form-logo>

      <h1 class="h2 mb-3 fw-normal">Register an account</h1>
      <p>and get exciting deals!</p>

      <div class="form-floating mb-2">
        <input type="text" class="form-control" name="name" id="name" placeholder="Juan Dela Cruz">
        <label for="name">Name</label>
      </div>
      <div class="form-floating mb-2">
        <input type="text" class="form-control" name="username" id="username" placeholder="juan_user">
        <label for="username">Username</label>
      </div>

      <div class="form-floating mb-2">
        <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
        <label for="email">Email</label>
      </div>
      <div class="form-floating mb-4">
        <input type="password" class="form-control" id="password" placeholder="Password">
        <label for="password">Password</label>
      </div>

      <button class="btn btn-primary w-100 py-2 mb-2" type="submit">Register</button>
    </form>
    <a href="{{route('home')}}">
      <button class="btn btn-outline-secondary w-100 py-2 mb-2">
        <i class="bi bi-arrow-left-square"> Cancel </i>
      </button>
    </a>
    <p>Already have an account? <a href="{{route('login')}}">Login instead</a> </p>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
  </main>
@endsection
