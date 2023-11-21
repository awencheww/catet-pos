<nav class="navbar bg-dark-subtle navbar-expand-lg sticky-top" data-bs-theme="dark">
  <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/icon/fav-icon.png') }}" alt="Catet's Sweets & Cakes" width="87" height="40"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
              <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="{{ route('storefront.index') }}">All Products</a></li>
                      <li><hr class="dropdown-divider" /></li>
                      <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                      <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                  </ul>
              </li>
          </ul>

          <ul class="navbar-nav mb-lg-0 ms-lg-4 d-inline-flex">
            @guest
              <li class="nav-item" style="margin-right: 3px; margin-bottom: 3px;">
                <a href="{{route('login')}}" class="btn btn-primary nav-item btn-sm">
                  <i class="bi bi-arrow-right-square"></i>
                  Login
                </a>
              </li>
              <li class="nav-item" style="margin-right: 3px; margin-bottom: 3px;">
                <a href="{{route('register')}}" class="btn btn-success nav-item btn-sm">
                  <i class="bi bi-person-plus"></i>
                  Register
                </a>
              </li>
            @endguest
            
            @auth
              <form action="{{ route('logout') }}" method="POST" class="nav-item" style="margin-right: 3px; margin-bottom: 3px;">
                @csrf
                <button class="btn btn-outline-warning btn-sm" type="submit">
                  <i class="bi bi-arrow-left-square"></i>
                  Logout
                </button>
              </form>
              @if (Auth::user()->role == 'admin' || Auth::user()->role == 'cashier')
                <li class="nav-item" style="margin-right: 3px; margin-bottom: 3px;">
                  <a href="{{route('dashboard')}}" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-circle">
                    </i>
                    {{Auth::user()->username}}
                  </a>
                </li>
              @else
                <li class="nav-item" style="margin-right: 3px; margin-bottom: 3px;">
                  <a href="{{route('customer.profile')}}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-person-circle">
                    </i>
                    {{Auth::user()->username}}
                  </a>
                </li>
              @endif
            @endauth
            
            <li class="nav-item" style="margin-left: 3px; margin-right: 3px; margin-bottom: 3px;">
              {{ '|' }}
              <a class="btn btn-outline-primary btn-sm" data-bs-toggle="offcanvas" href="#offcanvasTray" role="button" aria-controls="offcanvasTray">
                Your Tray
                <i class="bi-cart4">
                </i>
              </a>
              @if (isset($tray_count))
                <span class="badge bg-danger text-white ms-1 rounded-pill" style="position: relative; top:-1em; right: 1.8em; font-size:.8em;">{{$tray_count}}</span>
              @endif
            </li>
          </ul>
          
      </div>
  </div>
</nav>