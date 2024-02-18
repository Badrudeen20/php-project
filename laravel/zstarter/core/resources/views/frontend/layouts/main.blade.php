<!DOCTYPE html>
<html lang="en">

<head>
	@yield('meta_data')
   @include('frontend.include.head')
   @laravelPWA
</head>

	<body style="background: aliceblue !important">
		<div>
			<!-- initiate header-->
			@if (isset($customer))
				@include('frontend.customer.include.header')
			@else
				@include('frontend.include.header')
			@endif
				<div class="main-content pl-0 ">
					@yield('content')
				</div>
				 <!-- Back to top -->
				<a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
				@if (!isset($customer))
					@include('frontend.include.footer')
				@else
					@include('frontend.include.footer_bar')
				@endif
		</div>
		
		<!-- initiate scripts-->
		@include('frontend.include.script')	
		@stack('script')
	</body>
</html>