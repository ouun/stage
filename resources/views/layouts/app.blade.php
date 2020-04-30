@include('layouts.header')

<div id="app" class="flex flex-col lg:flex-row flex-1 justify-between @hasSection('sidebar') has-sidebar container alignscreen @endif" data-loader="container" data-loader-namespace="{{ $loaderNamespace }}">
  <main id="main" class="main flex-1 flex-auto h-auto min-h-0 overflow-hidden">
    @yield('content')
  </main>

  @hasSection('sidebar')
    <aside class="sidebar w-full md:w-1/4 lg:w-1/5 self-start flex-shrink sticky top-gutter lg:border-l border-accent lg:px-block-spacing lg:mx-block-spacing">
      <div class="container">
        <div class="widgets-wrap -mx-4">
          @yield('sidebar')
        </div>
      </div>
    </aside>
  @endif
</div>

@include('layouts.footer')

@include('layouts.footer.overlay')

@if( $features->gallery )
  @include('layouts.footer.gallery')
@endif
