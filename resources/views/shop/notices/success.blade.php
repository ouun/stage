{{--
Show messages
@version     3.9.0
--}}

@if(!$notices)
  @return
@endif

<div class="shop-notice shop-success py-1 w-full container {{ $align }}">
  <ul class="px-4 py-2 bg-green-light border-green border-l-2 text-green text-base font-medium">
    @foreach($notices as $notice)
      <li class="relative w-full bg-inherit text-inherit border-inherit flex items-center py-1" {!! wc_get_notice_data_attr( $notice ) !!}>
        @svg('info', 'w-4 h-auto')
        {!! wc_kses_notice( $notice['notice'] ) !!}
      </li>
    @endforeach
  </ul>
</div>
