<div class="header-wrap bg-inherit text-inherit border-inherit {{ $desktop['layout'] }}">
  <div class="container-inner text-inherit border-inherit">
    <div class="flex items-center flex-shrink-0 my-4 mr-6 bg-inherit text-inherit border-inherit logo-wrap">
      @include('layouts.header.partials.logo')
    </div>

    <!-- Primary Navigation -->
    <nav class="justify-end flex-grow hidden w-full pt-0 nav-wrap nav-primary text-inherit border-inherit click-open-menu lg:flex lg:items-center lg:w-auto">
      @include( 'layouts.header.navigation.horizontal' )
    </nav>

    <div class="icons-wrap text-inherit border-inherit lg:flex hover-open-menu">
      @include('layouts.header.partials.icons')
    </div>
  </div>
</div>
