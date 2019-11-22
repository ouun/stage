@if ($navigation)
  <ul class="menu fixed inset-0 w-full bg-body">
    @foreach ($navigation as $item)
      <li class="menu-item w-full {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }} {{ $item->classes }}">
        <a class="relative" href="{{ $item->url }}">
          {{ $item->label }}
        </a>
        @include( 'partials.header.navigation.menu-item' )
      </li>
    @endforeach
  </ul>
@endif
