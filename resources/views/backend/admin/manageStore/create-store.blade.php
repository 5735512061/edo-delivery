@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">สร้างข้อมูลร้านค้า</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-store')}}" enctype="multipart/form-data" method="post">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    @php
                        $random = rand(111111,999999);  
                        $random_format = wordwrap($random , 4 , '-' , true );
                        $code_gen = 'EDO-'.$random_format;

                        $code = DB::table('stores')->where('code',$code_gen)->value('code');
                            if($code == null) {
                                $code = $code_gen; 
                            } else {
                                $random = rand(111111,999999);  
                                $random_format = wordwrap($random , 4 , '-' , true );
                                $code_gen = 'EDO-'.$random_format;
                            }
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>รหัสร้านค้า</label>
                            <input type="text" class="form-control form-control-sm" name="code" value="{{$code_gen}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>ชื่อร้านค้า</label>
                            @if ($errors->has('name'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('name') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="name">
                        </div>
                        <div class="form-group">
                            <label>สาขา</label>
                            <input type="text" class="form-control form-control-sm" name="branch">
                        </div>
                        <div class="form-group">
                            <label>หมายเลขโทรศัพท์</label>
                            @if ($errors->has('phone'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('phone') }})</span>
                            @endif
                            <input type="text" class="phone_format form-control form-control-sm" name="phone">
                        </div>
                        <div class="form-group">
                            <label>ที่อยู่ร้านค้า</label>
                            <textarea class="form-control" rows="3" name="address"></textarea>
                        </div>
                        <div class="form-group">
                            <label>FACEBOOK NAME</label>
                            <input type="text" class="form-control form-control-sm" name="facebook">
                        </div>
                        <div class="form-group">
                            <label>FACEBOOK URL</label>
                            <input type="text" class="form-control form-control-sm" name="facebook_url">
                        </div>
                        <div class="form-group">
                            <label>INSTAGRAM NAME</label>
                            <input type="text" class="form-control form-control-sm" name="instagram">
                        </div>
                        <div class="form-group">
                            <label>INSTAGRAM URL</label>
                            <input type="text" class="form-control form-control-sm" name="instagram_url">
                        </div>
                        <div class="form-group">
                            <label>LINE</label>
                            <input type="text" class="form-control form-control-sm" name="line">
                        </div>
                        <div class="form-group">
                            <label>LINE URL</label>
                            <input type="text" class="form-control form-control-sm" name="line_url">
                        </div>
                        <div class="form-group">
                            <label>MAIL</label>
                            <input type="text" class="form-control form-control-sm" name="mail">
                        </div>
                        <div class="form-group">
                            <label>สถานะ</label>
                            <select class="form-control" name="status">
                                <option value="เปิด">เปิด</option>
                                <option value="ปิด">ปิด</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="logo">รูปภาพโลโก้ร้านค้า</label>
                            @if ($errors->has('logo'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('logo') }})</span>
                            @endif
                            <input type="file" class="form-control-file" id="logo" name="logo">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">สร้างรายชื่อร้านค้า</button>
                        </div>
                    </div>
                </div>
            </form>
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