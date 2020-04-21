<div class="header-wrap colors-inherit {{ $desktop['layout'] }}">
  <div class="container-inner colors-inherit">
    <div class="flex items-center flex-shrink-0 my-3 mr-6 colors-inherit logo-wrap">
      @include('layouts.header.partials.logo')
    </div>

    <!-- Primary Navigation -->
    <nav class="justify-end flex-grow hidden w-full pt-0 nav-wrap nav-primary colors-inherit click-open-menu lg:flex lg:items-center lg:w-auto">
      @include( 'layouts.header.navigation.horizontal' )
    </nav>

    <div class="icons-wrap colors-inherit lg:flex hover-open-menu">
      @include('layouts.header.partials.icons')
    </div>
  </div>
</div>
