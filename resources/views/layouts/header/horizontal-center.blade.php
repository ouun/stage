<div class="header-wrap {{ $desktop['layout'] }}">
  <div class="container-inner bg-inherit">
    <!-- Primary Navigation -->
    <nav class="justify-start flex-grow hidden w-full pt-0 nav-wrap nav-primary bg-inherit click-open-menu lg:flex lg:items-center lg:w-auto">
      @include( 'layouts.header.navigation.horizontal' )
    </nav>

    <div class="flex items-center flex-grow my-3 mr-6 text-black logo-wrap">
      @include('layouts.header.partials.logo')
    </div>

    <div class="icons-wrap bg-inherit lg:flex hover-open-menu">
      @include('layouts.header.partials.icons')
    </div>
  </div>
</div>
