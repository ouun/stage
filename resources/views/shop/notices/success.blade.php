@if(!$messages)
  @return
@endif

<div class="shop-notice shop-success py-1" role="alert">
  <ul class="px-4 py-2 bg-green-200 border-green-500 border-t-2 text-green-500 text-base font-medium">
    @notices($messages, '<li class="relative w-full">', '</li>')
  </ul>
</div>
