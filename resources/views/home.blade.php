<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <x-theme-js-link></x-theme-js-link>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Home &#x2022; Catet's Sweets & Cakes</title>

        <x-fav-icon></x-fav-icon>
        <x-css-link></x-css-link>
        <script src="{{asset('assets/sweetalert2/sweetalert2.min.js')}}"></script>
        <style>
          .carousel-item > img {
            max-height: 40em;
          }
          .carousel-caption {
            background-image: linear-gradient(60deg, rgba(86, 114, 185, 0.5), rgba(232, 50, 131, 0.5)) !important;
            left: 0px;
            bottom: 0px;
          }
        </style>
    </head>
    <body>
      <x-toggle-theme>
        <x-slot:title>{{'Toggle Theme'}}</x-slot:title>
      </x-toggle-theme>

        <!-- Navigation -->
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
                    <a href="{{ route('/users') }}" class="me-auto text-decoration-none nav-link d-flex align-items-center gap-2">
                      Your Tray
                      <i class="bi-cart4 me-1" style="font-size: 1.3em;">
                      </i>
                      <span class="badge bg-info text-white ms-1 rounded-pill" style="position: relative; top:-1.45em; left:-2.2em; font-size:.5em">500</span>
                    </a>
                    @guest
                      <a href="{{route('login')}}">
                        <button class="btn btn-primary btn-sm m-1" type="button">
                          <i class="bi bi-arrow-right-square"> Login </i>
                        </button>
                      </a>
                      {{ 'or' }}
                      <a href="{{route('register')}}">
                        <button class="btn btn-secondary btn-sm m-1" type="button">
                          <i class="bi bi-person-plus"> Register </i>
                        </button>
                      </a>
                    @endguest

                    @auth
                      <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm m-1" type="submit">
                          <i class="bi bi-arrow-left-square"> Logout </i>
                        </button>
                      </form>
                      
                      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'cashier')
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                          <i class="bi bi-person-circle">
                            {{Auth::user()->username}}
                          </i>
                        </a>
                      @else
                        <a href="{{ route('customer.profile') }}" class="btn btn-secondary btn-sm">
                          <i class="bi bi-person-circle">
                            {{Auth::user()->username}}
                          </i>
                        </a>
                      @endif
                    @endauth
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark-subtle m-0 p-0" data-bs-theme="light">
            {{-- <div class="container px-4 px-lg-5 my-5 text-white text-center">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop homepage template</p>
                </div>
            </div> --}}
            <div class="container-fluid text-white text-center p-0 m-0">
              <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">          
                <div class="carousel-inner">

                  <div class="carousel-item active">
                    <img src="{{asset('showcase/1.jpg')}}" class="d-block w-100" alt="..."> 
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('showcase/2.jpg')}}" class="d-block w-100" alt="...">         
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('showcase/3.jpg')}}" class="d-block w-100" alt="...">         
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('showcase/4.jpg')}}" class="d-block w-100" alt="...">         
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('showcase/5.jpg')}}" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('showcase/6.jpg')}}" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('showcase/7.jpg')}}" class="d-block w-100" alt="...">
                  </div>
                  
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" data-bs-theme="light">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" data-bs-theme="light">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>

                <div class="carousel-caption d-none d-md-block d-lg-block w-100">
                  <h2 class="text-white">Some of Our Featured Cakes and Desert</h2>
                  <p class="text-white">Start shopping now to have an exclusive deals and become our members soon.</p>
                  <button class="btn btn-primary btn-lg">View Products</button>
                </div>

              </div>
            </div>
        </header>
        <!-- Section Products-->
        <section>
            <div class="container mt-4">
                <div class="row gx-3 gx-md-3 mx-2 gx-lg-3 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">

                    {{-- <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Fancy Product</h5>
                                    <!-- Product price-->
                                    $40.00 - $80.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div> --}}

                    @foreach ($products as $product)

                      <div class="col">
                        <div class="card mb-3">
                            <!-- Sale badge-->
                            {{-- <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div> --}}
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ asset('images/'.$product->image) }}" alt="{{ $product->description }}" style="max-height: 200px" />
                            <!-- Product details-->
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h4 class="card-title">{{ $product->product_name }}</h4>
                                    <h6 class="card-subtitle text-muted">{{ $product->description }}</h6>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    {{-- <span class="text-muted text-decoration-line-through">$20.00</span> --}}
                                    {{-- //TODO: DISPLAY MONEY FORMAT --}}
                                    <h5 class="card-text text-decoration-underline">Php{{ $product->unit_price }}</h5>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to tray</a></div>
                            </div>
                        </div>
                      </div>

                    @endforeach
                    
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        
        <x-body-js-link></x-body-js-link>
        {{-- sweetalert toast --}}
        @if ($message = Session::get('success'))
          <script type="text/javascript">
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

            Toast.fire({
              icon: 'success',
              title: '{{ $message }}'
            })
          </script>
        @endif
    </body>
</html>
