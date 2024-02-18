@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'About | '.getSetting('app_name');		
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

<!-- About Start -->
<section class="section bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="position-relative">
                    <img src="{{asset('frontend/assets/images/company/about.jpg')}}" class="rounded img-fluid mx-auto d-block my-4" alt="">
                    <!-- <div class="play-icon">
                        <a href="#!" data-type="youtube" data-id="yba7hPeTSjk" class="play-btn lightbox border-0">
                            <i class="mdi mdi-play text-primary rounded-circle shadow"></i>
                        </a>
                    </div> -->
                </div>
            </div><!--end col-->

            <div class="col-lg-7 col-md-7 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="section-title ms-lg-4">
                    <h4 class="title mb-4">Our Story</h4>
                    <p class="text-muted">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect. Dummy text is text that is used in the publishing industry or by web designers to occupy the space which will later be filled with 'real' content. This is required when, for example, the final text is not yet available. Dummy texts have been in use by typesetters since the 16th century.</p>
                    <a href="{{url('blogs')}}" class="btn btn-outline-primary mt-3">Read Case Study <i class="uil uil-angle-right-b"></i></a>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
<section>  
   

<!-- Team Start -->
    <section class="section" style="background-color: lavenderblush;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="section-title mb-4 pb-2">
                        <h4 class="title mb-4">Our Greatest Minds</h4>
                        <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <div class="row">
                @foreach ($sliders as $slider)
                    <div class="col-lg-3 col-md-6 col-6 mt-4 pt-2">
                        <div class="card team team-primary text-center bg-transparent border-0">
                            <div class="card-body p-0">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/backend/constant-management/sliders/'.$slider->image) }}" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                </div>
                                <div class="content pt-3 pb-3">
                                    <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">{{ $slider->title }}</a></h5>
                                    <small class="designation text-muted">{{ $slider->description }}</small>
                                </div>                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!--end row-->
        </div><!--end container-->
    </section>  

        {{-- How it work start --}}
        {{-- <div class="container"></div> --}}
        <section class="section bg-light border-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title">
                            <h4 class="title mb-4">How It Work ?</h4>
                            <p class="text-muted para-desc mx-auto">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div>
                </div>
            <!--end row-->

                    
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6 mt-4 pt-2">
                    <img src="{{ asset('frontend/assets/how-it-work.svg') }}" alt="">
                </div><!--end col-->

                <div class="col-lg-7 col-md-6 mt-4 pt-2">
                    <div class="section-title ms-lg-5">
                        <h4 class="title mb-4">Change the way you build websites</h4>
                        <p class="text-muted">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-1"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Digital Marketing Solutions for Tomorrow</li>
                            <li class="mb-1"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Our Talented &amp; Experienced Marketing Agency</li>
                            <li class="mb-1"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Create your own skin to match your brand</li>
                        </ul>
                        <a href="{{ route('contact')}}" class="mt-3 h6 text-primary">Find Out More <i class="uil uil-angle-right-b align-middle"></i></a>
                    </div>
                </div><!--end col-->
            </div>
        </div>
        </section>

        <div class="container mt-100 mt-60">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <div class="section-title">
                        <h4 class="title mb-4">See everything about your employee at one place.</h4>
                        <p class="text-muted para-desc mx-auto">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                    
                        <div class="mt-4">
                            <a href="{{ route('register')}}" class="btn btn-primary mt-2 me-2">Get Started Now</a>
                            <a href="{{ route('login')}}" class="btn btn-outline-primary mt-2">Free Trial</a>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Team End -->  
 

@endsection