<footer class="py-8 bg-body text-copy w-screen">
  <div class="container footer-inner {{ $desktop['align'] }}">
    @if( $has_widgets )
      <div class="widgets-wrap my-12">
        <div class="flex items-stretch justify-between flex-grow -mx-4">
          @php dynamic_sidebar( 'sidebar-footer' ) @endphp
        </div>
      </div>
    @endif

    <div class="flex flex-wrap items-center justify-between text-sm text-opacity-50 menu-wrap">
      @include( 'layouts.footer.copyright' )
      @include( 'layouts.footer.navigation' )
    </div>
  </div>
</footer>
