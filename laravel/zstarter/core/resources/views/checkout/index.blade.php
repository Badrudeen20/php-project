@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Home | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'Defenzelite';		
		$meta_author_email = '' ?? 'support@defenzelite.com';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
	@endphp
@endsection

@section('content')
<style>
.card-product .img-wrap {
border-radius: 3px 3px 0 0;
overflow: hidden;
position: relative;
height: 220px;
text-align: center;
}
.card-product .img-wrap img {
max-height: 100%;
max-width: 100%;
object-fit: cover;
}
.card-product .info-wrap {
overflow: hidden;
padding: 15px;
border-top: 1px solid #eee;
}
.card-product .bottom-wrap {
padding: 15px;
border-top: 1px solid #eee;
}
.label-rating { margin-right:10px;
color: #333;
display: inline-block;
vertical-align: middle;
}
.card-product .price-old {
color: #999;
}
</style>  
<section class="bg-half-170 d-table w-100">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <figure class="card card-product">
                    <div class="img-wrap"><img src="//www.tutsmake.com/wp-content/uploads/2019/03/c05917807.png"></div>
                    <figcaption class="info-wrap">
                        <h4 class="title">Mouse</h4>
                        <p class="desc">Some small description goes here</p>
                        <div class="rating-wrap">
                        <div class="label-rating">132 reviews</div>
                        <div class="label-rating">154 orders </div>
                        </div>
                    <!-- rating-wrap.// -->
                    </figcaption>
                    <div class="bottom-wrap">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary float-right buy_now" data-amount="100" data-id="1">Order Now</a> 
                        <div class="price-wrap h5">
                        <span class="price-new">₹100</span> <del class="price-old">₹120</del>
                        </div>
                    <!-- price-wrap.// -->
                    </div>
                <!-- bottom-wrap.// -->
                </figure>
            </div>
            <!-- col // -->

        </div>
        <!-- row.// -->
    </div>
    <!--container.//-->
@endsection

@push('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var SITEURL = "{{url('/')}}";
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    $('body').on('click', '.buy_now', function(e){
        var totalAmount = $(this).attr("data-amount");
        var order_id =  $(this).attr("data-id");
        var options = {
            "key": "{{ getSetting('api_razor_key') }}",
            "amount": (totalAmount*100), // 2000 paise = INR 20
            "name": "{{ getSetting('app_name') }}",
            "description": "Razor Payment",
            "image": "{{ getBackendLogo(getSetting('app_logo')) }}",
            "handler": function (response){
                window.location.href = SITEURL +'/'+ 'paysuccess?payment_id='+response.razorpay_payment_id+'&order_id='+order_id+'&amount='+totalAmount;
            },
            "prefill": {
                "contact": '{{ getSetting("frontend_footer_phone") }}',
                "email":   '{{ getSetting("frontend_footer_email") }}',
            },
            "theme": {
                "color": "#528FF0"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    });
    /*document.getElementsClass('buy_plan1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
    }*/
</script>
@endpush