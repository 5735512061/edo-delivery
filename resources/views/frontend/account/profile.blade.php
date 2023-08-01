@extends("/frontend/layouts/template/template")

@section("content")
<div class="text-center mb-5">
    <h1>ข้อมูลส่วนตัว<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:60px;"></h1>
    <h2>คุณ{{$customer->name}} {{$customer->surname}}</h2>
    <h2>รหัสสมาชิก {{$customer->customer_code}}</h2>
    <h2>เบอร์โทรศัพท์ {{$customer->phone}}</h2>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-4">
                <a href="{{url('/customer/order-history')}}/{{$store_id}}"><button class="btn btn-white mb-4" style="height: 70px; width: 20em;">ประวัติการสั่งซื้อสินค้า</button></a>
            </div>
            <div class="col-md-4">
                <a href="{{url('/customer/message-history')}}/{{$store_id}}"><button class="btn btn-white mb-4" style="height: 70px; width: 20em;">ประวัติการติดต่อสอบถาม</button></a>
            </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-4">
                <a href="{{url('/customer/shopping-cart')}}/{{$store_id}}"><button class="btn btn-white mb-4" style="height: 70px; width: 20em;">ตะกร้าสินค้า</button></a>
            </div>
            <div class="col-md-4">
                <a href="{{url('/customer/edit-profile')}}/{{$customer->id}}/{{$store_id}}"><button class="btn btn-white mb-4" style="height: 70px; width: 20em;">แก้ไขข้อมูลส่วนตัว</button></a>
            </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-4">
                <a href="{{url('/customer/change-password')}}/{{$store_id}}"><button class="btn btn-white mb-4" style="height: 70px; width: 20em;">เปลี่ยนรหัสผ่าน</button></a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('customer.logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><button class="btn btn-white mb-4" style="height: 70px; width: 20em;">ออกจากระบบ</button></a>
                <form id="logout-form" action="{{ 'App\Customer' == Auth::getProvider()->getModel() ? route('customer.logout') : route('customer.logout') }}" method="POST" style="display: none;">@csrf
                    <input type="hidden" name="store_id" value="{{$store_id}}">
                </form>
            </div>
        <div class="col-md-2"></div>
    </div>
</div>

@endsection