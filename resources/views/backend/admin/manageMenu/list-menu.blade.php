@extends("/backend/layouts/template/template-admin")

@section("content")
@php
    $stores = DB::table('stores')->where('branch','!=','official')->get();
@endphp
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">รายการเมนูอาหาร</h2>
			</div>
		</div>
	</div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">เลือกร้านอาหาร เพื่อดูรายการเมนูอาหาร</h4>
                    
                </div>
                <div class="card-body">
                    <p class="demo">
                        @foreach ($stores as $store => $value)
                            <a href="{{url('/admin/list-menu')}}/{{$value->name}}-{{$value->branch}}" class="btn btn-primary btn-border">{{$value->name}} - {{$value->branch}}</a>
                        @endforeach
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
                <form action="{{url('/admin/search-menu')}}" enctype="multipart/form-data" method="post">@csrf
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
                                        <input type="text" placeholder="ค้นหาชื่อเมนู (ภาษาไทย)" class="form-control" name="thai_name">
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
                                        <input type="text" placeholder="ค้นหาชื่อเมนู (ภาษาอังกฤษ)" class="form-control" name="eng_name">
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
                                    <th>ร้านค้า</th>
                                    <th>ประเภทเมนู</th>
                                    <th>หมายเลขเมนู</th>
                                    <th>ชื่อเมนู (ภาษาไทย)</th>
                                    <th>ชื่อเมนู (ภาษาอังกฤษ)</th>
                                    <th>สถานะ</th>
                                    <th>สต๊อก</th>
                                    <th>รูปภาพ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($food_menus as $food_menu => $value)
                                @php
                                    $store_code = DB::table('stores')->where('id',$value->store_id)->value('code');
                                    $store_name = DB::table('stores')->where('id',$value->store_id)->value('name');
                                    $store_id = DB::table('stores')->where('id',$value->store_id)->value('id');
                                    $menu_type = DB::table('menu_types')->where('id',$value->menu_type_id)->value('menu_type');
                                    $menu_type_id = DB::table('menu_types')->where('id',$value->menu_type_id)->value('id');
                                    $image = DB::table('image_food_menus')->where('menu_id',$value->id)->value('image');
                                @endphp
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $food_menu+1}}</td>
                                        <td>{{$store_name}}</td>
                                        <td>{{$menu_type}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>{{$value->thai_name}}</td>
                                        <td>{{$value->eng_name}}</td>
                                        <td>{{$value->status}}</td>
                                        @if($value->stock == 'สินค้าหมด')
                                            <td style="color: red;">{{$value->stock}}</td>
                                        @else 
                                            <td>{{$value->stock}}</td>
                                        @endif
                                        <td><img src="{{url('/image_upload/image_food_menu')}}/{{$image}}" class="img-responsive" height="20px;"></td>
                                        <td>       
                                            <a data-toggle="modal" data-target="#EditMenu{{$value->id}}">
                                                <i class="fas fa-edit" style="color:blue;"></i>
                                            </a>        
                                            <a href="{{url('/admin/delete-food-menu/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="EditMenu{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขเมนูอาหาร</h5>
                                                </div>
                                                <form action="{{url('/admin/update-food-menu')}}" enctype="multipart/form-data" method="post">@csrf
                                                    <input type="hidden" name="id" value="{{$value->id}}">
                                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                        @if(Session::has('alert-' . $msg))
                                                            <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                        @endif
                                                    @endforeach
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ชื่อเมนู (ภาษาไทย)</label>
                                                                @if ($errors->has('thai_name'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('thai_name') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="thai_name" value="{{$value->thai_name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>ชื่อเมนู (ภาษาอังกฤษ)</label>
                                                                @if ($errors->has('eng_name'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('eng_name') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="eng_name" value="{{$value->eng_name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>รายละเอียดเพิ่มเติม (ถ้ามี)</label>
                                                                <textarea class="form-control" rows="3" name="detail">{{$value->detail}}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>สถานะ</label>
                                                                <select class="form-control" name="status">
                                                                    <option value="{{$value->status}}">{{$value->status}}</option>
                                                                    <option value="เปิด">เปิด</option>
                                                                    <option value="ปิด">ปิด</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>สต๊อก</label>
                                                                <select class="form-control" name="stock">
                                                                    <option value="{{$value->stock}}">{{$value->stock}}</option>
                                                                    <option value="มีสินค้า">มีสินค้า</option>
                                                                    <option value="สินค้าหมด">สินค้าหมด</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="image">รูปภาพเมนูอาหาร</label>
                                                                @if ($errors->has('image'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('image') }})</span>
                                                                @endif
                                                                <input type="file" class="form-control-file" id="image" name="image" value="{{$image}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>ร้านค้า</label>
                                                                <select class="form-control" name="store_id">
                                                                    <option value="{{$store_id}}">{{$store_code}} - {{$store_name}}</option>
                                                                    @php
                                                                        $stores = DB::table('stores')->get();
                                                                    @endphp
                                                                    @foreach ($stores as $store => $value)
                                                                        <option value="{{$value->id}}">{{$value->code}} - {{$value->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>ประเภทเมนูอาหาร</label>
                                                                <select class="form-control" name="menu_type_id">
                                                                    <option value="{{$menu_type_id}}">{{$menu_type}}</option>
                                                                    @php
                                                                        $menu_types = DB::table('menu_types')->get();
                                                                    @endphp
                                                                    @foreach ($menu_types as $menu_type => $value)
                                                                        <option value="{{$value->id}}">{{$value->menu_type}}</option> 
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">อัพเดตข้อมูล</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                            {{$food_menus->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection