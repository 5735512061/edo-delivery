@extends("/backend/layouts/template/template-admin")

@section("content")
@php
    $stores = DB::table('stores')->get();
@endphp
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">ข้อความติดต่อ</h2>
			</div>
		</div>
	</div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">เลือกร้านอาหาร เพื่อดูข้อความติดต่อ</h4>
                    
                </div>
                <div class="card-body">
                    <p class="demo">
                        @foreach ($stores as $store => $value)
                            @php
                                $message = DB::table('contacts')->where('answer_message', NULL)->where('store_id',$value->id)->count();
                            @endphp
                            <a href="{{url('/admin/message')}}/{{$value->name}}-{{$value->branch}}" class="btn btn-primary btn-border">{{$value->name}} - {{$value->branch}} [ {{$message}} ]</a>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>วันที่ติดต่อ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>หัวข้อเรื่อง</th>
                                    <th>ข้อความ</th>
                                    <th>ข้อความตอบกลับ</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $message => $value)
                                    @php
                                        $name = DB::table('customers')->where('id',$value->customer_id)->value('name');
                                        $surname = DB::table('customers')->where('id',$value->customer_id)->value('surname');
                                    @endphp
                                    <tr>
                                        <td>{{$NUM_PAGE*($page-1) + $message+1}}</td>
                                        <td>{{ $value->created_at->format('Y-m-d') }}</td>
                                        @if($name == null)
                                            <td style="color: red;">ไม่ใช่สมาชิก</td>
                                        @else 
                                            <td>{{$name}} {{$surname}}</td>
                                        @endif
                                        <td>{{$value->tel}}</td>
                                        <td>{{$value->subject}}</td>
                                        <td>
                                            <a type="button" data-toggle="modal" data-target="#ModalMessage{{$value->id}}" style="color:blue;">
                                                ดูข้อความ
                                            </a>
                                        </td>
                                        <td>
                                            <a type="button" data-toggle="modal" data-target="#ModalAnswer{{$value->id}}" style="color:blue;">
                                                ดูข้อความตอบกลับ
                                            </a>
                                        </td>
                                        @if($value->answer_message == null)
                                        <td style="color:red; font-size:15px;">รอการตอบกลับ</td> 
                                        @else
                                            <td style="color:green; font-size:15px;">ตอบแล้ว</td>
                                        @endif  
                                        <td>  
                                            <a type="button" data-toggle="modal" data-target="#ModalStatus{{$value->id}}">
                                                <i class="fa fa-pencil-square-o" style="color:blue; font-family: 'Mitr','FontAwesome';"> ตอบกลับ</i>
                                            </a>  
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="ModalStatus{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">ตอบกลับข้อความ</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{url('/admin/answer-message')}}" enctype="multipart/form-data" method="post">@csrf
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <textarea name="answer_message" cols="50" rows="5" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="{{$value->id}}">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">ตอบกลับข้อความ</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="ModalMessage{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">ข้อความที่ติดต่อ</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <textarea cols="50" rows="5" class="form-control">{{$value->message}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="ModalAnswer{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">ข้อความตอบกลับ</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <textarea cols="50" rows="5" class="form-control">{{$value->answer_message}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                            {{$messages->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection