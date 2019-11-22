<div class="post w-full lg:w-1/2 lg:max-w-full">
  <div class="mx-4 mb-4 lg:flex">
    @if(has_post_thumbnail())
      <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url({{ get_the_post_thumbnail_url() }})" title="{!! $title !!}">
      </div>
    @endif
    <div class="border-r border-b border-l border-accent @if(has_post_thumbnail()) lg:border-l-0 @endif lg:border-t lg:border-accent bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
      <div class="mb-8">
        <a class="no-underline" href="{{ get_permalink() }}" title="{!! $title !!}">
          <h2 class="entry-title text-2xl mb-4">
            {!! $title !!}
          </h2>
        </a>
        <p class="text-gray-700 text-base">
          @php the_excerpt() @endphp
        </p>
      </div>
      @include('partials/entry-meta')
    </div>
  </div>
</div>
