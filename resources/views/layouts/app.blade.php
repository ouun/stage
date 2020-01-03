<!doctype html>
<html {!! get_language_attributes() !!} class="h-full overflow-x-hidden overflow-y-scroll">
  @include('partials.head')
  <body @php body_class() @endphp data-loader="wrapper">
    @php wp_body_open() @endphp
    @php do_action('get_header') @endphp
    @include('partials.header')

    <div id="app" class="flex" data-loader="container" data-loader-namespace="page">
      <main id="main" class="main flex-1 flex-auto h-auto min-h-0 overflow-hidden @hasSection('sidebar') flex-wrap lg:flex-no-wrap content-wrap @endif">
        @yield('content')
      </main>

      @hasSection('sidebar')
        <aside class="flex-grow-0 w-full mt-12 sidebar widgets-wrap sm:w-1/4 md:w-1/5 lg:border-l border-accent lg:pl-block-spacing lg:ml-block-spacing">
          @yield('sidebar')
        </aside>
      @endif

      @include('partials.footer')
    </div>

    @include('partials.footer.overlay')

    @if( $features->gallery )
      @include('partials.footer.psw-container')
    @endif

    @php do_action('get_footer') @endphp
    @php wp_footer() @endphp
  </body>
</html>
