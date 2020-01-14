<footer class="container py-8 bg-body text-copy">
  <div class="footer-inner alignwide">
    @if( $has_widgets )
      <div class="flex items-stretch justify-between flex-grow -mx-4 widgets-wrap">
        @php dynamic_sidebar( 'sidebar-footer' ) @endphp
      </div>
    @endif

    <div class="flex flex-wrap items-center justify-between text-sm text-gray-500 menu-wrap">
      @include( 'layouts.footer.copyright' )
      @include( 'layouts.footer.navigation' )
    </div>
  </div>
</footer>
