@php
if(!isset($width)){
  $width = 60;
}
if(!isset($image)){
  $image = 'frontend/customer/icons/no-content.png';
}
@endphp

<div class="text-center mx-auto py-3 pt-4 m-5">
  <img src="{{ asset($image) }}" alt="" style="width:{{ $width }}%">
  <p class="mt-3">{{ $title }}</p>
</div>
