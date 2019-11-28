<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class('app') @endphp data-loader="wrapper">
    @php wp_body_open() @endphp
    @php do_action('get_header') @endphp
    @include('partials.header')

    <div id="app" class="flex" data-loader="container" data-loader-namespace="page">
      <main id="main" class="main flex-1 @hasSection('sidebar') flex-wrap lg:flex-no-wrap content-wrap @endif">
        @yield('content')
      </main>

      @hasSection('sidebar')
        <aside class="sidebar widgets-wrap flex-grow-0 w-full sm:w-1/4 md:w-1/5 lg:border-l border-accent lg:pl-block-spacing lg:ml-block-spacing mt-12">
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
