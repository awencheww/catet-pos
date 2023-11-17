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
          {{ Breadcrumbs::render('suppliers.edit', $supplier) }}
        </div>

        <h2>Edit Supplier</h2>
        <div class="row g-3">

          <form action="{{route('suppliers.update', $supplier)}}" method="POST" class="row g-3">
            @csrf
            @method('PUT')
            {{-- Render form fields based on the detected fields --}}
            <div class="row g-3">
              @foreach ($fields as $field)

                @if ($field !== 'phone_number')
                  <div class="form-group mb-1 col-md-4">
                      <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                      <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field, $supplier) }}" class="form-control  @error($field) is-invalid @enderror">
                      @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                  </div>
                @else
                  <div class="form-group mb-1 col-md-4">
                      <label for="{{ $field }}" class="mb-1">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                      <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field, $supplier) }}" maxlength="11" class="form-control  @error($field) is-invalid @enderror">
                      @error($field) <span class="invalid-feedback">{{$message}}</span> @enderror
                  </div>
                @endif

              @endforeach
            </div>
              
            <div class="col-12">
              <button type="submit" class="btn btn-success">Save</button>
              <a class="btn btn-outline-danger" href="{{route('suppliers.index')}}">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </main>

    @push('dashboard-scripts')
      <script>
        document.addEventListener('readystatechange', function() {
          //focus #name element
          var n = document.getElementById('name');
          n.focus();
          n.select();
          
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