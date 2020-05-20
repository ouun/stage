@include('layouts.header')

<div id="app" class="flex flex-col lg:flex-row flex-1 justify-between @hasSection('sidebar') has-sidebar container alignscreen @endif" data-loader="container" data-loader-namespace="{{ $loaderNamespace }}">
  <main id="main" class="flex-1 h-auto min-h-0 overflow-hidden flex-grow-2 lg:flex-grow-3 xxl:flex-grow-5 main">
    @yield('content')
  </main>

  @hasSection('sidebar')
    <aside class="sticky top-0 self-start flex-shrink w-full sidebar flex-grow-1 xxl:flex-grow-2 lg:w-0 lg:pt-gutter">
      <div class="lg:border-l border-gray-300 lg:pl-block-spacing lg:ml-block-spacing">
        <div class="container {{ $align }}">
          <div class="-mx-4 widgets-wrap">
            @yield('sidebar')
          </div>
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
