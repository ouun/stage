@if(!$messages)
  @return
@endif

<div class="shop-notice shop-error py-1" role="alert">
  <ul class="px-4 py-2 bg-red-200 border-red-500 border-t-2 text-red-500 text-base font-medium">
    @foreach($messages as $message)
      <li class="relative w-full">
        {!! $message !!}
      </li>
    @endforeach
  </ul>
</div>
