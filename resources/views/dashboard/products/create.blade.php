@extends('layouts.dashboard')
@section('header')
    @include('dashboard.partials.svg')
    @include('dashboard.partials.header')
@endsection
@section('content')

    @include('dashboard.partials.sidebar')

    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-3 mb-5">
      <div class="container-fluid">
        {{-- Breadcrumbs --}}
        <div class="row p-2">
          {{ Breadcrumbs::render('products.create') }}
        </div>

        <h2>Add Product</h2>
        <div class="row g-3">

          <form action="{{route('products.store')}}" method="POST" class="row g-3" enctype="multipart/form-data">
            @csrf

            {{-- Render form fields based on the detected fields --}}
            <div class="row g-3">
              @foreach ($fields as $field)

                  @if ($field == 'image')
                    <div class="row g-3">
                      <div class="col-md-2 mb-1">
                        <img id="img-preview" src="" alt="" width="250" height="230" class="img-thumbnail cursor-pointer @error($field) is-invalid @enderror" for="{{ $field }}" style="cursor: pointer;">
                        <div class="mb-3 text-center">
                          <input type="file" accept="image/*" name="{{ $field }}" id="{{ $field }}" class="form-control  d-none">
                          <label for="{{ $field }}" class="input-group-text" style="cursor: pointer;">Upload {{ ucwords(str_replace('_', ' ', $field)) }}</label>
                          @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                        </div>
                      </div>
                      
                      
                    </div>
                    
                  @elseif ($field == 'category_id')
                    <div class="form-group mb-1 col-md-4">
                          <label for="{{ $field }}" class="form-label">Select Category</label>
                          <select class="form-select" name="{{$field}}" id="{{$field}}" aria-label="Select Category">
                            @if ($categories)
                              @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                              @endforeach
                            @endif
                          </select>
                          @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>

                  @elseif ($field == 'supplier_id')
                    <div class="form-group mb-1 col-md-4">
                        <label for="{{ $field }}" class="form-label">Select Supplier</label>
                        <select class="form-select" name="{{$field}}" id="{{$field}}" aria-label="Select Category">
                            @if ($suppliers)
                              @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{blank($supplier->company) ? $supplier->contact_name : $supplier->company }}</option>
                              @endforeach
                            @endif
                        </select>
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>

                  {{-- @elseif ($field == 'description')
                    <div class="row g-2">
                      <div class="form-group mb-1 col-md-4">
                          <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                          <textarea name="{{ $field }}" id="{{ $field }}" cols="30" rows="3" class="form-control  @error($field) is-invalid @enderror">
                            {{ old($field) }}
                          </textarea>
                          @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                      </div>
                    </div> --}}
                    
                  @elseif ($field == 'expiry')
                    <div class="form-group mb-1 col-md-4">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <input type="date" name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" class="form-control  @error($field) is-invalid @enderror">
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>

                  @elseif ($field == 'unit_price')
                    <div class="row g-2">
                      <div class="form-group mb-1 col-md-3">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }} (Actual Price to be Shown)</label>
                        <input type="number" min="1" name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" class="form-control  @error($field) is-invalid @enderror">
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                    </div>

                  @elseif ($field == 'quantity')
                    <div class="form-group mb-1 col-md-3">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <input type="number" min="1" name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" class="form-control  @error($field) is-invalid @enderror">
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                  @elseif ($field == 'unit_cost')
                    <div class="form-group mb-1 col-md-3">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <input type="number" min="1" name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" class="form-control  @error($field) is-invalid @enderror">
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                  @elseif ($field == 'total_cost')
                    <div class="form-group mb-1 col-md-3">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <input type="number" min="1" readonly name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" class="form-control  @error($field) is-invalid @enderror">
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>

                  @else 
                    <div class="form-group mb-1 col-md-4">
                        <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" class="form-control  @error($field) is-invalid @enderror">
                        @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                    </div>
                  @endif

              @endforeach
            </div>
              
            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a class="btn btn-outline-danger" href="{{route('products.index')}}">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {
          var input = document.getElementById('image');
          var imgPreview = document.getElementById('img-preview');
          imgPreview.onclick = function() {
            input.click();
          };
          input.addEventListener('change', function showFile() {
            var reader = new FileReader();
            reader.onload = function() {
              var dataURL = reader.result;
              var output = document.getElementById('img-preview');
              output.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
          });

          //focus #name element
          let qty = document.getElementById('quantity');
          let unit_cost = document.getElementById('unit_cost');
          let total_cost = document.getElementById('total_cost'); 
          unit_cost.onchange = () => total_cost.value = qty.value * unit_cost.value;
          qty.onchange = () => total_cost.value = qty.value * unit_cost.value;

          var el = document.getElementById('image');
              el.focus();
              el.select();

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
              title: "{{Session::get('success')}}",
            })
          @endif

        });
      </script>
    @endpush
@endsection