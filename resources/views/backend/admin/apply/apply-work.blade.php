@extends('/backend/layouts/template/template-admin')

@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">รายชื่อรับสมัครงาน</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                @php
                    $branchs = DB::table('url_apply_works')->get();
                @endphp
                @foreach ($branchs as $branch => $value)
                    <a href="{{ url('admin/apply-work') }}/{{ $value->url_name }}"
                        class="btn btn-primary mt-2">{{ $value->branch_name }}</a>
                @endforeach
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>สาขาที่สมัคร</th>
                                        <th>หมายเลขบัตรประชาชน</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>อายุ</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>ตำแหน่ง</th>
                                        <th>เงินเดือนที่ต้องการ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($apply_works as $apply_work => $value)
                                        @php
                                            $branch_name = DB::table('url_apply_works')
                                                ->where('id', $value->branch_id)
                                                ->value('branch_name');
                                            $count_unique = DB::table('apply_works')->where('card_id',$value->card_id)->groupBy('card_id')->count('card_id');
                                        @endphp
                                        <tr>
                                            @if($count_unique > 1 && $value->card_id != NULL)
                                                <td style="color: red;">{{ $NUM_PAGE * ($page - 1) + $apply_work + 1 }}</td>
                                                <td style="color: red;">{{ $branch_name }}</td>
                                                <td style="color: red;">{{ $value->card_id }}</td>
                                                <td style="color: red;">{{ $value->name }} {{ $value->surname }}</td>
                                                <td style="color: red;">{{ $value->age }} ปี</td>
                                                <td style="color: red;">{{ $value->tel }}</td>
                                                <td style="color: red;">{{ $value->position }}</td>
                                                <td style="color: red;">{{ $value->salary }}</td>
                                            @else
                                                <td>{{ $NUM_PAGE * ($page - 1) + $apply_work + 1 }}</td>
                                                <td>{{ $branch_name }}</td>
                                                <td>{{ $value->card_id }}</td>
                                                <td>{{ $value->name }} {{ $value->surname }}</td>
                                                <td>{{ $value->age }} ปี</td>
                                                <td>{{ $value->tel }}</td>
                                                <td>{{ $value->position }}</td>
                                                <td>{{ $value->salary }}</td>
                                            @endif
                                            
                                            <td>
                                                <a type="button" data-toggle="modal"
                                                    data-target="#ModalMore{{ $value->id }}" style="color:blue;">
                                                    ดูข้อมูลเพิ่มเติม
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="ModalMore{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">ข้อมูลผู้สมัคร</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-6 mt-2" style="text-align: center;">
                                                                        <img src="{{ url('file_upload/image') }}/{{ $value->image }}"
                                                                            class="img-responsive" width="100%">
                                                                    </div>
                                                                    <div class="col-md-6 mt-2" style="text-align: center;">
                                                                        <img src="{{ url('file_upload/facebook') }}/{{ $value->facebook }}"
                                                                            class="img-responsive" width="100%">
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-5">
                                                                    <div class="col-md-12" style="text-align: center;">
                                                                        <label>สาขาที่สมัคร : {{ $branch_name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12" style="text-align: center;">
                                                                        <label>สมัครงานในตำแหน่ง :
                                                                            {{ $value->position }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12" style="text-align: center;">
                                                                        <label>เงินเดือนที่ต้องการ : {{ $value->salary }}
                                                                            บาท/เดือน</label>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <legend class="scheduler-border">
                                                                    <strong>ประวัติส่วนตัว</strong>
                                                                </legend>
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <label>ชื่อ-นามสกุล : {{ $value->name }}
                                                                            {{ $value->surname }}</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>อายุ (ปี) : {{ $value->age }}</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>เบอร์โทรศัพท์ : {{ $value->tel }} </label>
                                                                    </div>
                                                                </div><br>
                                                                <legend class="scheduler-border">
                                                                    <strong>ประสบการณ์การทำงาน</strong>
                                                                </legend>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <p>{{ $value->history_work }}</p>
                                                                    </div>
                                                                </div><br>
                                                                {{-- <center><img src="{{url('apply/little_edo/resume')}}/{{$value->resume}}" class="img-responsive" width="40%"></center> --}}
                                                                <center><a
                                                                        href="{{ url('/admin/open-pdfResume') }}/{{ $value->id }}"
                                                                        class="kanit btn btn-primary"
                                                                        target="_blank">เปิดไฟล์เอกสาร</a></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ปิด</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                {{ $apply_works->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
