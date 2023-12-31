<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-primary-subtle" data-bs-theme="dark">
  <div class="offcanvas-md offcanvas-end bg-primary-subtle" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel"><img src="{{ asset('assets/icon/fav-icon.png') }}" alt="Catet's Sweets & Cakes" width="70" height="50">Catet's Sweets & Cakes</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
      <ul class="nav flex-column">
        <li class="nav-item">
          <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="bi"><use xlink:href="#house-fill"/></svg>
            Dashboard
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.index') || request()->is('suppliers/*')">
            <svg class="bi"><use xlink:href="#file-earmark"/></svg>
            Suppliers
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index') || request()->is('categories/*')">
            <svg class="bi"><use xlink:href="#file-earmark"/></svg>
            Categories
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index') || request()->is('products/*')">
            <svg class="bi"><use xlink:href="#cart"/></svg>
            Products
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link :href="route('/customers')" :active="request()->is('customers') || request()->is('customer/*')">
            <svg class="bi"><use xlink:href="#people"/></svg>
            Customers
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.index')">
            <i class="bi bi-wallet2"></i>
            Payments
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders') || request()->is('orders/*')">
            <svg class="bi"><use xlink:href="#file-earmark"/></svg>
            Orders
            @isset($orders_count)
              <span class="badge bg-danger">
                {{ $orders_count }}
              </span>
            @endisset
          </x-nav-link>
        </li>
        {{-- <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#graph-up"/></svg>
            Reports
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#puzzle"/></svg>
            Integrations
          </x-nav-link>
        </li> --}}
      </ul>

      {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
        <span>Saved reports</span>
        <a class="link-secondary" href="#" aria-label="Add a new report">
          <svg class="bi"><use xlink:href="#plus-circle"/></svg>
        </a>
      </h6>
      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
            Current month
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
            Last quarter
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
            Social engagement
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
            Year-end sale
          </x-nav-link>
        </li>
      </ul> --}}

      <hr class="my-3">

      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <x-nav-link :href="route('/users')" :active="request()->routeIs('/users') || request()->is('user/*')">
            <i class="bi bi-person-plus"></i>
            User
          </x-nav-link>
        </li>
        
        @if (Auth::user()->role === 'cashier')
          <li class="nav-item">
            <x-nav-link :href="route('cashier.profile')" :active="request()->routeIs('cashier.profile')">
              <i class="bi bi-person-circle"></i>
              Profile
            </x-nav-link>
          </li>
        @endif
        @if (Auth::user()->role === 'admin')
          <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
            <svg class="bi"><use xlink:href="#gear-wide-connected"/></svg>
            Settings
          </x-nav-link>
        @endif

        @auth
          <form action="{{route('logout')}}" method="POST">
            @csrf
            <li class="nav-item nav-link">
                @csrf
                <button class="nav-link d-flex align-items-center gap-2 p-0" type="submit">
                  <i class="bi bi-arrow-left-square"></i>
                  Logout
                </button>
              </li>
          </form>
        @endauth
      </ul>
    </div>
  </div>
</div>