@extends("/backend/layouts/template/template-admin")

@section("content")
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
                <div class="card-header">
                    <h4 class="card-title">รายละเอียดคำสั่งซื้อ</h4>
                </div>
                <div class="card-body">
                    <p class="demo">
                        <div class="row">
                            <div class="col-md-4">
                                <h4>ข้อมูลของลูกค้า</h4><hr style="border-top:3px solid rgb(214 214 214)">
                                @php
                                    $customer_code = DB::table('customers')->where('id',$order->customer_id)->value('customer_code');
                                    $name = DB::table('customers')->where('id',$order->customer_id)->value('name');
                                    $surname = DB::table('customers')->where('id',$order->customer_id)->value('surname');
                                    $phone = DB::table('customers')->where('id',$order->customer_id)->value('phone');
                                    $district = DB::table('shipments')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('district');
                                @endphp
                                <p style="font-size: 18px;">หมายเลขสมาชิก : {{$customer_code}}</p>
                                <p style="font-size: 18px;">ชื่อลูกค้า : {{$name}} {{$surname}}</p>
                                <p style="font-size: 18px;">เบอร์โทรศัพท์ : {{$phone}}</p>
                            </div>
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
                                    $slip = DB::table('payment_checkouts')->where('customer_id',$order->customer_id)->where('bill_number',$order->bill_number)->value('slip');
                                    $discount_format = number_format($discount);
                                @endphp

                                @php
                                    $shipping = DB::table('shipping_costs')->where('store_id',$order->store_id)->where('place',$district)->get();
                                    $shipping_count = count($shipping); // นับจำนวนข้อมูลที่ตรงกัน
                                    $min_cost = DB::table('shipping_costs')->where('store_id',$order->store_id)->where('place',$district)->value('min_cost');
                                    $price = DB::table('shipping_costs')->where('store_id',$order->store_id)->where('place',$district)->value('price');

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
                                <p style="font-size: 18px;">วันที่ชำระเงิน : {{$payday}} {{$time}}</p>
                                <p style="font-size: 18px;">จำนวนเงินที่ชำระ : {{$money}}</p>
                                <p style="font-size: 18px;">ส่วนลดคูปอง : {{$discount_format}} บาท ค่าจัดส่ง : {{$price_delivery}} บาท</p>
                                <p style="font-size: 18px;">ราคารวมทั้งหมด : {{$total_}} บาท</p>
                                <a href="{{url('/image_upload/payment')}}/{{$slip}}" target="_blank"><p style="font-size: 18px;">หลักฐานการโอนเงิน</p></a>
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
                                @endphp
                                <p style="font-size: 16px;">{{$name}} {{$phone}}</p>
                                <p style="font-size: 16px;">ที่อยู่ {{$address}} ตำบล {{$district}} อำเภอ {{$amphoe}} จังหวัด {{$province}} {{$zipcode}}</p>
                                <p style="font-size: 16px;">
                                    <a type="button" data-toggle="modal" data-target="#ModalShipment"><i class="fa fa-pencil-square-o" style="color:blue; font-family: 'Noto Sans Thai','FontAwesome';"> แก้ไขข้อมูลการจัดส่ง</i></a>
                                </p>
                            </div>
                        </div>
                    </p>
                    <p class="demo">
                        <h4 class="card-title">สถานะการจัดส่ง</h4><hr>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>อัพเดตสถานะการจัดส่ง</h4><hr style="border-top:3px solid rgb(214 214 214)">
                                <a type="button" data-toggle="modal" data-target="#ModalStatus">
                                    <i class="fa fa-pencil-square-o" style="color:blue; font-family: 'Noto Sans Thai','FontAwesome';"> กดเพื่ออัพเดตสถานะการจัดส่ง</i>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <h4>สถานะการจัดส่ง</h4><hr style="border-top:3px solid rgb(214 214 214)">
                                @php
                                    $status = DB::table('order_confirms')->where('bill_number',$order->bill_number)->orderBy('id','desc')->value('status');
                                    $date = DB::table('order_confirms')->where('bill_number',$order->bill_number)->orderBy('id','desc')->value('created_at');
                                @endphp

                                @if($status == null || $status == 'รอยืนยัน')
                                    <p style="color: red; font-size:15px;">รอยืนยัน</p>
                                @elseif($status == 'กำลังจัดส่ง')
                                    <p style="color:blue; font-size:15px;">กำลังจัดส่ง {{$date}}</p>
                                @else
                                    <p style="color:green; font-size:15px;">จัดส่งแล้ว {{$date}}</p>
                                @endif
                            </div>
                        </div>
                    </p>
                </div>
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
                            @php
                                $NUM_PAGE = 10;
                                $product_ids = DB::table('product_carts')->where('bill_number',$order->bill_number)->paginate($NUM_PAGE);
                                $page = \Request::input('page');
                                $page = ($page != null)?$page:1;
                            @endphp
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสสินค้า</th>
                                    <th>เมนู</th>
                                    <th>ราคาขายต่อหน่วย</th>
                                    <th>จำนวน</th>
                                    <th>ราคารวม</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_ids as $product_id => $value)
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $product_id+1}}</td>
                                        @php
                                            $product_code = DB::table('food_menus')->where('id',$value->product_id)->value('code');
                                            $product_name = DB::table('food_menus')->where('id',$value->product_id)->value('thai_name');
                                            $qty = DB::table('product_carts')->where('id',$value->id)->value('qty');
                                            $price = DB::table('product_carts')->where('id',$value->id)->value('price');
                                            $price_format = number_format($price);
                                            $comment = DB::table('product_carts')->where('id',$value->id)->value('comment');
                                            $totalPrice = number_format($qty * $price);
                                        @endphp
                                        <td>{{$product_code}}</td>
                                        <td>{{$product_name}}</td>
                                        <td>{{$price_format}}.-</td>
                                        <td>{{$qty}} รายการ</td>
                                        <td>{{$totalPrice}}.-</td>
                                        <td>{{$comment}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{$product_ids->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">อัพเดตสถานะการจัดส่ง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($status == null || $status == "รอยืนยัน")
                <form action="{{url('/admin/update-order-status')}}" enctype="multipart/form-data" method="post">@csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <select name="status" class="form-control">
                                    <option value="รอยืนยัน">รอยืนยัน</option>
                                    <option value="กำลังจัดส่ง">กำลังจัดส่ง</option>
                                    <option value="จัดส่งแล้ว">จัดส่งแล้ว</option>
                                </select>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="bill_number" value="{{$order->bill_number}}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">อัพเดตสถานะการจัดส่ง</button>
                    </div>
                </form>
            @elseif($status == "กำลังจัดส่ง")
                <form action="{{url('/admin/update-order-status')}}" enctype="multipart/form-data" method="post">@csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <select name="status" class="form-control">
                                    <option value="จัดส่งแล้ว">จัดส่งแล้ว</option>
                                </select>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="bill_number" value="{{$order->bill_number}}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">อัพเดตสถานะการจัดส่ง</button>
                    </div>
                </form>
            @elseif($status == "จัดส่งแล้ว")
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <center><h3>ไม่สามารถแก้ไขสถานะการจัดส่งได้<br>เนื่องจากอยู่ในสถานะจัดส่งแล้ว</h3></center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalShipment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูลการจัดส่ง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($status == null || $status == "รอยืนยัน")
            <form action="{{url('/admin/update-shipment')}}" enctype="multipart/form-data" method="post">@csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            @php
                                $name = DB::table('shipments')->where('bill_number',$order->bill_number)->value('name');
                                $phone = DB::table('shipments')->where('bill_number',$order->bill_number)->value('phone');
                                $address = DB::table('shipments')->where('bill_number',$order->bill_number)->value('address');
                                $district = DB::table('shipments')->where('bill_number',$order->bill_number)->value('district');
                                $amphoe = DB::table('shipments')->where('bill_number',$order->bill_number)->value('amphoe');
                                $zipcode = DB::table('shipments')->where('bill_number',$order->bill_number)->value('zipcode');
                                $id = DB::table('shipments')->where('bill_number',$order->bill_number)->value('id');
                            @endphp
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" value="{{$name}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="phone" value="{{$phone}}" class="phone_format form-control"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="address" value="{{$address}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="province" value="{{$province}}" class="form-control"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="zipcode" value="{{$zipcode}}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="bill_number" value="{{$order->bill_number}}">
                    <input type="hidden" name="id" value="{{$id}}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">อัพเดตข้อมูลการจัดส่ง</button>
                </div>
            </form>
            @elseif($status == "กำลังจัดส่ง" || $status == "จัดส่งแล้ว")
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <center><h3>ไม่สามารถแก้ไขข้อมูลการจัดส่งได้<br>เนื่องจากอยู่ในสถานะ {{$status}}</h3></center>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
            @endif
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script>
<script>
   // number phone
   function phoneFormatter() {
        $('input.phone_format').on('input', function() {
            var number = $(this).val().replace(/[^\d]/g, '')
                if (number.length >= 5 && number.length < 10) { number = number.replace(/(\d{3})(\d{2})/, "$1-$2"); } else if (number.length >= 10) {
                    number = number.replace(/(\d{3})(\d{3})(\d{3})/, "$1-$2-$3"); 
                }
            $(this).val(number)
            $('input.phone_format').attr({ maxLength : 12 });    
        });
    };
    $(phoneFormatter);
</script>
@endsection