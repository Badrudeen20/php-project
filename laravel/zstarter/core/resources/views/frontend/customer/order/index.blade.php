@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Orders | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'Defenzelite';		
		$meta_author_email = '' ?? 'support@defenzelite.com';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
		$customer = 1;		
	@endphp
@endsection

@section('content')
    

    <!-- Profile Start -->
    <section class="section mt-60">
        <div class="container mt-lg-3">
            <div class="row">
                @include('frontend.customer.include.sidebar')
                <div class="col-lg-8 col-12">
                   <div class="row">
                    <div class="col-12">
                        <div class="component-wrapper rounded shadow bg-white">
                            <div class="p-3 border-bottom">
                                <h5 class="title mb-0"> Orders </h5>
                            </div>


                            @forelse ($orders as $order)
                                <div class="border-bottom  p-3">
                                    <a href="{{ route('customer.order.invoice',$order->id) }}">
                                        <div class="d-flex ms-2">
                                            <i class="uil uil-envelope h5 align-middle me-2 mb-0"></i>
                                            <div class="ms-3">
                                               <div class="d-flex justify-content-between">
                                                   <div>
                                                       <h6 class="text-dark mb-0">{{ getOrderHashCode($order->id) }}</h6>
                                                   </div>
                                                   <div style="position: absolute;right: 45px;">
                                                       <span class="text-{{ orderStatus($order->id)['color'] }}">{{ orderStatus($order->id)['name'] }}</span>
                                                   </div>   
                                               </div>
                                                <small class="text-muted d-block">Created At {{ getFormattedDate(now()) }} </small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @empty
                                @include('frontend.customer.include.empty_records',['title' => 'No Records','width'=>15])
                            @endforelse
                        </div>
                    </div>
                   </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Profile End -->
    
@endsection



@push('script')
  
@endpush