<header class="bg-dark-subtle m-0 p-0" data-bs-theme="light">

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

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>

      <div class="carousel-caption d-none d-md-block d-lg-block w-100">
        <h1 class="text-white">Welcome to Catet's Sweets & Cakes!</h1>
        <h3 class="text-white text-muted">Some of Our Featured Cakes and Desert</h3>
        <p class="text-white">Start shopping now to have an exclusive deals and become our members soon.</p>
        <a href="{{ route('storefront.index') }}" class="btn btn-primary btn-lg">View Products</a>
      </div>

    </div>
  </div>
  
</header>