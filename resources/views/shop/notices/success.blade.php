{{--
Show messages
@version     3.9.0
--}}

@if(!$notices)
  @return
@endif

<div class="shop-notice shop-success py-1">
  <ul class="px-4 py-2 bg-green-200 border-green-500 border-t-2 text-green-500 text-base font-medium">
    @foreach($notices as $notice)
      <li class="relative w-full" {!! wc_get_notice_data_attr( $notice ) !!} role="alert">
        {!! wc_kses_notice( $notice['notice'] ) !!}
      </li>
    @endforeach
  </ul>
</div>
