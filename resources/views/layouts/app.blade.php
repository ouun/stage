@include('layouts.header')

<div id="app" class="flex flex-col flex-1" data-loader="container" data-loader-namespace="{{ $loaderNamespace }}">
  <main id="main" class="main flex-1 flex-auto h-auto min-h-0 overflow-hidden @hasSection('sidebar') flex-wrap lg:flex-no-wrap content-wrap @endif">
    @yield('content')
  </main>

  @hasSection('sidebar')
    <aside class="flex-grow-0 w-full mt-12 sidebar widgets-wrap sm:w-1/4 md:w-1/5 lg:border-l border-accent lg:pl-block-spacing lg:ml-block-spacing">
      @yield('sidebar')
    </aside>
  @endif

  @include('layouts.footer')
</div>

@include('layouts.footer.overlay')

@if( $features->gallery )
  @include('layouts.footer.gallery')
@endif
