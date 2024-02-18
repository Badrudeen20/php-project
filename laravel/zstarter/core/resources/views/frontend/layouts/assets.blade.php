<!DOCTYPE html>
<html lang="en">

<head>
	 @yield('meta_data')
   @include('frontend.include.head')
   @laravelPWA
</head>

	<body>
            
            <div class="main-content pl-0 ">
                <!-- yeild contents here -->
                @yield('content')
            </div>
            <!-- initiate footer section-->
                <!-- Back to top -->
                <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
       
		
		<!-- initiate scripts-->
		@include('frontend.include.script')	
	</body>
</html>