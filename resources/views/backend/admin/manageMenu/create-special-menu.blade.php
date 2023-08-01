@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">อัพโหลดเมนูพิเศษ</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-special-menu')}}" enctype="multipart/form-data" method="post">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ร้านค้า</label>
                            @php
                                $stores = DB::table('stores')->get();
                            @endphp
                            <select class="form-control" name="store_id">
                                @foreach ($stores as $store => $value)
                                    <option value="{{$value->id}}">{{$value->name}} - {{$value->branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>หัวข้อเมนู (ถ้ามี)</label>
                            <input type="text" class="form-control form-control-sm" name="heading">
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดเพิ่มเติม (ถ้ามี)</label>
                            <input type="text" class="form-control form-control-sm" name="detail">
                        </div>
                        <div class="form-group">
                            <label for="image">รูปภาพเมนูพิเศษ</label>
                            @if ($errors->has('image'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('image') }})</span>
                            @endif
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">อัพโหลดรูปภาพเมนูพิเศษ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ร้านอาหาร</th>
                            <th>หัวข้อเมนู</th>
                            <th>รายละเอียดเพิ่มเติม</th>
                            <th>รูปภาพเมนูพิเศษ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($special_menus as $special_menu => $value)
                            @php
                                $store = DB::table('stores')->where('id',$value->store_id)->value('name');
                            @endphp
                            <tr>
                                <td>{{$NUM_PAGE*($page-1) + $special_menu+1}}</td>
                                <td>{{$store}}</td>
                                <td>{{$value->heading}}</td>
                                <td>{{$value->detail}}</td>
                                <td><img src="{{url('/image_upload/image_special_menu')}}/{{$value->image}}" class="img-responsive" height="40px;"></td>
                                <td>       
                                    <a data-toggle="modal" data-target="#EditSpecialMenu{{$value->id}}">
                                        <i class="fas fa-edit" style="color:blue;"></i>
                                    </a>        
                                    <a href="{{url('/admin/delete-special-menu/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="EditSpecialMenu{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขเมนูพิเศษ</h5>
                                        </div>
                                        <form action="{{url('/admin/update-special-menu')}}" enctype="multipart/form-data" method="post">@csrf
                                            <input type="hidden" name="id" value="{{$value->id}}">
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                @if(Session::has('alert-' . $msg))
                                                    <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                @endif
                                            @endforeach
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>หัวข้อเมนู (ถ้ามี)</label>
                                                        <input type="text" class="form-control form-control-sm" name="heading" value="{{$value->heading}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>รายละเอียดเพิ่มเติม (ถ้ามี)</label>
                                                        <input type="text" class="form-control form-control-sm" name="detail" value="{{$value->detail}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image">รูปภาพสไลด์</label>
                                                        <input type="file" class="form-control-file" id="image" name="image" value="{{$value->image}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">อัพเดตรูปภาพสไลด์</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    {{$special_menus->links()}}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection