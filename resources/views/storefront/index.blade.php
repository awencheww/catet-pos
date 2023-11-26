@extends('layouts.home')
@section('storefront-main')

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
                          @if ($product->variant != null)
                            <p>( {{ $product->variant }} )</p>
                          @endif
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
                            @money($product->unit_price)
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
                <p>Product not found.</p>
              </div>
            </div>
          @endforelse
              
            
        </div>
    </div>

  @push('home-scripts')
      <script>
        document.addEventListener('readystatechange', function() {
          var form = document.querySelectorAll(".delete");
          form.forEach(element => {
            element.addEventListener('submit', function(e) {
              e.preventDefault();
              if(e.currentTarget) {
                var form = e.currentTarget;
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!',
                }).then(function (result) {
                  if (result.isConfirmed) {
                    form.submit();
                  }
                })
              }
            })
          });

          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: function (toast) {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
          })
          
          @if ($message = Session::get('success'))
            Toast.fire({
              icon: "success",
              title: "{{ $message }}",
            })
          @endif
          
          @if ($message = Session::get('error'))
            Toast.fire({
              icon: "error",
              title: "{{ $message }}",
            })
          @endif

          @if ($message = Session::get('warning'))
            Toast.fire({
              icon: "warning",
              title: "{{ $message }}",
            })
          @endif

        });
      </script>
    @endpush
@endsection