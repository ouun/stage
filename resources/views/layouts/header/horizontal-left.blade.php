<div class="header-wrap {{ $desktop['layout'] }}">
  <div class="container-inner bg-inherit">
    <div class="flex items-center flex-shrink-0 my-3 mr-6 text-black logo-wrap">
      @include('layouts.header.partials.logo')
    </div>

    <!-- Primary Navigation -->
    <nav class="justify-end flex-grow hidden w-full pt-0 nav-wrap nav-primary bg-inherit click-open-menu lg:flex lg:items-center lg:w-auto">
      @include( 'layouts.header.navigation.horizontal' )
    </nav>

    <div class="icons-wrap bg-inherit lg:flex hover-open-menu">
      @include('layouts.header.partials.icons')
    </div>
  </div>
</div>
