<form role="search" method="get" class="search-form relative flex items-stretch overflow-hidden p-0 m-0 h-full max-h-10 w-full border border-inherit" action="{{ home_url('/') }}">
  <label for="search" class="screen-reader-text">{{ __('Search for:', 'stage') }}</label>
  <input id="search" type="search" class="search-field appearance-none py-0 pl-6 pr-3 m-0 h-inherit w-full border-0 leading-none bg-transparent focus:outline-none" placeholder="{!! __('Search &hellip;', 'stage') !!}" value="{!! get_search_query() !!}" name="s">
  <button type="submit" class="appearance-none flex-shrink-0 p-0 pr-6 m-0 h-auto border-0 leading-none bg-transparent focus:outline-none" value="{{ __('Search', 'stage') }}">
    @svg('search')
  </button>
</form>
