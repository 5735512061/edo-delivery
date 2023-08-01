@extends("/backend/layouts/template/template-seller")

@section("content")
@php
    $stores = DB::table('stores')->get();
@endphp
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">ข้อมูลการสั่งซื้อ</h2>
			</div>
		</div>
	</div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{url('/seller/search-order')}}" enctype="multipart/form-data" method="post">@csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="navbar-left navbar-form nav-search mr-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-search pr-1">
                                                <i class="fa fa-search search-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text" placeholder="ค้นหาหมายเลขสมาชิก" class="form-control" name="customer_code">
                                    </div>
                                </div><br>
                            </div>
                            <div class="col-md-3">
                                <div class="navbar-left navbar-form nav-search mr-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-search pr-1">
                                                <i class="fa fa-search search-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text" placeholder="ค้นหาหมายเลขบิล" class="form-control" name="bill_number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                    <th>หมายเลขสมาชิก</th>
                                    <th>บิลเลขที่</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>จำนวน</th>
                                    <th>ราคารวมส่วนลด</th>
                                    <th>สถานะการจัดส่ง</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order => $value)
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $order+1}}</td>
                                        @php
                                            $qty = DB::table('product_carts')->where('bill_number',$value->bill_number)->sum('qty');
                                            $totalPrice = DB::table('product_carts')->where('bill_number',$value->bill_number)
                                                                                    ->sum(DB::raw('price * qty'));
                                            // $totalPrice = number_format($totalPrice);
                                            $customer_code = DB::table('customers')->where('id',$value->customer_id)->orderBy('id','desc')->value('customer_code');

                                            // coupon
                                            $amount_type = DB::table('coupons')->where('id',$value->coupon_id)->value('amount_type');
                                            $amount = DB::table('coupons')->where('id',$value->coupon_id)->value('amount');
                                            $coupon_name = DB::table('coupons')->where('id',$value->coupon_id)->value('coupon_name');

                                            // ที่อยู่ คำนวณค่าจัดส่ง
                                            $district = DB::table('shipments')->where('id',$value->shipment_id)->value('district');
                                        @endphp
                                        <td>{{$customer_code}}</td>
                                        <td><a href="{{url('/seller/order-detail/')}}/{{$value->id}}" style="color: blue;">{{$value->bill_number}}</a></td>
                                        <td>{{$value->date}}</td>
                                        <td>{{$qty}} รายการ</td>
                                        @php
                                            if($amount_type == 'ค่าคงที่') {
                                                $discount = $amount;
                                                $total = $totalPrice - $discount;
                                            } elseif($amount_type == 'เปอร์เซ็นต์') {
                                                $discount = $totalPrice * ($amount/100);
                                                $total = $totalPrice - $discount; 
                                            } elseif($amount_type == NULL) {
                                                $discount = 0;
                                                $total = $totalPrice;
                                            } else {
                                                $total = $totalPrice;
                                            }
                                        @endphp

                                        @php
                                            $shipping = DB::table('shipping_costs')->where('store_id',$value->store_id)->where('place',$district)->get();
                                            $shipping_count = count($shipping); // นับจำนวนข้อมูลที่ตรงกัน
                                            $min_cost = DB::table('shipping_costs')->where('store_id',$value->store_id)->where('place',$district)->value('min_cost');
                                            $price = DB::table('shipping_costs')->where('store_id',$value->store_id)->where('place',$district)->value('price');

                                            if($shipping_count == 0) { // ในกรณีที่ไม่มีที่อยู่ในฐานข้อมูลที่กำหนด ให้เข้าเงื่อนไขนี้
                                                $price_delivery = 100;
                                            } else { // ในกรณีที่มีที่อยู่ตามฐานข้อมูลที่กำหนด ให้เข้าเงื่อนไขนี้
                                                if($total < $min_cost) {
                                                    $price_delivery = $price; 
                                                } else {
                                                    $price_delivery = 0;
                                                }
                                            }   
                                            $total_delivery = number_format($total + $price_delivery);
                                        @endphp

                                        <td>{{$total_delivery}} บาท
                                            @if($coupon_name != null)
                                                ({{$coupon_name}})
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $status = DB::table('order_confirms')->where('bill_number',$value->bill_number)->orderBy('id','desc')->value('status');
                                            @endphp
                                            @if($status == null || $status == 'รอยืนยัน')
                                                <div style="color: red; font-size:15px;">รอยืนยัน</div>
                                            @elseif($status == 'กำลังจัดส่ง')
                                                <div style="color:blue; font-size:15px;">กำลังจัดส่ง</div>
                                            @else
                                                <div style="color:green; font-size:15px;">จัดส่งแล้ว</div>
                                            @endif
                                        </td>
                                        <td>       
                                            <a href="{{url('/seller/order-detail/')}}/{{$value->id}}" style="color: blue;">
                                                ตรวจสอบการสั่งซื้อ
                                            </a>
                                        </td>
                                        <td>
                                            @if($status == null || $status == 'รอยืนยัน')
                                                <a href="{{url('/seller/delete-order/')}}/{{$value->id}}" style="color: red;" onclick="return confirm('ต้องการยกเลิกคำสั่งซื้อ ?')">
                                                    ยกเลิกการสั่งซื้อ
                                                </a>
                                            @elseif($status == 'กำลังจัดส่ง')
                                                <div style="color:red; font-size:15px;">ไม่สามารถยกเลิกคำสั่งซื้อได้</div>
                                            @else
                                                <div style="color:red; font-size:15px;">ไม่สามารถยกเลิกคำสั่งซื้อได้</div>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{$orders->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection