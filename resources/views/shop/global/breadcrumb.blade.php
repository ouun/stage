{{--
Breadcrump navigations
@version     2.3.0
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

@if(!empty($breadcrumb))
    <nav class="breadcrumbs content-wrap relative pt-5 pb-5 text-xs {{ $align }}" aria-label="breadcrumb">
      <ol class="breadcrumb inline-flex">
        @foreach ($breadcrumb as $key => $crumb)
              @if(! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1)
                  <li class="breadcrumb-item flex-initial mr-0 text-gray-500">
                      <a class="text-gray-500 hover:text-primary" href="{{ esc_url( $crumb[1] ) }}">{!! esc_html( $crumb[0] ) !!}</a>
                      <span>
                        @svg('chevron-right', 'text-gray-500 align-text-top inline-block', ['width' => '0.9em', 'height' => '0.9em'])
                      </span>
                  </li>
              @else
                  <li class="breadcrumb-item text-primary mr-0 active" aria-current="page">
                    {!! esc_html( $crumb[0] ) !!}
                  </li>
              @endif
        @endforeach
      </ol>
    </nav>
@endif
