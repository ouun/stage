<div class="flex items-center my-6">
  <img class="w-10 h-10 ml-0 mr-2 rounded-full" src="{{ esc_url( get_avatar_url( get_post() ) ) }}" alt="{{ __('Avatar by ', 'stage') }} {{ get_the_author() }}">
  <div class="ml-0 text-sm">
    <p class="leading-none text-gray-900 byline author vcard">
      {{ __('By', 'stage') }} <a href="{{ get_author_posts_url( get_the_author_meta('ID') ) }}" rel="author" class="fn">
        {{ get_the_author() }}
      </a>
    </p>
    <time class="block text-xs italic text-gray-500 updated" datetime="{{ get_post_time('c', true) }}">{{
    sprintf(
			/* translators: %s: Human-readable time difference. */
			__( '%s ago', 'gutenberg' ),
			human_time_diff( get_the_time( 'U' ) ) )
			}}</time>
  </div>
</div>
