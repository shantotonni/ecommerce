<style>
    .layout-navbar-fixed.layout-fixed .wrapper .sidebar {
        margin-top: 0 !important;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #033261!important;">
    <!-- Brand Logo -->
{{--    <a href="{{ url('/')}}" class="brand-link">--}}
{{--        <img src="{{asset('public/img/logo.png')}}" alt="ACI eBazar Logo" class="brand-image elevation-3" style="opacity: .8">--}}
{{--    </a>--}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
            @if(\Illuminate\Support\Facades\Auth::user()->UserName == "premio")
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image" style="padding-left: 0">
                        <img src="{{asset('public/logo/premio.png')}}" alt="User Image" style="background: white;padding: 10px;height: 80px;width: 233px">
                    </div>
                </div>
            @else
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('public//img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->Name}}</a>
                </div>
            </div>
            @endif


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('/')}}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        Dashboard </a>
                </li>
                @php
                $userMenus = \App\Http\Controllers\CommonHelper::getUserMenu();
                @endphp

                @foreach($userMenus as $menuGroup => $userMenu)
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-adn"></i>
                            <p>
                                {{$menuGroup}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach($userMenu as $menu)
                            <li class="nav-item">
                                <a href="{{url($menu['menu']['Link'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{$menu['menu']['SubMenuName']}}</p>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

                @if(Auth::user()->project[0]->ProjectID == 3)
                <li class="nav-item">
                    <a href="{{ route('review.product') }}" class="nav-link">Product Review </a>
                </li>
                @endif

{{--                <li class="nav-item has-treeview">--}}
{{--                    <a href="#" class="nav-link">--}}
{{--                        <i class="nav-icon fab fa-product-hunt"></i>--}}
{{--                        <p>--}}
{{--                            Order--}}
{{--                            <i class="fas fa-angle-left right"></i>--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                    <ul class="nav nav-treeview">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('order.index') }}" class="nav-link">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Order List</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('order.report') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Customer
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                        @if(Auth::user()->project[0]->ProjectID == 6 || Auth::user()->project[0]->ProjectID == 3)
                            <li class="nav-item">
                                <a href="{{ route('guest.customer.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Guest Customer List</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                @if(Auth::user()->project[0]->ProjectID == 3 || Auth::user()->project[0]->ProjectID == 4 || Auth::user()->project[0]->ProjectID == 5)
                <li class="nav-item">
                    <a href="{{ route('coupon.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-gift" aria-hidden="true"></i> Coupon </a>
                </li>
                @endif

                @if(Auth::user()->project[0]->ProjectID == 3 || Auth::user()->project[0]->ProjectID == 6)
                    <li class="nav-item">
                        <a href="{{ route('discount.create') }}" class="nav-link">
                            <i class="nav-icon fas fa-percentage"></i>
                            Discount Create</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('delivery.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        Delivery Charge</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings.searches') }}" class="nav-link">
                        <i class="nav-icon fas fa-search"></i>
                        Searching Result</a>
                </li>

{{--                <li>--}}
{{--                    <a href="{{ route('admin.settings') }}" class="nav-link">Settings</a>--}}
{{--                    <a class="app-menu__item {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}" href="{{ route('admin.settings') }}">--}}
{{--                        <span class="app-menu__label">Settings</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <a href="{{ route('change.password') }}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        Change Password </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/logout')}}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        Logout </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
