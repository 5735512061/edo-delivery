@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">จัดการข้อมูลลูกค้า</h2>
			</div>
		</div>
	</div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{url('/admin/search-data-customer')}}" enctype="multipart/form-data" method="post">@csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="navbar-left navbar-form nav-search mr-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-search pr-1">
                                                <i class="fa fa-search search-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text" placeholder="ค้นหาตามชื่อ" class="form-control" name="name">
                                    </div>
                                </div><br>
                            </div>
                            <div class="col-md-3">
                                <div class="navbar-left navbar-form nav-search mr-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-search pr-1">
                                                <i class="fa fa-search search-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text" placeholder="ค้นหาเบอร์โทรศัพท์" class="form-control" name="phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสสมาชิก</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>วันที่ลงทะเบียน</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer => $value)
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $customer+1}}</td>
                                        <td>{{$value->customer_code}}</td>
                                        <td>{{$value->name}} {{$value->surname}}</td>
                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->date}}</td>
                                        <td>       
                                            <a data-toggle="modal" data-target="#EditCustomer{{$value->id}}">
                                                <i class="fas fa-edit" style="color:blue;"></i>
                                            </a>        
                                            <a href="{{url('/admin/delete-customer/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="EditCustomer{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูลลูกค้า</h5>
                                                </div>
                                                <form action="{{url('/admin/update-customer')}}" enctype="multipart/form-data" method="post">@csrf
                                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                        @if(Session::has('alert-' . $msg))
                                                            <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                        @endif
                                                    @endforeach
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>รหัสสมาชิก</label>
                                                                <input type="text" class="form-control form-control-sm" name="customer_code" value="{{$value->customer_code}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>ชื่อ</label>
                                                                @if ($errors->has('name'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('name') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="name" value="{{$value->name}}">
                                                            </div>
															<div class="form-group">
                                                                <label>นามสกุล</label>
                                                                @if ($errors->has('surname'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('surname') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="surname" value="{{$value->surname}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>หมายเลขโทรศัพท์</label>
                                                                @if ($errors->has('phone'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('phone') }})</span>
                                                                @endif
                                                                <input type="text" class="phone_format form-control form-control-sm" name="phone" value="{{$value->phone}}">
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
                            {{$customers->links()}}
                        </table>
                    </div>
                </div>
            </div>
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