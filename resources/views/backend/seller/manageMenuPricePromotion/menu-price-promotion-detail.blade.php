@extends("/backend/layouts/template/template-seller")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">รายการราคาอาหารโปรโมชั่น</h2>
			</div>
		</div>
	</div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>วันที่อัพเดตราคา</th>
                                    <th>ราคาอาหารโปรโมชั่นล่าสุด</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prices as $price => $value)
                                    @php
                                        $promotion_price_format = number_format($value->promotion_price);
                                    @endphp
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $price+1}}</td>
                                        <td>{{ date('Y-m-d', strtotime($value->created_at)) }}</td>
                                        @if($value->promotion_price == null)
                                            <td style="color: red;">0</td>
                                        @else 
                                            <td>{{$promotion_price_format}}.-</td>
                                        @endif
                                        <td>{{$value->status}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{$prices->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection