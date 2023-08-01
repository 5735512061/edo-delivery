@extends("/frontend/layouts/template/template")

@section("content")
@php
    $store_id = $store_id;
@endphp
<section class="ftco-section ftco-cart" style="margin-top: -70px;">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">ประวัติการสั่งซื้อสินค้า</h2>
            </div>
        </div>   		
    </div>
    @if(count($orders) != 0)
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>บิลเลขที่</th>
                                <th>วันที่ทำรายการ</th>
                                <th>ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order => $value)
                                <tr class="text-center">
                                    @php 
                                        $qty = DB::table('product_carts')->where('bill_number',$value->bill_number)->sum('qty');
                                        $totalPrice = DB::table('product_carts')->where('bill_number',$value->bill_number)
                                                                                ->sum(DB::raw('price * qty'));
                                        // coupon
                                        $amount_type = DB::table('coupons')->where('id',$value->coupon_id)->value('amount_type');
                                        $amount = DB::table('coupons')->where('id',$value->coupon_id)->value('amount');
                                        $coupon_name = DB::table('coupons')->where('id',$value->coupon_id)->value('coupon_name');

                                        // ที่อยู่ คำนวณค่าจัดส่ง
                                        $district = DB::table('shipments')->where('id',$value->shipment_id)->value('district');
                                    @endphp
                                    <td><a href="{{url('/customer/order-history-detail/')}}/{{$value->id}}/{{$store_id}}" style="color: blue;">{{$value->bill_number}}</a></td>
                                    <td>{{$value->date}}</td>
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
                                        // $total = number_format($total);
                                    @endphp
                                    @php
                                        $shipping = DB::table('shipping_costs')->where('store_id',$store_id)->where('place',$district)->get();
                                        $shipping_count = count($shipping); // นับจำนวนข้อมูลที่ตรงกัน
                                        $min_cost = DB::table('shipping_costs')->where('store_id',$store_id)->where('place',$district)->value('min_cost');
                                        $price = DB::table('shipping_costs')->where('store_id',$store_id)->where('place',$district)->value('price');

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
                                    <td>{{$total_delivery}}.- <br>
                                        @if($coupon_name != null)
                                            ({{$coupon_name}})
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else 
    <center><h1>ไม่มีประวัติการสั่งซื้อสินค้า!</h1></center>
    <center><h3>-- เลือกซื้อสินค้า --</h3></center><br>
    @php
        $menu_types = DB::table('menu_types')->where('store_id',$store_id)->where('status',"เปิด")->get();
    @endphp

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                @foreach ($menu_types as $menu_type => $value)
                <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">
                    <div class="col-md-3">
                        <div class="product">
                            <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_menu_type')}}/{{$value->image}}"></a>
                            <div class="text py-3 px-3 text-center"><hr>
                                <h3><a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">{{$value->menu_type}}</a></h3>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</section>
@endsection