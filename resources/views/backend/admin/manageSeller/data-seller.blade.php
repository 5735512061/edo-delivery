@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">จัดการข้อมูลพนักงานขาย</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-seller')}}" enctype="multipart/form-data" method="post">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    @php
                        $random = rand(111111,999999);  
                        $random_format = wordwrap($random , 4 , '-' , true );
                        $code_gen = 'SEL-'.$random_format;

                        $code = DB::table('sellers')->where('seller_code',$code_gen)->value('seller_code');
                            if($code == null) {
                                $code = $code_gen; 
                            } else {
                                $random = rand(111111,999999);  
                                $random_format = wordwrap($random , 4 , '-' , true );
                                $code_gen = 'SEL-'.$random_format;
                            }
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @php
                                $stores = DB::table('stores')->get();
                            @endphp
                            <label>ร้านค้า</label>
                            <select class="form-control" name="store_id">
                                @foreach ($stores as $store => $value)
                                    <option value="{{$value->id}}">{{$value->name}} - {{$value->branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>รหัสพนักงานขาย</label>
                            <input type="text" class="form-control form-control-sm" name="seller_code" value="{{$code_gen}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>ชื่อพนักงานขาย</label>
                            @if ($errors->has('name'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('name') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="name">
                        </div>
                        <div class="form-group">
                            <label>หมายเลขโทรศัพท์</label>
                            @if ($errors->has('phone'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('phone') }})</span>
                            @endif
                            <input type="text" class="phone_format form-control form-control-sm" name="phone">
                        </div>
                        <div class="form-group">
                            <label>ชื่อเข้าใช้งาน (ภาษาอังกฤษ)</label>
                            @if ($errors->has('username'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('username') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="username" value="{{ old('username') }}">
                        </div>
                        <div class="form-group">
                            <label>รหัสผ่าน</label>
                            @if ($errors->has('password'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('password') }})</span>
                            @endif
                            <input id="password" type="password" class="form-control form-control-sm" name="password">
                        </div>
                        <div class="form-group">
                            <label>บทบาท</label>
                            <select class="form-control" name="role">
                                <option value="พนักงานขาย">พนักงานขาย</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>สถานะ</label>
                            <select class="form-control" name="status">
                                <option value="เปิด">เปิด</option>
                                <option value="ปิด">ปิด</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}">
                            <button type="submit" class="btn btn-primary">เพิ่มพนักงานขาย</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>สาขา</th>
                                    <th>รหัสพนักงานขาย</th>
                                    <th>พนักงานขาย</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>บทบาท</th>
                                    <th>สถานะ</th>
                                    <th>ชื่อเข้าใช้งาน</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sellers as $seller => $value)
                                    @php
                                        $store = DB::table('stores')->where('id',$value->store_id)->value('name');
                                        $branch = DB::table('stores')->where('id',$value->store_id)->value('branch');
                                    @endphp
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $seller+1}}</td>
                                        <td>{{$store}}-{{$branch}}</td>
                                        <td>{{$value->seller_code}}</td>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->role}}</td>
                                        <td>{{$value->status}}</td>
                                        <td>{{$value->username}}</td>
                                        <td>       
                                            <a data-toggle="modal" data-target="#EditSeller{{$value->id}}">
                                                <i class="fas fa-edit" style="color:blue;"></i>
                                            </a>        
                                            <a href="{{url('/admin/delete-seller/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="EditSeller{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูลพนักงานขาย</h5>
                                                </div>
                                                <form action="{{url('/admin/update-seller')}}" enctype="multipart/form-data" method="post">@csrf
                                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                        @if(Session::has('alert-' . $msg))
                                                            <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                        @endif
                                                    @endforeach
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>รหัสพนักงานขาย</label>
                                                                <input type="text" class="form-control form-control-sm" name="seller_code" value="{{$value->seller_code}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>ชื่อ</label>
                                                                @if ($errors->has('name'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('name') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="name" value="{{$value->name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>หมายเลขโทรศัพท์</label>
                                                                @if ($errors->has('phone'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('phone') }})</span>
                                                                @endif
                                                                <input type="text" class="phone_format form-control form-control-sm" name="phone" value="{{$value->phone}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>ชื่อเข้าใช้งาน (ภาษาอังกฤษ)</label>
                                                                @if ($errors->has('username'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('username') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="username" value="{{$value->username}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>บทบาท</label>
                                                                <select class="form-control" name="role">
                                                                    <option value="{{$value->role}}">{{$value->role}}</option>
                                                                    <option value="พนักงานขาย">พนักงานขาย</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>สถานะ</label>
                                                                <select class="form-control" name="status">
                                                                    <option value="{{$value->status}}">{{$value->status}}</option>
                                                                    <option value="เปิด">เปิด</option>
                                                                    <option value="ปิด">ปิด</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="{{$value->id}}">
                                                        <button type="submit" class="btn btn-primary">อัพเดตข้อมูล</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                            {{$sellers->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
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