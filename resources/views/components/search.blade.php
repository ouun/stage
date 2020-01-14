<div class="search-wrap {{ $classes ?? 'border hover:border-black focus-within:border-primary transition-default duration-200 h-12 py-2 my-6' }}">
  {!! $before ?? '' !!}
  {!! get_search_form() !!}
  {!! $after ?? '' !!}
</div>
