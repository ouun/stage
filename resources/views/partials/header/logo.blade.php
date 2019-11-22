@if( has_custom_logo() )
  {!! $logo !!}
@else
  <span class="text-2xl leading-none z-1">
    <a class="site_brand--name" href="{!! $home_url!!}" title="{!! $site_name !!}">{!! $site_name !!}</a>
    @if( $show_tagline )
      <span class="site_brand--tagline block text-sm mt-1">{!! $site_tagline !!}</span>
    @endif
  </span>
@endif
