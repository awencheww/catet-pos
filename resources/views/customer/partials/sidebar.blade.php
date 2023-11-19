<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-primary-subtle" data-bs-theme="dark">
  <div class="offcanvas-md offcanvas-end bg-primary-subtle" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel"><img src="{{ asset('assets/icon/fav-icon.png') }}" alt="Catet's Sweets & Cakes" width="70" height="50">Catet's Sweets & Cakes</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
      <ul class="nav flex-column">
        <li class="nav-item">
          <x-nav-link :href="route('customer.profile', Auth::user()->id)" :active="request()->routeIs('customer.profile')">
            <i class="bi bi-person-circle"></i>
            Profile
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#file-earmark"/></svg>
            Orders
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#cart"/></svg>
            Your Tray
          </x-nav-link>
        </li>
        <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#puzzle"/></svg>
            Integrations
          </x-nav-link>
        </li>
      </ul>

      <ul class="nav flex-column mb-auto">
        {{-- <li class="nav-item">
          <x-nav-link>
            <svg class="bi"><use xlink:href="#gear-wide-connected"/></svg>
            Settings
          </x-nav-link>
        </li> --}}
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