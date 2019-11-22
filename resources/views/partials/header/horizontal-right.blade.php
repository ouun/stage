<div class="header-wrap {{ $desktop['layout'] }}">
  <div class="container-inner bg-inherit">
    <div class="icons-wrap bg-inherit lg:flex hover-open-menu mr-block-spacing">
      @include('partials.header.icons', ['classes' => 'flex-row-reverse'])
    </div>

    <!-- Primary Navigation -->
    <nav class="nav-wrap nav-primary bg-inherit click-open-menu pt-0 w-full hidden flex-grow justify-start lg:flex lg:items-center lg:w-auto">
      @include( 'partials.header.navigation.horizontal' )
    </nav>

    <div class="logo-wrap flex items-center flex-shrink-0 text-black ml-block-spacing my-3">
      @include('partials.header.logo' )
    </div>
  </div>
</div>
