@extends('/backend/layouts/template/template-admin')

@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">CHECKLIST AUDIT</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt-5">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/admin/create-form-checklist-audit') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if (Session::has('alert-' . $msg))
                            <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a
                                    href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                @php
                                    $stores = DB::table('stores')->get();
                                @endphp
                                <label>ร้านค้า</label>
                                <select class="form-control" name="branch_id">
                                    @foreach ($stores as $store => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }} {{ $value->branch }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>ข้อที่</label>
                                @if ($errors->has('number'))
                                    <span class="text-danger"
                                        style="font-size: 16px;">({{ $errors->first('number') }})</span>
                                @endif
                                <input type="text" class="form-control" name="number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>รายละเอียด</label>
                                @if ($errors->has('list'))
                                    <span class="text-danger" style="font-size: 16px;">({{ $errors->first('list') }})</span>
                                @endif
                                <input type="text" class="form-control" name="list">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>สถานะ</label>
                                <select class="form-control" name="status">
                                    <option value="เปิด">เปิด</option>
                                    <option value="ปิด">ปิด</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Hoverable Table rows -->
                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>สาขา</th>
                                    <th>ข้อที่</th>
                                    <th>รายละเอียด</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            @foreach ($checklists as $checklist => $value)
                                @php
                                    $name = DB::table('stores')->where('id',$value->branch_id)->value('name');
                                    $branch = DB::table('stores')->where('id',$value->branch_id)->value('branch');
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $NUM_PAGE * ($page - 1) + $checklist + 1 }}</td>
                                        <td>{{ $name }} {{ $branch }}</td>
                                        <td>{{ $value->number }}</td>
                                        <td>{{ $value->list }}</td>
                                        <td>{{ $value->status }}</td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <!--/ Hoverable Table rows -->
            </div>
        </div>
    </div>
@endsection
