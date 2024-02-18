@extends('frontend.layouts.main')

@section('meta_data')
@php
		$meta_title =  ($page->page_meta_title) ? $page->page_meta_title : getSetting('app_name');		
		$meta_description = ($page->page_meta_description) ? $page->page_meta_description : '';		
		$meta_keywords = ($page->page_keywords) ? $page->page_keywords : getSetting('app_name');		
		$meta_motto = (false) ? $page->page_keywords : getSetting('app_name');		
	@endphp
@endsection

@section('content')

      <!-- Hero Start -->
      <section class="bg-half-170 d-table w-100">
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="pages-heading">
                        <h4 class="title mb-0"> {{ $page->title }} </h4>
                    </div>
                </div>  <!--end col-->
            </div><!--end row-->
            <div class="position-breadcrumb">
                <nav aria-label="breadcrumb" class="d-inline-block">
                    <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li> --}}
                    </ul>
                </nav>
            </div>
        </div> <!--end container-->
    </section><!--end section-->
    <!-- Hero End -->

    <!-- Shape Start -->
    <div class="position-relative">
        <div class="shape overflow-hidden text-color-white ">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
    <!--Shape End-->  
    
    <!-- Start Terms & Conditions -->
    <section class="section bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow border-0 rounded">
                        <img style="width: 100%; height: 300px; object-fit: cover;" src="{{asset('storage/backend/page/'.$page->page_meta_image)}}" alt="">
                        <div class="card-body">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End Terms & Conditions -->

    
@endsection