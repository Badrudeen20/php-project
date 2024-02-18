<div class="col-lg-4 col-md-6 col-12 toggle-area mb-3">
    <div class="sidebar sticky-bar p-4 rounded shadow bg-white">
        <div class="widget">
            <h5 class="widget-title">Hello {{ auth()->user()->name }}</h5>
        </div>
        
        <div class="widget mt-4">
            <ul class="list-unstyled sidebar-nav mb-0" id="navmenu-nav">
                <li class="navbar-item account-menu px-0">
                    <a href="{{ route('customer.profile') }}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-dashboard"></i></span>
                        <h6 class="mb-0 ms-2">Dashboard</h6>
                    </a>
                </li>
                @if(getSetting('wallet_activation') == 1)
                <li class="navbar-item account-menu px-0 mt-2">
                    <a href="{{ route('customer.wallet') }}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-wallet"></i></span>
                        <h6 class="mb-0 ms-2">Wallet</h6>
                    </a>
                </li>
                @endif
                @if(getSetting('payout_activation') == 1)
                <li class="navbar-item account-menu px-0 mt-2">
                    <a href="{{ route('customer.payout.request.index') }}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-transaction"></i></span>
                        <h6 class="mb-0 ms-2">Payouts</h6>
                    </a>
                </li>
                @endif
                @if(getSetting('order_activation') == 1)
                <li class="navbar-item account-menu px-0 mt-2">
                    <a href="{{ route('customer.order.index') }}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-shopping-cart-alt"></i></span>
                        <h6 class="mb-0 ms-2">Orders</h6>
                    </a>
                </li>
                @endif
                
                {{-- <li class="navbar-item account-menu px-0 mt-2">
                    <a href="{{ route('customer.address') }}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-location-point"></i></span>
                        <h6 class="mb-0 ms-2">Addresses</h6>
                    </a>
                </li> --}}
                
               
                
                {{-- <li class="navbar-item account-menu px-0 mt-2">
                    <a href="{{ route('customer.setting') }}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-setting"></i></span>
                        <h6 class="mb-0 ms-2">Settings</h6>
                    </a>
                </li> --}}
                
                <li class="navbar-item account-menu px-0 mt-2">
                    <a href="{{url('logout')}}" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                        <span class="h4 mb-0"><i class="uil uil-sign-out-alt"></i></span>
                        <h6 class="mb-0 ms-2">Logout</h6>
                    </a>
                </li>
            </ul>
        </div>

        <div class="widget">
            <p class="text-muted style">© <script>document.write(new Date().getFullYear())</script> {{getSetting('app_name')}}</p>  
        </div>
    </div>
</div><!--end col-->