@if(!$messages)
  @return
@endif

<div class="shop-notice shop-success py-1" role="alert">
  <ul class="px-4 py-2 bg-green-200 border-green-500 border-t-2 text-green-500 text-base font-medium">
    @foreach($messages as $message)
      <li class="relative w-full">
        {!! $message !!}
      </li>
    @endforeach
  </ul>
</div>
