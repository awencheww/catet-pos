@unless ($breadcrumbs->isEmpty())
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item">
                      @if (str_contains($breadcrumb->title, 'Dashboard') || str_contains($breadcrumb->title, 'Home'))
                        <i class="bi bi-house-fill"></i>
                      @endif
                      @if (str_contains($breadcrumb->title, 'Customer Profile'))
                        <i class="bi bi-person-circle"></i>
                      @endif
                      <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">
                      @if (str_contains($breadcrumb->title, 'Dashboard'))
                        <svg class="bi"><use xlink:href="#house-fill"></use></svg>
                      @endif
                      {{ $breadcrumb->title }}
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
