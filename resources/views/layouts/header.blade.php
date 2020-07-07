
<header class="{{ $classes ?? '' }} {{ $mobile['position'] }} lg:{{ $desktop['position'] }} {{ $desktop['fullwidth'] }} {{ $desktop['padding-x'] }}">
  <div class="{{ $desktop['align'] }} text-inherit border-inherit">
    @include( 'layouts.header.' . $desktop['layout'] )
    @include( 'layouts.header.' . $mobile['layout'] )
    @include( 'layouts.header.search.' . $search['layout'] )
  </div>
</header>

{!! get_custom_header_markup() !!}
