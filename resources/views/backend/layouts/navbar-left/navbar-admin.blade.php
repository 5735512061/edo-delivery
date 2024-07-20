<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('/backend/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::guard('admin')->user()->name }}
                            <span class="user-level">ADMIN</span>
                            {{-- <span class="caret"></span> --}}
                        </span>
                    </a>
                    {{-- <div class="clearfix"></div>
					<div class="collapse in" id="collapseExample">
						<ul class="nav">
							<li>
								<a href="#profile">
									<span class="link-collapse">My Profile</span>
								</a>
							</li>
							<li>
								<a href="#edit">
									<span class="link-collapse">Edit Profile</span>
								</a>
							</li>
							<li>
								<a href="#settings">
									<span class="link-collapse">Settings</span>
								</a>
							</li>
						</ul>
					</div> --}}
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a data-toggle="collapse" href="#account">
                        <i class="fas fa-layer-group"></i>
                        <p>ตัวจัดการบัญชี</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="account">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('/admin/data-customer') }}">
                                    <span class="sub-item">บัญชีของลูกค้า</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/data-seller') }}">
                                    <span class="sub-item">บัญชีของพนักงานขาย</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/order/Little Edo 少し江戸-สาขาภูเก็ต') }}">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $order = DB::table('orders')
                                ->leftJoin('order_confirms', 'orders.bill_number', '=', 'order_confirms.bill_number')
                                ->whereNull('status')
                                ->groupBy('orders.bill_number')
                                ->get();
                            $order_count = count($order);
                        @endphp
                        <p>ข้อมูลการสั่งซื้อ</p>
                        <p class="badge badge-success" style="color:#fff;">{{ $order_count }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#menu">
                        <i class="fas fa-th-list"></i>
                        <p>ตัวจัดการเมนู</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="menu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('/admin/manage-menu-type') }}">
                                    <span class="sub-item">จัดการประเภทของเมนู</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/create-menu') }}">
                                    <span class="sub-item">เพิ่มเมนูอาหาร</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/list-menu/Little Edo 少し江戸-สาขาภูเก็ต') }}">
                                    <span class="sub-item">รายการเมนูอาหาร</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/list-menu-price/Little Edo 少し江戸-สาขาภูเก็ต') }}">
                                    <span class="sub-item">จัดการราคา</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/list-menu-price-promotion/Little Edo 少し江戸-สาขาภูเก็ต') }}">
                                    <span class="sub-item">จัดการราคาโปรโมชั่น</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/create-special-menu') }}">
                                    <span class="sub-item">จัดการเมนูพิเศษ</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#store">
                        <i class="fas fa-home"></i>
                        <p>ตัวจัดการร้านค้า</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="store">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('/admin/create-store') }}">
                                    <span class="sub-item">สร้างรายชื่อร้านค้า</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/data-store') }}">
                                    <span class="sub-item">ข้อมูลร้านค้า</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#website">
                        <i class="fas fa-laptop"></i>
                        <p>ตัวจัดการเว็บไซต์</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="website">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('/admin/manage-image-slide') }}">
                                    <span class="sub-item">จัดการรูปภาพสไลด์</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/manage-logo-website') }}">
                                    <span class="sub-item">จัดการโลโก้เว็บไซต์</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/manage-image-gallery') }}">
                                    <span class="sub-item">จัดการรูปภาพแกลอรี่</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/manage-blog') }}">
                                    <span class="sub-item">จัดการ Blog</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/create-coupon') }}">
                        <i class="fas fa-barcode"></i>
                        <p>คูปองส่วนลด</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#voucher">
                        <i class="fas fa-credit-card"></i>
                        <p>คูปองเงินสด</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="voucher">
                        <ul class="nav nav-collapse">
                            <li>    
                                <a href="{{ url('/admin/create-voucher') }}">
                                    <span class="sub-item">สร้างคูปองเงินสด</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/message/Little Edo 少し江戸-สาขาภูเก็ต') }}">
                        <i class="fas fa-bullhorn"></i>
                        @php
                            $message = DB::table('contacts')->where('answer_message', null)->count();
                        @endphp
                        <p>การติดต่อสอบถาม</p>
                        <p class="badge badge-success" style="color:#fff;">{{ $message }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#applywork">
                        <i class="fas fa-file"></i>
                        <p>ข้อมูลการรับสมัครงาน</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="applywork">
                        <ul class="nav nav-collapse">
                            <li>
                                @php
                                    $branch = DB::table('url_apply_works')->orderBy('id', 'asc')->value('url_name');
                                @endphp
                                <a href="{{ url('/admin/apply-work') }}/{{ $branch }}">
                                    <span class="sub-item">ข้อมูลผู้สมัคร</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/url-apply-work') }}">
                                    <span class="sub-item">ลิ้งค์การรับสมัครงาน</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#audit">
                        <i class="fas fa-file"></i>
                        <p>Audit Checklist</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="audit">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('/admin/form-checklist-audit') }}">
                                    <span class="sub-item">รายการตรวจเช็ค</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
