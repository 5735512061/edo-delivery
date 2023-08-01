{{-- <div class="py-1 bg-dark">
	<div class="container-fluid">
		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
			<div class="col-lg-12 d-block">
				<div class="row d-flex">
					<div class="col-md pr-4 d-flex topper align-items-center">
						<div class="icon mr-2 d-flex justify-content-center align-items-center"></div>
						<span class="text"></span>
					</div>
					<div class="col-md-8 pr-4 topper align-items-center text-lg-right" style="color: #fff;">
						@if(Auth::guard('customer')->user() == NULL)
							<span class="icon-user" style="font-size:20px;"></span> <span class="text"><a style="color: #fff;" href="{{url('/register-customer')}}/{{$store_id}}">ลงทะเบียน</a>  / <a style="color: #fff;" href="{{url('customer/login')}}/{{$store_id}}">เข้าสู่ระบบ</a></span>
                		@endif
						@if(Auth::guard('customer')->user() != NULL)
							<a href="{{url('/customer/profile')}}/{{$store_id}}" style="color: #fff;">&nbsp;Hi! {{Auth::guard('customer')->user()->name}}</a><br>
							<span class="icon-user" style="font-size:20px;"></span><a href="{{url('/customer/profile')}}/{{$store_id}}" style="color: #fff;">&nbsp;บัญชีสมาชิก</a>
						@endif
						<a style="color: red;" href="{{url('/customer/shopping-cart')}}/{{$store_id}}"><span class="icon-shopping_cart" style="font-size:20px;"></span> Cart ({{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }})</a>
					</div> 
				</div>
			</div>
		</div>
	</div>
</div> --}}

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
		  	<span class="oi oi-menu"></span> Menu
		</button>
		<div class="col-md-2"></div>
		<div class="col-md-10">
			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav">
					<li class="nav-item" ><a href="{{url('/')}}" class="nav-link" style="color: red !important;">HOME</a></li>
					<li class="nav-item"><a href="{{url('/menu')}}" class="nav-link">MENU</a></li>
					<li class="nav-item"><a href="{{url('/special-menu')}}" class="nav-link">SPECIALMENU</a></li>
					<li class="nav-item"><a href="{{url('/gallery')}}" class="nav-link">GALLERY</a></li>
					<li class="nav-item"><a href="{{url('/blog')}}" class="nav-link">BLOG</a></li>
					<li class="nav-item"><a href="{{url('/review')}}" class="nav-link">REVIEW</a></li>
					<li class="nav-item"><a href="{{url('/contact-us')}}" class="nav-link">CONTACT US</a></li>
				</ul>
			</div>
		</div>
	</div>
</nav>