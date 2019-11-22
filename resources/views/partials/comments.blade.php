@php
if (post_password_required()) {
  return;
}
@endphp

<section id="comments" class="comments my-12 py-6">
  @if (have_comments())
    <h2 class="text-2xl">
      {!! sprintf(
      /* translators: %1$s is replaced with the number of comments. */
      _nx('One response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'stage'), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>'
      ) !!}
    </h2>

    <ol class="commentlist">
      {!! wp_list_comments(['style' => 'ol', 'short_ping' => true]) !!}
    </ol>

    @if ( get_comment_pages_count() > 1 && get_option('page_comments') )
      <nav>
        <ul class="pager">
          @if (get_previous_comments_link())
            <li class="previous">@php previous_comments_link(__('&larr; Older comments', 'stage')) @endphp</li>
          @endif
          @if (get_next_comments_link())
            <li class="next">@php next_comments_link(__('Newer comments &rarr;', 'stage')) @endphp</li>
          @endif
        </ul>
      </nav>
    @endif
  @endif

  @if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments'))
    <div class="alert alert-warning">
      {{ __('Comments are closed.', 'stage') }}
    </div>
  @endif

  @php comment_form() @endphp
</section>
