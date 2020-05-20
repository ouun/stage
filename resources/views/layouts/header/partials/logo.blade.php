@if( has_custom_logo() )
  {!! $logo !!}
@else
  <span class="text-lg leading-none lg:text-xl z-1">
    <a class="site_brand--name" href="{!! $home_url!!}" title="{!! $site_name !!}">{!! $site_name !!}</a>
    @if( $show_tagline )
      <span class="site_brand--tagline block mt-1 text-sm text-copy">{!! $site_tagline !!}</span>
    @endif
  </span>
@endif
