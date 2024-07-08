@extends("/frontend/layouts/template/template")
<style>
  .btn-primary:hover {
    color: #000 !important;
  }
</style>
@section("content")
@php
    $store_id = $store_id;
@endphp
{{-- <div class="hero-wrap hero-bread" style="background-image: url('../../images/header/header-1.jpg');"></div> --}}
<section class="ftco-section ftco-cart">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate">
        <h2 class="mb-4">CHECKOUT<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:60px;"></h2>
      </div>
    </div>   		
  </div>

  <form action="{{url('/customer/payment-checkout')}}" enctype="multipart/form-data" method="post" class="billing-form">@csrf
  <section class="ftco-section">
    <div class="container">  
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
          <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
      @endforeach
      <div class="row justify-content-center">
        
        <div class="col-xl-7 ftco-animate">
          <h3 class="mb-4 billing-heading">ที่อยู่ในการจัดส่งสินค้า</h3>
          <div class="row align-items-end">
            <div class="col-md-6">
              @if ($errors->has('name'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('name') }})</span>
              @endif
              <div class="form-group">
                <label for="firstname">ชื่อ-นามสกุล</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกชื่อ-นามสกุล" style="font-family: 'Noto Sans Thai'" name="name">
              </div>
            </div>
            <div class="col-md-6">
              @if ($errors->has('phone'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('phone') }})</span>
              @endif
              <div class="form-group">
                <label for="lastname">เบอร์โทรศัพท์</label>
                <input type="text" class="phone_format form-control" placeholder="กรุณากรอกเบอร์โทรศัพท์ติดต่อ" style="font-family: 'Noto Sans Thai'" name="phone">
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-6">
              @if ($errors->has('address'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('address') }})</span>
              @endif
              <div class="form-group">
                <label for="streetaddress">ที่อยู่</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกที่อยู่ ชื่ออาคาร หมู่บ้าน" style="font-family: 'Noto Sans Thai'" name="address">
              </div>
            </div>
            <div class="col-md-6">
              @if ($errors->has('district'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('district') }})</span>
              @endif
              <div class="form-group">
                <label for="towncity">ตำบล</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกชื่อตำบล" style="font-family: 'Noto Sans Thai'" name="district" id="district">
              </div>
            </div>
            <div class="col-md-6">
              @if ($errors->has('amphoe'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('amphoe') }})</span>
              @endif
              <div class="form-group">
                <label for="postcodezip">อำเภอ</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกชื่ออำเภอ" style="font-family: 'Noto Sans Thai'" name="amphoe" id="amphoe">
              </div>
            </div>
            <div class="col-md-6">
              @if ($errors->has('province'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('province') }})</span>
              @endif
              <div class="form-group">
                <label for="postcodezip">จังหวัด</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกชื่อจังหวัด" style="font-family: 'Noto Sans Thai'" name="province" id="province">
              </div>
            </div>
            <div class="col-md-6">
              @if ($errors->has('zipcode'))
                <span class="text-danger" style="font-size: 17px;">({{ $errors->first('zipcode') }})</span>
              @endif
              <div class="form-group">
                <label for="postcodezip">รหัสไปรษณีย์</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกรหัสไปรษณีย์" style="font-family: 'Noto Sans Thai'" name="zipcode" id="zipcode">
              </div>
            </div>
          </div>
        </div>
        @php
          $totalPrice = 0;
        @endphp
        @foreach($products as $product)
          @php 
            $id = $product['item'];
            $name = DB::table('food_menus')->where('id',$id)->value('thai_name'); 
            $price = $product['price']/$product['qty'];
            $totalPrice += $product['price'];
          @endphp
          <input type="hidden" value="{{ $name }}" name="product[]">
          <input type="hidden" value="{{ $price }}" name="price[]">
          <input type="hidden" value="{{ $product['qty'] }}" name="qty[]">
          <input type="hidden" value="{{ $product['item'] }}" name="product_id[]">
          <input type="hidden" value="{{ $product['comment'] }}" name="comment[]">
        @endforeach
        <div class="col-xl-5">
          <div class="row mt-5 pt-3">
            <div class="col-md-12 d-flex mb-3">
              <div class="cart-detail cart-total p-3 p-md-4">
                <h3 class="billing-heading mb-4">Cart Total</h3>
                <p class="d-flex">
                  <span>Subtotal</span>
                  <span>{{ number_format($totalPrice) }}.00 บาท</span>
                </p> 
                <p class="d-flex">
                  <span>Delivery</span>
                  <span id="price">0.00 บาท</span>
                </p>
                <p style="color: red;" id="not_delivery"></p>
                @if(session()->has('coupon'))
                  <p class="d-flex">
                    <span>Discount ({{ session()->get('coupon')['name'] }})</span>
                    <span>{{ number_format(session()->get('coupon')['discount']) }} บาท</span>
                    @php
                        $coupon = session()->get('coupon')['discount'];
                    @endphp
                  </p>
                  <a href="{{ route('coupon.destroy',['store_id' => $store_id]) }}" style="color: red;">Remove Coupon</a>
                @else 
                  @php
                    $coupon = 0;
                  @endphp
                @endif
                <hr>
                <p class="d-flex total-price">
                  <span>Total</span>
                  @if(session()->has('coupon'))
                    <span id="totalPrice">{{ number_format(session()->get('coupon')['total']) }}.00 บาท</span>
                  @else 
                    <span id="totalPrice">{{ number_format($totalPrice) }}.00 บาท</span>
                  @endif
                </p>
              </div>
            </div>
            <div class="col-md-12">
              <div class="cart-detail cart-total mb-3">
                <div class="input-group">
                    <div class="input-group-append">
                      <a href="" class="btn btn-white" data-toggle="modal" data-target="#ModalStatus" data-backdrop="static">กดใช้คูปองส่วนลด</a>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="cart-detail p-3 p-md-4">
                <h3 class="billing-heading mb-4">รายละเอียดการชำระเงิน</h3>
                <p>ธนาคารไทยพาณิชย์</p>
                <p>เลขที่บัญชี : 012-3-45678-9</p>
                <p>ชื่อบัญชี : นายเอกรักษ์ ศักดิ์ศรีสุวรรณ</p>
                @if ($errors->has('money'))
                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('money') }})</span>
                @endif
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="* จำนวนเงิน ตัวอย่าง 790 บาท" style="font-family: 'Noto Sans Thai'" name="money">
                </div>
                @if ($errors->has('payday'))
                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('payday') }})</span>
                @endif
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="* วันที่ชำระเงิน ตัวอย่าง 01/01/2564" style="font-family: 'Noto Sans Thai'" name="payday">
                </div>
                @if ($errors->has('time'))
                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('time') }})</span>
                @endif
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="* เวลาชำระเงิน ตัวอย่าง 14.30น." style="font-family: 'Noto Sans Thai'" name="time">
                </div>
                <label class="col-form-label">แนบหลักฐานการโอนเงิน</label>
                @if ($errors->has('slip'))
                    <span class="text-danger" style="font-size: 17px; font-family: 'Noto Sans Thai'">({{ $errors->first('slip') }})</span>
                @endif
                <div class="form-group">
                  <input type="file" class="form-control" style="font-family: 'Noto Sans Thai'; height:30px !important;" name="slip">
                </div>
                <input type="hidden" name="store_id" value="{{$store_id}}">
                @if(session()->has('coupon'))
                  <input type="hidden" name="coupon_id" value="{{ session()->get('coupon')['coupon_id'] }}">
                @endif
                <p id="button"><button type="submit" style="font-family: 'Noto Sans Thai'; color:#fff !important;" class="btn btn-primary py-3 px-4">แจ้งชำระเงิน</button></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  </form>
  <!-- Modal -->
  <form action="{{ route('coupon.store') }}" method="POST">@csrf
    <div class="modal fade" id="ModalStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="col-md-12">
                    <input type="text" name="code" class="form-control" placeholder="กรอกโค้ดส่วนลด (ถ้ามี)" style="font-family: 'Noto Sans Thai';">
                    <input type="hidden" name="store_id" value="{{$store_id}}">
                    <input type="hidden" name="totalPrice" value="{{$totalPrice}}">
                  </div>
                </div>
                <div class="modal-footer">
                  
                  <button type="sumbit" class="btn btn-white">กดใช้คูปองส่วนลด</button> 
                </div>
            </div>
        </div>
    </div>
  </form>
