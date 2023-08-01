@extends("/backend/layouts/template/template-admin-login")

@section("content")
<h1 style="font-family: Mitr !important;">รายละเอียดคำสั่งซื้อ</h1>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="demo">
                        <div class="row">
                            <div class="col-md-4">
                                @php
                                    $customer_code = DB::table('customers')->where('id',$details['order']->customer_id)->value('customer_code');
                                    $name = DB::table('customers')->where('id',$details['order']->customer_id)->value('name');
                                    $surname = DB::table('customers')->where('id',$details['order']->customer_id)->value('surname');
                                    $phone = DB::table('customers')->where('id',$details['order']->customer_id)->value('phone');
                                @endphp
                                <p style="font-size: 18px; font-family: Mitr !important;">หมายเลขสมาชิก : {{$customer_code}}</p>
                                <p style="font-size: 18px; font-family: Mitr !important;">ชื่อลูกค้า : {{$name}} {{$surname}} เบอร์โทรศัพท์ : {{$phone}}</p>
                            </div>
                            <div class="col-md-4">
                                <h2 style="font-family: Mitr !important;">ที่อยู่สำหรับจัดส่ง</h2>
                                @php
                                    $name = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('name');
                                    $phone = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('phone');
                                    $address = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('address');
                                    $district = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('district');
                                    $amphoe = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('amphoe');
                                    $province = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('province');
                                    $zipcode = DB::table('shipments')->where('customer_id',$details['order']->customer_id)->where('bill_number',$details['order']->bill_number)->value('zipcode');
                                @endphp
                                <p style="font-size: 16px; font-family: Mitr !important;">{{$name}} {{$phone}}</p>
                                <p style="font-size: 16px; font-family: Mitr !important;">ที่อยู่ {{$address}} ตำบล{{$district}} อำเภอ{{$amphoe}} จังหวัด{{$province}} {{$zipcode}}</p>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div><hr>
<h1 style="font-family: Mitr !important;">รายการอาหาร</h1>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            @php
                                $NUM_PAGE = 10;
                                $product_ids = DB::table('product_carts')->where('bill_number',$details['bill_number'])->paginate($NUM_PAGE);
                                $page = \Request::input('page');
                                $page = ($page != null)?$page:1;
                                $total = 0;
                            @endphp
                            <tbody>
                                @foreach ($product_ids as $product_id => $value)
                                    <tr>
                                        @php
                                            $product_code = DB::table('food_menus')->where('id',$value->product_id)->value('code');
                                            $product_name = DB::table('food_menus')->where('id',$value->product_id)->value('thai_name');
                                            $qty = DB::table('product_carts')->where('id',$value->id)->value('qty');
                                            $price = DB::table('product_carts')->where('id',$value->id)->value('price');
                                            $comment = DB::table('product_carts')->where('id',$value->id)->value('comment');
                                            $totalPrice = $qty * $price;
                                            $totalPriceFormat = number_format($qty * $price);
                                            $total += ($qty * $price);
                                            $total_format = number_format($total);

                                            // coupon
                                            $coupon_id = DB::table('orders')->where('bill_number',$value->bill_number)->value('coupon_id');

                                            $amount_type = DB::table('coupons')->where('id',$coupon_id)->value('amount_type');
                                            $amount = DB::table('coupons')->where('id',$coupon_id)->value('amount');
                                            $coupon_name = DB::table('coupons')->where('id',$coupon_id)->value('coupon_name');

                                            // ที่อยู่ คำนวณค่าจัดส่ง
                                            $shipment_id = DB::table('orders')->where('bill_number',$value->bill_number)->value('shipment_id');
                                            $district = DB::table('shipments')->where('id',$shipment_id)->value('district');
                                        @endphp

                                        <td style="font-family: Mitr !important;">{{$product_name}}</td>
                                        <td style="font-family: Mitr !important;">{{$qty}} รายการ</td>
                                        <td style="font-family: Mitr !important;">ราคารวม {{$totalPriceFormat}} บาท</td>
                                        <td style="font-family: Mitr !important;">{{$comment}}</td>
                                    </tr>
                                    @php
                                        if($amount_type == 'ค่าคงที่') {
                                            $discount = $amount;
                                            $total_discount = $total - $discount;
                                        } elseif($amount_type == 'เปอร์เซ็นต์') {
                                            $discount = $total * ($amount/100);
                                            $total_discount = $total - $discount; 
                                        } elseif($amount_type == NULL) {
                                            $discount = 0;
                                            $total_discount = $total;
                                        } else {
                                            $total_discount = $total;
                                        }
                                    @endphp

                                    @php
                                        $store_id = DB::table('orders')->where('bill_number',$value->bill_number)->value('store_id');
                                        $shipping = DB::table('shipping_costs')->where('store_id',$store_id)->where('place',$district)->get();
                                        $shipping_count = count($shipping); // นับจำนวนข้อมูลที่ตรงกัน
                                        $min_cost = DB::table('shipping_costs')->where('store_id',$store_id)->where('place',$district)->value('min_cost');
                                        $price = DB::table('shipping_costs')->where('store_id',$store_id)->where('place',$district)->value('price');

                                        if($shipping_count == 0) { // ในกรณีที่ไม่มีที่อยู่ในฐานข้อมูลที่กำหนด ให้เข้าเงื่อนไขนี้
                                            $price_delivery = 100;
                                        } else { // ในกรณีที่มีที่อยู่ตามฐานข้อมูลที่กำหนด ให้เข้าเงื่อนไขนี้
                                            if($total_discount < $min_cost) {
                                                $price_delivery = $price; 
                                            } else {
                                                $price_delivery = 0;
                                            }
                                        }   
                                        $total_delivery = number_format($total_discount + $price_delivery);
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h3 style="font-family: Mitr !important;">ส่วนลดคูปอง {{$discount}} บาท</h3>
<h3 style="font-family: Mitr !important;">ค่าจัดส่ง {{$price_delivery}} บาท</h3>
<h2 style="font-family: Mitr !important;">ราคารวมทั้งหมด {{$total_delivery}} บาท</h2>
@php
    $id = DB::table('orders')->where('bill_number',$details['bill_number'])->value('id');
@endphp
<br><a href="{{url('/admin/order-detail/')}}/{{$id}}" style="font-family: Mitr !important;">ตรวจสอบคำสั่งหมายเลข {{$details['bill_number']}}</a>
@endsection