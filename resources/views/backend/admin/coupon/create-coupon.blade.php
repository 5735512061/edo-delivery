@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">คูปองส่วนลด</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-coupon')}}" enctype="multipart/form-data" method="post">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            @php
                                $stores = DB::table('stores')->get();
                            @endphp
                            <label>ร้านค้า</label>
                            <select class="form-control" name="store_id">
                                @foreach ($stores as $store => $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ชื่อคูปอง</label>
                            @if ($errors->has('coupon_name'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('coupon_name') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="coupon_name">
                        </div>
                        <div class="form-group">
                            <label>ตัวเลือกของคูปอง</label>
                            <select class="form-control" name="coupon_option" onchange="yesnoCheck(this);">
                                <option value="กำหนดเอง">กำหนดเอง</option>
                                <option value="อัตโนมัติ">อัตโนมัติ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>โค้ดส่วนลด</label>
                            @if ($errors->has('code'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('code') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="code" id="manual">
                            <input type="text" class="form-control form-control-sm" name="code" id="manual" style="display: none;">
                            <input type="text" class="form-control form-control-sm" name="code" id="auto" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label>ประเภทของส่วนลด</label>
                            <select class="form-control" name="amount_type">
                                <option value="ค่าคงที่">ค่าคงที่</option>
                                <option value="เปอร์เซ็นต์">เปอร์เซ็นต์</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>จำนวนส่วนลด</label>
                            @if ($errors->has('amount'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('amount') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="amount">
                        </div>
                        <div class="form-group">
                            <label>ประเภทของคูปอง</label>
                            <select class="form-control" name="coupon_type">
                                <option value="ใช้ได้ครั้งเดียว">ใช้ได้ครั้งเดียว</option>
                                <option value="ใช้ได้หลายครั้ง">ใช้ได้หลายครั้ง</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ตัวเลือกของผู้ใช้</label>
                            @if ($errors->has('user_option'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('user_option') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="user_option" placeholder="กำหนดตัวเลือกคนเดียว หลายคน หรือทุกคน">
                        </div>
                        <div class="form-group">
                            <label>ตัวเลือกของรายการอาหาร</label>
                            @if ($errors->has('category_option'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('category_option') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="category_option" placeholder="ชื่อเมนู หรือประเภทเมนู">
                        </div>
                        <div class="form-group">
                            <label for="image">รูปภาพคูปอง</label>
                            @if ($errors->has('image'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('image') }})</span>
                            @endif
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label>สถานะ</label>
                            <select class="form-control" name="status">
                                <option value="เปิด">เปิด</option>
                                <option value="ปิด">ปิด</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">สร้างคูปองส่วนลด</button>
                        </div>
                    </div>
                </div>
            </form>
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
                                    <th>ชื่อคูปอง</th>
                                    <th>ตัวเลือกของคูปอง</th>
                                    <th>โค้ดส่วนลด</th>
                                    <th>ประเภทของส่วนลด</th>
                                    <th>จำนวนส่วนลด</th>
                                    <th>ประเภทของคูปอง</th>
                                    <th>ตัวเลือกของผู้ใช้</th>
                                    <th>ตัวเลือกของรายการอาหาร</th>
                                    <th>รูปภาพคูปอง</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon => $value)
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $coupon+1}}</td>
                                        <td>{{$value->coupon_name}}</td>
                                        <td>{{$value->coupon_option}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>{{$value->amount_type}}</td>
                                        <td>{{$value->amount}}</td>
                                        <td>{{$value->coupon_type}}</td>
                                        <td>{{$value->user_option}}</td>
                                        <td>{{$value->category_option}}</td>
                                        <td>{{$value->image}}</td>
                                        <td>{{$value->status}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{$coupons->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function yesnoCheck(that) {
        if (that.value == "อัตโนมัติ") {
            document.getElementById("auto").style.display = "block";
            document.getElementById("manual").style.display = "none";
        } else {
            document.getElementById("manual").style.display = "block";
            document.getElementById("auto").style.display = "none";
        }
    }
</script>
@endsection