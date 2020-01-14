<div class="header-wrap {{ $desktop['layout'] }}">
  <div class="container-inner bg-inherit">
    <div class="icons-wrap bg-inherit lg:flex hover-open-menu mr-block-spacing">
      @include('layouts.header.partials.icons', ['classes' => 'flex-row-reverse'])
    </div>

    <!-- Primary Navigation -->
    <nav class="justify-start flex-grow hidden w-full pt-0 nav-wrap nav-primary bg-inherit click-open-menu lg:flex lg:items-center lg:w-auto">
      @include( 'layouts.header.navigation.horizontal' )
    </nav>

    <div class="flex items-center flex-shrink-0 my-3 text-black logo-wrap ml-block-spacing">
      @include('layouts.header.partials.logo' )
    </div>
  </div>
</div>
