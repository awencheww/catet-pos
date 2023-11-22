@extends('layouts.home')
@section('storefront-main')

@include('storefront.partials.tray')

  <main class="px-md-4 p-3 mb-5">
    {{-- Breadcrumbs --}}
    <div class="row p-2">
      {{ Breadcrumbs::render('storefront.index') }}
    </div>

    {{-- //TODO: Add filtering products here, by price, supplier, category-- inpiration for the design https://freedsbakery.com/collections/bestsellers-cakes-desserts-las-vegas --}}

    <div class="row sticky-top" id="filter">
      <div class="col col-md-2 col-lg-2 justify-content-center align-items-center">
        <a class="btn btn-primary mb-2" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
          <i class="bi bi-filter"></i>
          Filter
        </a>
      </div>

      <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filter Products</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <form method="GET" action="{{ route('storefront.index') }}" accept-charset="UTF-8" role="search">
            
              <div class="input-group mb-3">
                <button class="btn btn-primary" type="submit" id="button-addon1"><i class="bi bi-search"></i></button>
                <input type="text" class="form-control border-primary-subtle" name="search" value="{{ request('search') }}" placeholder="Search products.." aria-label="Search products" aria-describedby="button-addon1">
              </div>

              <div class="form-group mb-3">
                <h5>By Categories</h6>
                  @foreach ($categories as $category)
                    
                  @endforeach
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="category_check" value="" checked id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    Default checkbox
                  </label>
                </div>
              </div>
            
              <div class="form-floating mb-2">
                <select name="filter_by" class="form-select" id="floatingSelectGrid">
                  <option value="price_low">Price, Low to High</option>
                  <option value="price_high">Price, High to Low</option>
                  <option value="name_asc">Name, A-Z</option>
                  <option value="name_desc">Name, Z-A</option>
                  <option value="created_asc">Date, Old to New</option>
                  <option value="created_desc" selected>Date, New to Old</option>
                </select>
                <label for="floatingSelectGrid">Filter By</label>
              </div>
          
              <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Submit</button>
          </form>
        </div>
      </div>
      
    </div>

    <div class="container mt-2">

        <div class="row gx-3 gx-md-3 mx-2 gx-lg-3 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">

          @forelse ($products as $product)
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
                          <h5 class="card-text">
                            @php
                              $fmt = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
                              $code = $fmt->getTextAttribute(NumberFormatter::CURRENCY_CODE);
                              $formattedCurrency = $fmt->formatCurrency($product->unit_price, $code);
                              echo $formattedCurrency;
                            @endphp
                          </h5>
                      </div>
                  </div>
                  <!-- Product actions-->
                  <div class="card-footer pt-0 border-top-0 bg-transparent text-center">
                    <form action="{{ route('add.tray') }}" method="post">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                      <button type="submit" class="btn btn-success mt-auto">Add to tray</button>
                    </form>
                  </div>
              </div>
            </div>
          @empty
            <div class="col text-center">
              <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                <p>Prodct not found.</p>
              </div>
            </div>
          @endforelse
              
            
        </div>
    </div>

    {{-- //TODO: TRY TO MAKE IT VISIBLE BY ADDING MORE PROUDCTS, AND LIMIT THE DISPLAY BY 50 --}}
    {{-- PAGINATION --}}
    {{ $products->links() }}
  </main>

@endsection
