@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">ประเภทเมนูอาหาร</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-menu-type')}}" enctype="multipart/form-data" method="post">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ร้านอาหาร</label>
                            <select class="form-control" name="store_id">
                                @php
                                    $stores = DB::table('stores')->get();
                                @endphp
                                @foreach ($stores as $store => $value)
                                    <option value="{{$value->id}}">{{$value->name}} - {{$value->branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ประเภทเมนูอาหาร</label>
                            @if ($errors->has('menu_type'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('menu_type') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="menu_type">
                        </div>
                        <div class="form-group">
                            <label>ประเภทเมนูอาหาร (ภาษาอังกฤษ ไม่เว้นวรรค)</label>
                            @if ($errors->has('menu_type_eng'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('menu_type_eng') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="menu_type_eng">
                        </div>
                        <div class="form-group">
                            <label for="image">รูปภาพประเภทเมนูอาหาร</label>
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
                            <button type="submit" class="btn btn-primary">สร้างประเภทเมนูอาหาร</button>
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
                            <th>ประเภทเมนูอาหาร</th>
                            <th>ประเภทเมนูอาหาร</th>
                            <th>สถานะ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menu_types as $menu_type => $value)
                            @php
                                $store = DB::table('stores')->where('id',$value->store_id)->value('name');
                                $branch = DB::table('stores')->where('id',$value->store_id)->value('branch');
                            @endphp
                            <tr>
                                <td>{{$NUM_PAGE*($page-1) + $menu_type+1}}</td>
                                <td>{{$store}}-{{$branch}}</td>
                                <td>{{$value->menu_type}}</td>
                                <td>{{$value->menu_type_eng}}</td>
                                <td>{{$value->status}}</td>
                                <td>       
                                    <a data-toggle="modal" data-target="#EditMenuType{{$value->id}}">
                                        <i class="fas fa-edit" style="color:blue;"></i>
                                    </a>        
                                    <a href="{{url('/admin/delete-menu-type/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="EditMenuType{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขประเภทเมนูอาหาร</h5>
                                        </div>
                                        <form action="{{url('/admin/update-menu-type')}}" enctype="multipart/form-data" method="post">@csrf
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                @if(Session::has('alert-' . $msg))
                                                    <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                @endif
                                            @endforeach
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>ประเภทเมนูอาหาร</label>
                                                        @if ($errors->has('menu_type'))
                                                            <span class="text-danger" style="font-size: 16px;">({{ $errors->first('menu_type') }})</span>
                                                        @endif
                                                        <input type="text" class="form-control form-control-sm" name="menu_type" value="{{$value->menu_type}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>ประเภทเมนูอาหาร (ภาษาอังกฤษ ไม่เว้นวรรค)</label>
                                                        @if ($errors->has('menu_type_eng'))
                                                            <span class="text-danger" style="font-size: 16px;">({{ $errors->first('menu_type_eng') }})</span>
                                                        @endif
                                                        <input type="text" class="form-control form-control-sm" name="menu_type_eng" value="{{$value->menu_type_eng}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image">รูปภาพประเภทเมนูอาหาร</label>
                                                        @if ($errors->has('image'))
                                                            <span class="text-danger" style="font-size: 16px;">({{ $errors->first('image') }})</span>
                                                        @endif
                                                        <input type="file" class="form-control-file" id="image" name="image">
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
                                                <button type="submit" class="btn btn-primary">อัพเดตข้อมูลประเภทเมนูอาหาร</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    {{$menu_types->links()}}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection