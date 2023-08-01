<div class="main-header">
    <div class="logo-header" data-background-color="blue">
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
        
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="{{url('/admin/order/Little Edo 少し江戸')}}">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $order = DB::table('orders')
                                       ->leftJoin('order_confirms', 'orders.bill_number', '=', 'order_confirms.bill_number')
                                       ->whereNull('status')->groupBy('orders.bill_number')->get();
							$order_count = count($order);
                        @endphp
                        <span class="notification">{{$order_count}}</span>
                    </a>
                </li>
                {{-- <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Quick Actions</span>
                            <span class="subtitle op-8">Shortcuts</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-file-1"></i>
                                            <span class="text">Generated Report</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-database"></i>
                                            <span class="text">Create New Database</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-pen"></i>
                                            <span class="text">Create New Post</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-interface-1"></i>
                                            <span class="text">Create New Task</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-list"></i>
                                            <span class="text">Completed Tasks</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-file"></i>
                                            <span class="text">Create New Invoice</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ asset('/backend/img/profile.jpg')}}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg"><img src="{{ asset('/backend/img/profile.jpg')}}" alt="image profile" class="avatar-img rounded"></div>
                                    <div class="u-text">
                                        <h4>{{Auth::guard('admin')->user()->name}}</h4>
                                        <p class="text-muted">ADMIN</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.password.change') }}">เปลี่ยนรหัสผ่าน</a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item" href="#">My Profile</a> --}}
                                {{-- <div class="dropdown-divider"></div> --}}
                                @if(Auth::guard('admin')->user() != NULL)
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}" 
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">ออกจากระบบ</a>
                                    <form id="logout-form" action="{{ 'App\Admin' == Auth::getProvider()->getModel() ? route('admin.logout') : route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>