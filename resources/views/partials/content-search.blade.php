@if(get_post_type() === 'product')
  @include('shop.content-product')
@else
  @include('partials.content')
@endif
