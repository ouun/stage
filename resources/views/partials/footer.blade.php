<footer class="footer-wrap bg-body text-copy py-8">
  <div class="footer-inner">
    @if(is_active_sidebar( 'sidebar-footer' ))
      <div class="widgets-wrap flex flex-wrap flex-grow">
        @php dynamic_sidebar('sidebar-footer') @endphp
      </div>
    @endif

    <div class="menu-wrap flex flex-wrap justify-between items-center text-gray-500 text-sm">
      <p class="copyright flex-grow">
        {{ $copyright }}
      </p>

      @if (has_nav_menu('footer_navigation'))
        {!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'menu-footer flex items-center flex-wrap', 'depth' => 1]) !!}
      @endif
    </div>
  </div>
</footer>

<div>
  <div class="flex hidden">
    <div class="flex-1 h-16" style="background-color: var(--color-primary)"></div>
    <div class="flex-1 h-16" style="background-color: var(--color-secondary)"></div>
    <div class="flex-1 h-16" style="background-color: var(--color-link)"></div>
    <div class="flex-1 h-16" style="background-color: var(--color-hover)"></div>
  </div>
  @foreach(['gray', 'red', 'orange', 'yellow', 'green', 'teal', 'blue', 'indigo', 'purple', 'pink'] as $color)
    <div class="flex hidden">
      @for ($i = 1; $i < 10; $i++)
        <div class="flex-1 h-16" style="background-color: var({{ '--color-' }}{{ $color }}-{{ $i }}00)"></div>
      @endfor
    </div>
  @endforeach
</div>
