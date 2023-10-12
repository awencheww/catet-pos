@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link d-flex align-items-center gap-2 active'
            : 'nav-link d-flex align-items-center gap-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</a>