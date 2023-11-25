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
            <h5>By Categories</h5>
            @foreach ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->category_name }}" id="{{ $category->id }}" {{ in_array($category->category_name, (array)request('categories')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $category->id }}">
                        {{ $category->category_name }}
                    </label>
                </div>
            @endforeach
          </div>
        
          <div class="form-floating mb-2">
            <select name="filter_by" class="form-select" id="floatingSelectGrid">
              <option value="price_low" {{ request('filter_by') === 'price_low' ? 'selected' : '' }}>Price, Low to High</option>
              <option value="price_high" {{ request('filter_by') === 'price_high' ? 'selected' : '' }}>Price, High to Low</option>
              <option value="name_asc" {{ request('filter_by') === 'name_asc' ? 'selected' : '' }}>Name, A-Z</option>
              <option value="name_desc" {{ request('filter_by') === 'name_desc' ? 'selected' : '' }}>Name, Z-A</option>
              <option value="created_asc" {{ request('filter_by') === 'created_asc' ? 'selected' : '' }}>Date, Old to New</option>
              <option value="created_desc" {{ request('filter_by') === 'created_desc' ? 'selected' : '' }}>Date, New to Old</option>
            </select>
            <label for="floatingSelectGrid">Filter By</label>
          </div>
      
          <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Submit</button>

      </form>
    </div>
  </div>
  
</div>