@if ($navigation)
  <ul class="fixed inset-0 w-full menu text-inherit border-inherit">
    @foreach ($navigation as $item)
      <li class="menu-item w-full text-inherit border-inherit {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }} {{ $item->classes }}">
        <a class="relative text-inherit border-inherit" href="{{ $item->url }}">
          {{ $item->label }}

          @if($item->children)
            @svg('chevron-right', 'float-right w-5 h-auto inline-block align-middle')
          @endif
        </a>
        @include( 'layouts.header.navigation.menu-item' )
      </li>
    @endforeach
  </ul>
@endif
