<footer class="container py-8 bg-body text-copy">
  <div class="footer-inner alignwide">
    @if(is_active_sidebar( 'sidebar-footer' ))
      <div class="flex flex-wrap flex-grow widgets-wrap">
        @php dynamic_sidebar('sidebar-footer') @endphp
      </div>
    @endif

    <div class="flex flex-wrap items-center justify-between text-sm text-gray-500 menu-wrap">
      <p class="flex-grow copyright">
        {{ $copyright }}
      </p>

      @if (has_nav_menu('footer_navigation'))
        {!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'menu-footer flex items-center flex-wrap', 'depth' => 1]) !!}
      @endif
    </div>
  </div>
</footer>
