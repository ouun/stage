@if ($item->children)
  <ul class="sub-menu is-hidden text-inherit border-inherit {{ $in_loop ?: 'bg-body' }}">

    <li class="go-back hidden overflow-hidden text-inherit border-inherit">
      <a href="#" class="relative flex prevent" >
        @svg('chevron-left', 'w-4 h-auto mr-2 flex-initial inline-block align-text-bottom')
        <span class="flex-1">
          {{ $item->label }}
        </span>
      </a>
    </li>

    @foreach ($item->children as $item)
      <li class="menu-item text-inherit border-inherit {{ 'depth-' . $loop->depth }} {{ $loop->depth > 1 && $item->children ? 'hide-children' : '' }} {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }}">
        <a href="{{ $item->url }}" title="{{ $item->label }}" class="flex {{ $item->children ? 'prevent' : '' }}">
          <span class="flex-1">
            {{ $item->label }}
          </span>

          @if($item->children)
            @svg('chevron-right', 'w-4 h-auto ml-4 inline-block flex-initial align-text-bottom')
          @endif
        </a>

        {{-- Self referencing for looping through the menu --}}
        @include( 'layouts.header.navigation.menu-item', [ 'in_loop' => true ]  )

      </li>
    @endforeach
  </ul>
@endif
