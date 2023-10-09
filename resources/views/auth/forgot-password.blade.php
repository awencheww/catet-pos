@extends('layouts.auth')
@section('title')
  {{"Forgot Password · Catet's Sweets & Cakes"}}
@endsection
@section('theme')
    <x-toggle-theme>
      <x-slot:title>{{'Toggle Theme'}}</x-slot:title>
    </x-toggle-theme>
@endsection
@section('content')
  @if (Session::has('error'))
  <script type="text/javascript">
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: "{{session()->get('error')}}",
      // footer: '<a href="">Why do I have this issue?</a>'
    })
  </script>
  @endif

<main class="form-signin w-100 m-auto text-center">
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
          @foreach ($errors->all() as $error)
              <li class="text-left">{{$error}}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
    <form method="POST" action="{{route('password.email')}}">
      @csrf
      {{-- component form-logo --}}
      <x-form-logo></x-form-logo>
      
      <h3 class="mb-3 fw-normal">RESET YOUR PASSWORD</h3>
      <p>Lost your password? Please enter your email address. You will receive a link to create a new password via email.</p>
      @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('status') }}
        </div>
      @endif
      <div class="form-floating">
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" placeholder="name@example.com">
        <label for="email">Email</label>
      </div>

      <button class="btn btn-primary w-100 py-2 mb-2" type="submit">EMAIL PASSWORD RESET LINK</button>
    </form>
    <a href="{{route('login')}}">
      <button class="btn btn-outline-secondary w-100 py-2 mb-2">
        <i class="bi bi-arrow-left-square"> Cancel </i>
      </button>
    </a>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
  </main>
@endsection