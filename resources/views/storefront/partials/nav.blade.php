<nav class="navbar bg-primary navbar-expand-lg sticky-top" data-bs-theme="dark">
  <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="#!"><img src="{{ asset('assets/icon/fav-icon.png') }}" alt="Catet's Sweets & Cakes" width="87" height="40"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
              <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="#!">All Products</a></li>
                      <li><hr class="dropdown-divider" /></li>
                      <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                      <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                  </ul>
              </li>
          </ul>
          <div class="me-auto text-center">
            <a href="{{ route('/users') }}" class="btn btn-primary btn-sm">
              Your Tray
              <i class="bi-cart4" style="font-size: 1.3em;">
              </i>
              
            </a>
            <span class="badge bg-danger-subtle text-white ms-1 rounded-pill" style="position: relative; top:-1.2em; right: 2.5em; font-size:.6em;">500</span>
          </div>
          @guest
            <a href="{{route('login')}}">
              <button class="btn btn-primary btn-sm m-1" type="button">
                <i class="bi bi-arrow-right-square"></i>
                Login
              </button>
            </a>
            {{ 'or' }}
            <a href="{{route('register')}}">
              <button class="btn btn-secondary btn-sm m-1" type="button">
                <i class="bi bi-person-plus"></i>
                Register
              </button>
            </a>
          @endguest

          @auth
            <form action="{{ route('logout') }}" method="POST" class="p-0 m-1">
              @csrf
              <button class="btn btn-outline-danger btn-sm" type="submit">
                <i class="bi bi-arrow-left-square"></i>
                Logout
              </button>
            </form>
            
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'cashier')
              <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-person-circle">
                </i>
                {{Auth::user()->username}}
              </a>
            @else
              <a href="{{ route('customer.profile') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-person-circle">
                </i>
                {{Auth::user()->username}}
              </a>
            @endif
          @endauth
      </div>
  </div>
</nav>