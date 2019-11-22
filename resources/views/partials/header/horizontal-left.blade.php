<div class="header-wrap {{ $desktop['layout'] }}">
  <div class="container-inner bg-inherit">
    <div class="logo-wrap flex items-center flex-shrink-0 text-black mr-6 my-3">
      @include('partials.header.logo')
    </div>

    <!-- Primary Navigation -->
    <nav class="nav-wrap nav-primary bg-inherit click-open-menu pt-0 w-full hidden flex-grow justify-end lg:flex lg:items-center lg:w-auto">
      @include( 'partials.header.navigation.horizontal' )
    </nav>

    <div class="icons-wrap bg-inherit lg:flex hover-open-menu">
      @include('partials.header.icons')
    </div>
  </div>
</div>
