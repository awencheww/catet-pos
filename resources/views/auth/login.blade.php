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

    <form method="POST" action="{{route('auth.login')}}">
      @csrf
      {{-- component form-logo --}}
      <x-form-logo></x-form-logo>
      
      <h1 class="h2 mb-3 fw-normal">Please Login</h1>

      <div class="form-floating">
        <input type="text" class="form-control @error('username') is-invalid @enderror ?: @error('email') is-invalid @enderror" id="login_email_username" name="login_email_username" value="{{old('login_email_username')}}" placeholder="name@example.com" autofocus>
        <label for="login_email_username">Email / Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}" placeholder="Password">
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
    <p><a href="{{route('forgot.password')}}" class="text-danger text-decoration-none">Forgot your password?</a> </p>
    <p>Don't have an account yet? <a href="{{route('register')}}" class="text-decoration-none text-primary">Register now</a> </p>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
  </main>

  @push('auth-scripts')
    @if (Session::has('status'))
      <script type="text/javascript">
        Swal.fire({
          icon: 'success',
          title: 'Reset Password',
          text: "{{session()->get('status')}}",
        })
      </script>
    @endif
  @endpush
@endsection