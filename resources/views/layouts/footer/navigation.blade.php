@if ($navigation)
  <ul class="flex flex-wrap items-center menu-footer">
    @foreach ($navigation as $item)
      <li class="menu-item pl-4 {{ $item->classes }} {{ 'depth-' . $loop->depth }} {{ $item->children ? 'has-children' : '' }} {{ $item->active ? 'active' : '' }}">
        <a href="{{ $item->url }}" title="{{ $item->label }}">
          {{ $item->label }}
        </a>
      </li>
    @endforeach
  </ul>
@endif
