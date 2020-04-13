<div class="{{ $classes }}">
  <div class="{{ $inner_classes }}">
    @if( ( $has_thumbnail || $display_placeholder ) && $display_thumbnail )
        <a class="no-underline block" href="{{ $permalink }}" title="{{ $title }}">
          {!! $thumbnail !!}
        </a>
    @endif

    @if( $display_headline || $display_meta || $display_excerpt || $display_tags )
      <div class="meta-container @if( $has_thumbnail ) px-6 py-6 @endif">
        @if( $display_headline )
          <a class="no-underline" href="{{ $permalink }}" title="{{ $title }}">
            <h2 class="my-4 entry-title break-words">
              {!! $title !!}
            </h2>
          </a>
        @endif

        @if( $display_meta )
          <div class="my-4">
            @include('partials.single.meta')
          </div>
        @endif

        @if( $display_excerpt )
          <p class="my-4">
            {!! $excerpt !!}
          </p>
        @endif

        @if( $display_tags )
          <div class="my-3">
            {!! $tags !!}
          </div>
        @endif
      </div>
    @endif

  </div>
</div>
