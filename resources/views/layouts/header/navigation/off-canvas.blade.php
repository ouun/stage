@if ($navigation)
  <ul class="menu fixed inset-0 w-full colors-inherit">
    @foreach ($navigation as $item)
      <li class="menu-item w-full colors-inherit {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }} {{ $item->classes }}">
        <a class="relative colors-inherit" href="{{ $item->url }}">
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
