  <!-- Navbar Start -->
  <header id="topnav" class="defaultscroll sticky bg-white py-10" style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
    <div class="container">
        <!-- Logo container-->
        <a class="logo" href="{{ url('/') }}">
            <span class="logo-light-mode">
                <img src="{{ getBackendLogo(getSetting('app_logo'))}}" class="l-dark" height="48" alt="" >
                <img src="{{ getBackendLogo(getSetting('app_logo'))}}" class="l-light" height="48" alt="">
            </span>
            <img src="{{ getBackendLogo(getSetting('app_logo'))}}" height="48" class="logo-dark-mode" alt="">
        </a>

        <!-- End Logo container-->
        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <!--Login button Start-->
        <ul class="buy-button list-inline mb-0 navigation-menu login_wrapper">
            <li class="has-submenu parent-parent-menu-item mb-0">
                @auth
                    @if (AuthRole() == 'Admin')
                        <a href="{{route('panel.dashboard')}}"  class="pl-0">
                             <img src="{{ getAuthProfileImage(auth()->user()->avatar ) }}" alt="" class="author-img" style="height: 38px; width: 38px;border-radius: 50%;object-fit: cover;">
                        </a>
                    @else
                        <a href="{{route('customer.profile')}}"  class="pl-0">
                             <img src="{{ getAuthProfileImage(auth()->user()->avatar ) }}" alt="" class="author-img" style="height: 38px; width: 38px;border-radius: 50%;object-fit: cover;">
                        </a>
                    @endif
                @else
                    <div style="margin-top: 20px;">
                        <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                    </div>
                @endauth
            </li>
        </ul>
        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->   
            <ul class="navigation-menu nav-light">
                <li><a href="{{ url('/') }}" class="sub-menu-item">Home</a></li>
                <li><a href="{{ url('/about') }}" class="sub-menu-item">About</a></li>
                <li><a href="{{ url('/blogs') }}" class="sub-menu-item">Blog</a></li>
                <li><a href="{{ url('/contact') }}" class="sub-menu-item">Contact</a></li>
                <li><a href="{{ url('/login') }}" class="btn btn-primary login-desktop">Login</a></li>
                
            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->