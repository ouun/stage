@if(!$messages)
  @return
@endif

<div class="shop-notice py-1" role="alert">
  <ul class="px-4 py-2 bg-blue-200 border-blue-500 text-blue-500 border-t-2 text-base font-medium">
    @foreach($messages as $message)
      <li class="relative w-full">
        {!! $message !!}
      </li>
    @endforeach
  </ul>
</div>
