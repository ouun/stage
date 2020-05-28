<form role="search" method="get" class="relative flex items-stretch w-full h-full p-0 m-0 overflow-hidden border search-form max-h-12 border-inherit text-copy" action="{{ home_url('/') }}">
  <label for="search" class="screen-reader-text">{{ __('Search for:', 'stage') }}</label>
  <input id="search" type="search" class="w-full py-0 pl-6 pr-3 m-0 leading-none placeholder-opacity-50 bg-transparent border-0 appearance-none search-field h-inherit focus:outline-none placeholder-copy" placeholder="{!! __('Search &hellip;', 'stage') !!}" value="{!! get_search_query() !!}" name="s">
  <button type="submit" class="flex-shrink-0 h-auto p-0 pr-6 m-0 leading-none bg-transparent border-0 appearance-none focus:outline-none" value="{{ __('Search', 'stage') }}">
    @svg('search')
  </button>
</form>
