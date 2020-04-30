<div class="search-wrap {{ $classes ?? 'hover:border-black focus-within:border-primary transition-default duration-200 h-12 my-6' }}">
  {!! $before ?? '' !!}
  {!! get_search_form() !!}
  {!! $after ?? '' !!}
</div>
