@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = $article->title.' | '.getSetting('app_name');		
		$meta_description = $article->short_description ?? getSetting('seo_meta_description');
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
      
        @php
            $author=App\User::whereId($article->user_id)->first();
        @endphp
        {{-- @dd($author) --}}
       
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
        <div class="container">
            <div class="row">
                <!-- BLog Start -->
                <div class="col-lg-8 col-md-6">
                    <div class="card blog blog-detail border-0 shadow rounded">
                        <img src="{{ getArticleImage($article->description_banner) }}" class="rounded-top blog-image" alt="">
                        <div class="card-body content">
                            <h6><i class="mdi mdi-tag text-primary me-1"></i><a href="javscript:void(0)" class="text-primary">{{ $article->title }}</a></h6>
                            <blockquote class="blockquote mt-3 p-3">
                                <p class="text-muted mb-0 fst-italic">{{ $article->short_description }}</p>
                            </blockquote>
                            <p class="text-muted">{{ $article->description }}</p>
                            <div class="post-meta mt-3">
                                {{-- <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BLog End -->

                <!-- START SIDEBAR -->
                <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <div class="card border-0 sidebar sticky-bar ms-lg-4"style="position:sticky;">
                        <div class="card-body p-0">
                            <!-- Author -->
                            <div class="text-center">
                                <span class="d-block py-2 rounded shadow text-center h6 mb-0">
                                    Author
                                </span>

                                <div class="mt-4">
                                    <img src="{{ $author->avatar ? $author->avatar : asset('frontend/assets/avatar.png')}}" class="img-fluid avatar avatar-medium rounded-pill shadow-md d-block mx-auto" alt="">
                                    
                                    <a href="javascript:void(0)" class="text-primary h5 mt-4 mb-0 d-block">{{ $author->name}}</a>
                                    <small class="text-muted d-block">{{ $author->email }}</small>
                                    <p class="text-muted">{{ $author->bio }}</p>
                                </div>
                            </div>
                            <!-- Author -->

                            <!-- RECENT POST -->
                            {{-- <div class="widget mt-4">
                                <span class="bg-light d-block py-2 rounded shadow text-center h6 mb-0">
                                    Recent Post
                                </span>

                                <div class="mt-4">
                                    @foreach($related_posts as $related_post)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ getArticleImage($related_post->description_banner) }}" class="avatar avatar-small rounded m-2" style="width: 75px; height:65px:" alt="">
                                        <div class="flex-1 ms-3">
                                            <a href="javascript:void(0)" class="d-block title text-dark">{{ $related_post->title}}</a>
                                            <span class="text-muted">{{ getFormattedDate($related_post->created_at) }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div> 
                            <!-- RECENT POST -->

                            <!-- TAG CLOUDS -->
                           <div class="widget mt-4">
                                <span class="bg-light d-block py-2 rounded shadow text-center h6 mb-0">
                                    Tagclouds
                                </span>
                                
                                <div class="tagcloud text-center mt-4">
                                    <a href="jvascript:void(0)" class="rounded">Business</a>
                                    <a href="jvascript:void(0)" class="rounded">Finance</a>
                                    <a href="jvascript:void(0)" class="rounded">Marketing</a>
                                    <a href="jvascript:void(0)" class="rounded">Fashion</a>
                                    <a href="jvascript:void(0)" class="rounded">Bride</a>
                                    <a href="jvascript:void(0)" class="rounded">Lifestyle</a>
                                    <a href="jvascript:void(0)" class="rounded">Travel</a>
                                    <a href="jvascript:void(0)" class="rounded">Beauty</a>
                                    <a href="jvascript:void(0)" class="rounded">Video</a>
                                    <a href="jvascript:void(0)" class="rounded">Audio</a>
                                </div>
                            </div> 
                            <!-- TAG CLOUDS -->
                            
                            <!-- SOCIAL -->
                             <div class="widget mt-4">
                               

                                <ul class="list-unstyled social-icon social text-center mb-0 mt-4">
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="github" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="youtube" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="gitlab" class="fea icon-sm fea-social"></i></a></li>
                                </ul><!--end icon-->
                            </div>  --}}
                            <!-- SOCIAL -->
                        </div>
                    </div>
                </div><!--end col-->


                <div class="col-12">
                    <div class="card shadow rounded border-0 mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Related Posts :</h5>
                            <div class="row">
                               @foreach($related_posts as $related_post)
                               <div class="col-lg-6 mt-4 pt-2 d-flex align-items-stretch">
                                    <div class="card blog blog-primary rounded border-0 shadow">
                                        <div class="position-relative">
                                            <img src="{{ getArticleImage($related_post->description_banner) }}" class="card-img-top rounded-top" alt="...">
                                        <div class="overlay rounded-top"></div>
                                        </div>
                                        <div class="card-body content">
                                            <h5><a href="javascript:void(0)" class="card-title title text-dark">{{$related_post->title }}</a></h5>
                                            <div class="post-meta d-flex justify-content-between mt-3">
                                                {{-- <ul class="list-unstyled mb-0">
                                                    <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                                    <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                                </ul> --}}
                                                <a href="{{ url('blogs') }}" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                            </div>
                                        </div>
                                        <div class="author">
                                            <small class="user d-block"><i class="uil uil-user"></i>{{fetchFirst('App\User',$related_post->user_id,'name','')}}</small>
                                            <small class="date"><i class="uil uil-calendar-alt"></i> {{ getFormattedDateTime($related_post->created_at) }}</small>
                                        </div>
                                    </div>
                                </div>
                               @endforeach
                                <!--end col-->
                            </div><!--end row-->
                        </div>
                    </div>
                </div>
                <!-- END SIDEBAR -->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Blog End -->
@endsection 