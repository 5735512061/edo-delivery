@extends("/backend/layouts/template/template-admin")

@section("content")
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">อัพโหลด Blog</h2>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{url('/admin/create-blog')}}" enctype="multipart/form-data" method="post">@csrf
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
                                $stores = DB::table('stores')->where('branch','=','official')->get();
                            @endphp
                            <select class="form-control" name="store_id">
                                @foreach ($stores as $store => $value)
                                    <option value="{{$value->id}}">{{$value->name}} - {{$value->branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>หัวข้อบทความ</label>
                            @if ($errors->has('title'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('title') }})</span>
                            @endif
                            <input type="text" class="form-control form-control-sm" name="title">
                        </div>
                        <div class="form-group">
                            <label>รายละเอียด</label>
                            <textarea name="detail" class="ckeditor form-control form-control-sm" rows="5"></textarea>
                        </div> 
                        <div class="form-group">
                            <label for="image">รูปภาพ</label>
                            @if ($errors->has('image'))
                                <span class="text-danger" style="font-size: 16px;">({{ $errors->first('image') }})</span>
                            @endif
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">อัพโหลด Blog</button>
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
                            <th>หัวข้อบทความ</th>
                            <th>รูปภาพ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog => $value)
                            @php
                                $store = DB::table('stores')->where('id',$value->store_id)->value('name');
                                $branch = DB::table('stores')->where('id',$value->store_id)->value('branch');
                            @endphp
                            <tr>
                                <td>{{$NUM_PAGE*($page-1) + $blog+1}}</td>
                                <td>{{$store}} - {{$branch}}</td>
                                <td>{{$value->title}}</td>
                                <td><img src="{{url('/image_upload/image_blog')}}/{{$value->image}}" class="img-responsive" height="20px;"></td>
                                <td>       
                                    <a data-toggle="modal" data-target="#EditBlog{{$value->id}}">
                                        <i class="fas fa-edit" style="color:blue;"></i>
                                    </a>        
                                    <a href="{{url('/admin/delete-blog/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="EditBlog{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">แก้ไข Blog</h5>
                                        </div>
                                        <form action="{{url('/admin/update-blog')}}" enctype="multipart/form-data" method="post">@csrf
                                            <input type="hidden" name="id" value="{{$value->id}}">
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                @if(Session::has('alert-' . $msg))
                                                    <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                                @endif
                                            @endforeach
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>หัวข้อบทความ</label>
                                                        <input type="text" class="form-control form-control-sm" name="thai_name" value="{{$value->title}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>รายละเอียด</label>
                                                        <textarea name="detail" class="form-control form-control-sm" rows="5">{{$value->detail}}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image">รูปภาพ</label>
                                                        <input type="file" class="form-control-file" id="image" name="image" value="{{$value->image}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">อัพเดต Blog</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    {{$blogs->links()}}
                </table>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });
</script>
@endsection