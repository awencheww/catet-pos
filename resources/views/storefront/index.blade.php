@extends('layouts.home')
@section('storefront-main')
  <main class="px-md-4 p-3 mb-5">
    {{-- Breadcrumbs --}}
    <div class="row p-2">
      {{ Breadcrumbs::render('storefront.index') }}
    </div>

    {{-- //TODO: Add filtering products here, by price, supplier, category-- inpiration for the design https://freedsbakery.com/collections/bestsellers-cakes-desserts-las-vegas --}}

    <div class="container mt-4">

        <div class="row gx-3 gx-md-3 mx-2 gx-lg-3 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">

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
                        <button type="submit" class="btn btn-outline-secondary mt-auto">Add to tray</button>
                      </form>
                    </div>
                </div>
              </div>

            @endforeach
            
        </div>
    </div>

    {{-- //TODO: TRY TO MAKE IT VISIBLE BY ADDING MORE PROUDCTS, AND LIMIT THE DISPLAY BY 50 --}}
    {{-- PAGINATION --}}
    {{ $products->links() }}
  </main>

@endsection
