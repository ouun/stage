
<header class="main-header header-wrap top-0 w-full banner border-accent {{ $mobile['position'] }} lg:{{ $desktop['position'] }} {{ $desktop['fullwidth'] }} {{ $desktop['padding-x'] }} {{ $desktop['padding-y'] }}">
  @include( 'partials.header.' . $desktop['layout'] )
  @include( 'partials.header.' . $mobile['layout'] )
  @include( 'partials.header.search.' . $search['layout'] )
</header>

{!! get_custom_header_markup() !!}
