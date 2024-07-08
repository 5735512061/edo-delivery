@extends("/frontend/layouts/template/template-index")
<style>
	@media (max-width: 1199.98px) {
		.ftco-animate-width {
			width: 70% !important;
			text-align:justify !important;
			margin-left: 60px !important;
		}
    }
</style>
@section("content")
@php
	$stores = DB::table('stores')->get();
@endphp
<body style="background-image: url('./images/bg.png'); background-size: cover; background-repeat: no-repeat;">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center mb-3 pb-3">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<h3 class="mb-4" style="color: #fff;">"เลือกร้านอาหาร ฟินไปกับอาหารมื้อพิเศษ สไตล์เอโดะ"</h3>
				</div>
			</div>   		
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-2"></div>
				@foreach ($stores as $store => $value)
					<div class="col-md-4 ftco-animate ftco-animate-width">
						<div class="product" style="border-radius: 0 !important;">
							@if($value->status == "เปิด")
								<a href="{{url('/edo-store')}}/{{$value->id}}" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_store_logo')}}/{{$value->logo}}"></a>
							@else 
								<a href="" data-toggle="modal" data-target="#ModalStore{{$value->id}}" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_store_logo')}}/{{$value->logo}}"></a>
							@endif
							<div class="text py-3 pb-4 px-3 text-center">
								@if($value->status == "เปิด")
									<h3><a href="{{url('/edo-store')}}/{{$value->id}}">{{$value->name}}</a></h3><br>
									<a href="{{url('/edo-store')}}/{{$value->id}}" class="btn btn-primary">LOOK STORE</a>
								@else 
									<h3><a href="" data-toggle="modal" data-target="#ModalStore{{$value->id}}">{{$value->name}}</a></h3><br>
									<a href="" data-toggle="modal" data-target="#ModalStore{{$value->id}}" class="btn btn-primary">LOOK STORE</a>
								@endif
							</div>
						</div>
					</div>
					<div class="modal fade" id="ModalStore{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<h2 style="text-align: center;">-- ยังไม่เปิดให้บริการ --</h2>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-family: 'Noto Sans Thai';">ปิด</button>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				<div class="col-md-2"></div>
			</div>
		</div>
	</section>
</body>
@endsection