</section>
{{-- <script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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

<script type="text/javascript">
  $(document).ready(function () {
      $('#district').change(function (e) {
        var district = $("#district").val();
        var store_id = {!! $store_id !!};
        shipping(district,store_id);
      });
  });
  
  var price_delivery = 0;
  var min_cost = 0;
  var total = {!! $totalPrice !!};
  var coupon = {!! $coupon !!};

  function shipping(district,store_id) {
    $.ajax({
      url: "<?= url('/customer/shipping-cost/') ?>",
      data: { 
        district: district,
        store_id: store_id
      },
      method: 'GET',
      success: function (response) {
        console.log(response)
        if(response.status === "Pass") {
          $price = response.price;
          $min_cost = response.min_cost;
          if(total-coupon < $min_cost) {
            document.getElementById("price").innerHTML = $price + ".00 บาท";
            document.getElementById("not_delivery").innerHTML = "";
            document.getElementById("button").innerHTML = '<button type="submit" style="font-family: Noto Sans Thai; color:#fff !important;" class="btn btn-primary py-3 px-4">แจ้งชำระเงิน</button>';
            price_delivery = $price; 
          } else {
            document.getElementById("price").innerHTML = 0 + ".00 บาท";
            document.getElementById("not_delivery").innerHTML = "";
            document.getElementById("button").innerHTML = '<button type="submit" style="font-family: Noto Sans Thai; color:#fff !important;" class="btn btn-primary py-3 px-4">แจ้งชำระเงิน</button>';
            price_delivery = 0;
          }
        } 
        else if(response.status == "NULL") {
          $price = 0;
          document.getElementById("price").innerHTML = $price + ".00 บาท";
          document.getElementById("not_delivery").innerHTML = "พื้นที่นี้ไม่ได้อยู่ในพื้นที่จัดส่ง กรุณากรอกที่อยู่ใหม่<br>**กรณีลูกค้ากดสั่ง ทางร้านจะไม่รับผิดชอบค่าใช้จ่ายค่ะ";
          document.getElementById("button").innerHTML = '<p style="text-align: center; color: red;">พื้นที่นี้ไม่ได้อยู่ในพื้นที่จัดส่ง กรุณากรอกที่อยู่ใหม่<br>**กรณีลูกค้ากดสั่ง ทางร้านจะไม่รับผิดชอบค่าใช้จ่ายค่ะ</p>';
          price_delivery = $price;
        }
        $price_delivery = JSON.parse(price_delivery);
        document.getElementById("totalPrice").innerHTML = parseInt($price_delivery + total - coupon) + ".00 บาท";
      }
    });
  }
</script>
@endsection