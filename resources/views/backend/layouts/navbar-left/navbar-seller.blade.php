@php
    $store_id = DB::table('sellers')->where('id',Auth::guard('seller')->user()->id)->value('store_id');
@endphp
<div class="sidebar sidebar-style-2">			
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<div class="user">
				<div class="avatar-sm float-left mr-2">
					<img src="{{ asset('/backend/img/profile.jpg')}}" alt="..." class="avatar-img rounded-circle">
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
						<span>
							{{Auth::guard('seller')->user()->name}}
							<span class="user-level">SELLER</span>
						</span>
					</a>
				</div>
			</div>
			<ul class="nav nav-primary">
				<li class="nav-item">
					<a href="{{url('/seller/order')}}">
						<i class="fas fa-shopping-cart"></i>
						@php
                            $order = DB::table('orders')
                                       ->leftJoin('order_confirms', 'orders.bill_number', '=', 'order_confirms.bill_number')
                                       ->whereNull('status')->where('store_id',$store_id)->groupBy('orders.bill_number')->get();
							$order_count = count($order);	
                        @endphp
						<p>ข้อมูลการสั่งซื้อ</p><p class="badge badge-success" style="color:#fff;">{{$order_count}}</p>
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
								<a href="{{url('/seller/list-menu')}}">
									<span class="sub-item">รายการเมนูอาหาร</span>
								</a>
							</li>
							<li>
								<a href="{{url('/seller/list-menu-price')}}">
									<span class="sub-item">จัดการราคา</span>
								</a>
							</li>
							<li>
								<a href="{{url('/seller/list-menu-price-promotion')}}">
									<span class="sub-item">จัดการราคาโปรโมชั่น</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item">
					<a href="{{url('/seller/message')}}">
						<i class="fas fa-bullhorn"></i>
						@php
							$message = DB::table('contacts')->where('answer_message', NULL)->where('store_id',$store_id)->count();
						@endphp
						<p>การติดต่อสอบถาม</p><p class="badge badge-success" style="color:#fff;">{{$message}}</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- End Sidebar -->