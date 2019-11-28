@if ($item->children)
  <ul class="sub-menu is-hidden">

    <li class="go-back hidden overflow-hidden">
      <a href="#" class="relative block prevent" >
        <span>{{ $item->label }}</span>
      </a>
    </li>

    @foreach ($item->children as $item)
      <li class="menu-item w-full {{ 'depth-' . $loop->depth }} {{ $loop->depth > 2 && $item->children ? 'hide-children' : '' }} {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }}">
        <a href="{{ $item->url }}" title="{{ $item->label }}" class="block {{ $item->children ? 'prevent' : '' }}">
          {{ $item->label }}
        </a>

        {{-- Self referencing for looping through the menu --}}
        @include( 'partials.header.navigation.menu-item' )

      </li>
    @endforeach
  </ul>
@endif
