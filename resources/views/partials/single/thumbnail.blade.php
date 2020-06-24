@if( has_post_thumbnail() )
  <div class="container overflow-hidden h-half-screen">
    {!! get_the_post_thumbnail( get_the_ID(), 'full', [ 'class' => 'alignscreen w-full h-full object-cover object-center' ]) !!}
  </div>
@endif
