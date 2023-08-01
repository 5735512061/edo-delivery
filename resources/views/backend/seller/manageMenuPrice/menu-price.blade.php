@extends("/backend/layouts/template/template-seller")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">รายการราคาอาหาร</h2>
			</div>
		</div>
	</div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{url('/seller/search-menu-price')}}" enctype="multipart/form-data" method="post">@csrf
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
                                    <th>ราคาอาหารล่าสุด</th>
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
                                    $price = DB::table('menu_prices')->where('menu_id',$value->id)->orderBy('id','desc')->value('price');
                                    $price_format = number_format($price);
                                @endphp
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $food_menu+1}}</td>
                                        <td>{{$store_code}} {{$store_name}}</td>
                                        <td>{{$menu_type}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>{{$value->thai_name}}</td>
                                        <td>{{$value->eng_name}}</td>
                                        @if($price == null)
                                            <td style="color: red;">0 บาท</td>
                                        @else 
                                            <td>{{$price_format}} บาท</td>
                                        @endif
                                        <td>       
                                            <a data-toggle="modal" data-target="#EditPrice{{$value->id}}">
                                                <i class="fas fa-edit" style="color:blue;"></i>
                                            </a>        
                                            <a href="{{url('/seller/menu-price-detail')}}/{{$value->id}}">
                                                <i class="fas fa-folder" style="color:blue;"></i>
                                            </a> 
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="EditPrice{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขราคาอาหาร</h5>
                                                </div>
                                                <form action="{{url('/seller/update-menu-price')}}" enctype="multipart/form-data" method="post">@csrf
                                                    <input type="hidden" name="id" value="{{$value->id}}">
                                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                        @if(Session::has('alert-' . $msg))
                                                            <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                        @endif
                                                    @endforeach
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ราคาอาหารล่าสุด</label>
                                                                @if ($errors->has('price'))
                                                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('price') }})</span>
                                                                @endif
                                                                <input type="text" class="form-control form-control-sm" name="price">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>สถานะ</label>
                                                                <select class="form-control" name="status">
                                                                    <option value="เปิด">เปิด</option>
                                                                    <option value="ปิด">ปิด</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="menu_id" value="{{$value->id}}">
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