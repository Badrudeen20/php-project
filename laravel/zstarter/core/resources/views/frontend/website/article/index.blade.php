@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Blogs'.' | '.getSetting('app_name');		
		$meta_description = '-'?? getSetting('seo_meta_description');
		$meta_keywords = '-'.'' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'Defenzelite';		
		$meta_author_email = '' ?? 'support@defenzelite.com';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
	@endphp
@endsection

@section('content')
    
    
    <!-- Shape Start -->
    <div class="position-relative">
        <div class="shape overflow-hidden text-color-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
    <!--Shape End-->
    
    <!-- Blog STart -->
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                
                @forelse ($articles as $article)
                    <div class="col-lg-4 col-md-6 mb-4 pb-2 d-flex align-items-stretch">
                        <div class="card blog blog-primary rounded border-0 shadow overflow-hidden w-100">
                            <div class="position-relative">
                                <img src="{{ getArticleImage($article->description_banner) }}" class="card-img-top" alt="Article Image" style="height: 235px;">
                                <div class="overlay rounded-top"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="{{ route('article.show',$article->slug) }}" class="card-title title text-dark">{{ $article->title }}</a></h5>
                                <div class="post-meta mt-3">
                                    {!! Str::limit($article->description,70) !!}
                                </div>
                            </div>
                            <div class="author">
                                <small class="user d-block"><i class="uil uil-user me-1"></i>Admin</small>
                                <small class="date"><i class="uil uil-calendar-alt me-1"></i>{{ getFormattedDate($article->created_at) }}</small>
                            </div>
                        </div>
                    </div><!--end col-->
                @empty
                    @php
                        $empty_msg = 'No Articles yet!';
                    @endphp
                    <div class="col-lg-8 mx-auto text-cemter">
                        @include('frontend.empty')
                    </div>
                @endforelse
                <!-- PAGINATION START -->
               <div class="text-center mt-3">
                {{ $articles->links() }}
               </div>
                <!-- PAGINATION END -->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Blog End -->
@endsection