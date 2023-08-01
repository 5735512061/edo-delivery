@extends("/frontend/layouts/template/template")

@section("content")
<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">ประวัติการติดต่อสอบถาม<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h2>
            </div>
        </div>   		
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table" style="min-width: 1000px !important;">
                        <thead class="thead-primary">
                        <tr class="text-center">
                            <th>#</th>
                            <th>วันที่ติดต่อ</th>
                            <th>หัวข้อเรื่อง</th>
                            <th>ข้อความติดต่อ</th>
                            <th>ข้อความตอบกลับ</th>
                            <th>สถานะ</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message => $value)
                            <tr>
                                <td scope="row">{{$NUM_PAGE*($page-1) + $message+1}}</td>
                                <td>{{ $value->created_at->format('Y-m-d') }}</td>
                                <td>{{$value->subject}}</td>
                                <td>
                                    <a type="button" data-toggle="modal" data-target="#ModalMessage{{$value->id}}">
                                        <span style="color:blue; font-family: 'Mitr' !important;"> ดูข้อความ</span>
                                    </a>
                                </td>
                                <td>
                                    <a type="button" data-toggle="modal" data-target="#ModalAnswer{{$value->id}}">
                                        <span style="color:blue; font-family: 'Mitr' !important;"> ดูข้อความตอบกลับ</span> 
                                    </a>
                                </td>
                                @if($value->answer_message == null)
                                    <td style="color:red; font-size:15px;">รอการตอบกลับ</td> 
                                @else
                                    <td style="color:green; font-size:15px;">ตอบแล้ว</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
@foreach($messages as $message => $value)
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
                        <textarea cols="50" rows="5" class="form-control" style="font-family: 'Mitr'; font-size:14px;">{{$value->message}}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-family: 'Mitr';">ปิด</button>
            </div>
        </div>
    </div>
</div>
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
                        <textarea cols="50" rows="5" class="form-control" style="font-family: 'Mitr'; font-size:14px;">{{$value->answer_message}}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-family: 'Mitr';">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection