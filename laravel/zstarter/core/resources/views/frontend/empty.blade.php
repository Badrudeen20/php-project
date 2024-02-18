@if (isset($empty_msg))
    <div class="card">
        <div class="card-body text-center m-4">
            <img src="{{ $img_path ?? asset('frontend/customer/icons/no-content.png') }}" alt="Empty-Image"
             style="width: 15%;" class="img-fluid w-40">
            <p class="text-muted mt-3">{{ $empty_msg }}</p>
        </div>
    </div>
@endif