@extends("/frontend/layouts/template/template")

@section("content")
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate">
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
              @if(Session::has('alert-' . $msg))

              <p style="font-size: 16px;" class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
            @endforeach
        </div>    
        <h2 class="mb-4">รายละเอียดการสั่งซื้อ<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:60px;"></h2>
      </div>
    </div>   		
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-lg-8">
            <h3>หมายเลขบิล {{$order->bill_number}}</h3><br>
            <div class="row">
                <div class="col-md-4">
                    <h4>ข้อมูลการชำระเงิน</h4><hr style="border-top:3px solid rgb(214 214 214)">
                    @php
                        $totalPrice = DB::table('product_carts')->where('bill_number',$order->bill_number)
                                                                ->sum(DB::raw('price * qty'));

                        // coupon
                        $amount_type = DB::table('coupons')->where('id',$order->coupon_id)->value('amount_type');
                        $amount = DB::table('coupons')->where('id',$order->coupon_id)->value('amount');

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
                        $payday = DB::table('payment_checkouts')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('payday');
                        $time = DB::table('payment_checkouts')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('time');
                        $money = DB::table('payment_checkouts')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('money');
                        $discount_format = number_format($discount);
                    @endphp
                    <p style="font-size: 18px;">วันที่ชำระเงิน : {{$payday}} {{$time}}</p>
                    <p style="font-size: 18px;">จำนวนเงินที่ชำระ : {{$money}} บาท</p>
                    <p style="font-size: 18px;">ส่วนลดคูปอง : {{$discount_format}} บาท</p>
                </div>
                <div class="col-md-4">
                    <h4>ที่อยู่สำหรับจัดส่ง</h4><hr style="border-top:3px solid rgb(214 214 214)">
                    @php
                        $name = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('name');
                        $phone = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('phone');
                        $address = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('address');
                        $district = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('district');
                        $amphoe = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('amphoe');
                        $province = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('province');
                        $zipcode = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('zipcode');
                        $status = DB::table('order_confirms')->where('bill_number',$order->bill_number)->orderBy('id','desc')->value('status');
                        $date = DB::table('order_confirms')->where('bill_number',$order->bill_number)->orderBy('id','desc')->value('created_at');
                    @endphp
                    <p style="font-size: 16px;">{{$name}} {{$phone}}</p>
                    <p style="font-size: 16px;">ที่อยู่ {{$address}} ตำบล{{$district}} อำเภอ{{$amphoe}} จังหวัด{{$province}} {{$zipcode}}</p>
                </div>
                <div class="col-md-4">
                    <h4>ข้อมูลการจัดส่ง</h4><hr style="border-top:3px solid rgb(214 214 214)">
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

                        $total_ = number_format($total + $price_delivery);
                    @endphp
                    <p style="font-size: 18px;">ค่าจัดส่ง : {{$price_delivery}} บาท</p>
                    <p style="font-size: 18px;">สถานะการจัดส่ง
                        @if($status == null || $status == 'รอยืนยัน')
                            <p style="color: red; font-size:17px;">รอยืนยัน</p>
                        @elseif($status == 'กำลังจัดส่ง')
                            <p style="color:blue; font-size:15px;">กำลังจัดส่ง {{$date}}</p>
                        @else
                            <p style="color:green; font-size:15px;">จัดส่งแล้ว <br>{{$date}}</p>
                        @endif
                    </p>
                    
                </div>
            </div><hr><p style="font-size:18px;">ราคารวมทั้งหมด : {{$total_}} บาท</p><hr>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 ftco-animate">
            <div class="cart-list">
                @php
                    $NUM_PAGE = 10;
                    $product_ids = DB::table('product_carts')->where('bill_number',$order->bill_number)->paginate($NUM_PAGE);
                    $page = \Request::input('page');
                    $page = ($page != null)?$page:1;
                @endphp
                <table class="table" style="min-width: 1000px !important;">
                    <thead class="thead-primary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคาขายต่อหน่วย</th>
                        <th>จำนวน</th>
                        <th>ราคารวม</th>
                        <th>หมายเหตุ</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($product_ids as $product_id => $value)
                            <tr class="text-center">
                                <td>{{$NUM_PAGE*($page-1) + $product_id+1}}</td>
                                @php
                                    $product_name = DB::table('food_menus')->where('id',$value->product_id)->value('thai_name');
                                    $qty = DB::table('product_carts')->where('id',$value->id)->value('qty');
                                    $price = DB::table('product_carts')->where('id',$value->id)->value('price');
                                    $comment = DB::table('product_carts')->where('id',$value->id)->value('comment');
                                    $totalPrice = number_format($qty * $price);
                                @endphp

                                <td>{{$product_name}}</td>
                                <td>{{$price}}.-</td>
                                <td>{{$qty}}</td>
                                <td>{{$totalPrice}}.-</td>
                                <td>{{$comment}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection