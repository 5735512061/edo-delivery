@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">เพิ่มเมนูอาหาร</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-menu')}}" enctype="multipart/form-data" method="post">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    @php
                        $random = rand(111111,999999);  
                        $random_format = wordwrap($random , 4 , '-' , true );
                        $code_gen = 'EDO-M-'.$random_format;

                        $code = DB::table('stores')->where('code',$code_gen)->value('code');
                            if($code == null) {
                                $code = $code_gen; 
                            } else {
                                $random = rand(111111,999999);  
                                $random_format = wordwrap($random , 4 , '-' , true );
                                $code_gen = 'EDO-M-'.$random_format;
                            }
                        
                        $stores = DB::table('stores')->get();
                        $menu_types = DB::table('menu_types')->get();
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>รหัสเมนูอาหาร</label>
                            @if ($errors->has('code'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('code') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="code" value="{{$code}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>ร้านค้า</label>
                            <select class="form-control" name="store_id">
                                @foreach ($stores as $store => $value)
                                    <option value="{{$value->id}}">{{$value->name}} - {{$value->branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ประเภทเมนูอาหาร</label>
                            <select class="form-control" name="menu_type_id">
                                @foreach ($menu_types as $menu_type => $value)
                                    <option value="{{$value->id}}">{{$value->menu_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ชื่อเมนูอาหาร (ภาษาไทย)</label>
                            @if ($errors->has('thai_name'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('thai_name') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="thai_name">
                        </div>
                        <div class="form-group">
                            <label>ชื่อเมนูอาหาร (ภาษาอังกฤษ)</label>
                            @if ($errors->has('eng_name'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('eng_name') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="eng_name">
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดเพิ่มเติม (ถ้ามี)</label>
                            <textarea class="form-control" rows="3" name="detail"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">รูปภาพเมนูอาหาร</label>
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
                            <label>สต๊อก</label>
                            <select class="form-control" name="stock">
                                <option value="มีสินค้า">มีสินค้า</option>
                                <option value="สินค้าหมด">สินค้าหมด</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">เพิ่มเมนูอาหาร</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection