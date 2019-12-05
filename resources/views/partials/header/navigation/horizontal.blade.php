@if ($navigation)
  <ul class="menu w-auto">
    @foreach ($navigation as $item)
      <li class="menu-item click-open {{ $item->classes }}  {{ 'depth-' . $loop->depth }} {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }}">
        <a class="relative" href="{{ $item->url }}">
          {{ $item->label }}
        </a>
        @include( 'partials.header.navigation.menu-item' )
      </li>
    @endforeach
  </ul>
@endif
