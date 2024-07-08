@extends("/backend/layouts/template/template-seller")

@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">คูปองเงินสด</h2>
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
                                        <th>หมายเลขคูปอง</th>
                                        <th>จำนวนเงิน (บาท)</th>
                                        <th>ร้านค้า</th>
                                        <th>วันที่ออกคูปอง</th>
                                        <th>วันที่ใช้งานคูปอง</th>
                                        <th>สถานะ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $voucher => $value)
                                        @php
                                            $name = DB::table('stores')
                                                ->where('id', $value->branch_id)
                                                ->value('name');
                                            $branch = DB::table('stores')
                                                ->where('id', $value->branch_id)
                                                ->value('branch');
                                        @endphp
                                        <tr>
                                            <td>{{ $NUM_PAGE * ($page - 1) + $voucher + 1 }}</td>
                                            <td>{{ $value->serialnumber }}</td>
                                            <td>{{ $value->amount }}</td>
                                            <td>{{ $name }} {{ $branch }}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ $value->date }}</td>
                                            @if ($value->status == 'พร้อมใช้งาน')
                                                <td>{{ $value->status }}</td>
                                            @elseif($value->status == 'ยังไม่เปิดใช้งาน')
                                                <td style="color:red;">{{ $value->status }}</td>
                                            @elseif($value->status == 'ใช้งานแล้ว')
                                                <td style="color: green;">{{ $value->status }}</td>
                                            @endif
                                            <td>
                                                <a data-toggle="modal" data-target="#updateStatus{{ $value->id }}">
                                                    <i class="fas fa-edit" style="color:#31CE36;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="updateStatus{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="Title" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            แก้ไขคูปองเงินสด</h5>
                                                    </div>
                                                    <form action="{{ url('/seller/update-voucher') }}"
                                                        enctype="multipart/form-data" method="post">@csrf
                                                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                            @if (Session::has('alert-' . $msg))
                                                                <p class="alertdesign alert alert-{{ $msg }}">
                                                                    {{ Session::get('alert-' . $msg) }} <a href="#"
                                                                        class="close" data-dismiss="alert"
                                                                        aria-label="close">&times;</a></p>
                                                            @endif
                                                        @endforeach
                                                        @php
                                                            $serialnumber = $value->serialnumber;
                                                            $creator = $value->creator;
                                                            $status = $value->status;
                                                            $id = $value->id;
                                                            $amount = $value->amount;
                                                        @endphp
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    @php
                                                                        $stores = DB::table('stores')->get();
                                                                    @endphp
                                                                    <label>ร้านค้า</label>
                                                                    <select class="form-control" name="branch_id">
                                                                        @foreach ($stores as $store => $value)
                                                                            <option value="{{ $value->id }}">
                                                                                {{ $value->name }} {{ $value->branch }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>หมายเลขบัตร</label>
                                                                    <input type="text" class="form-control"
                                                                        name="serialnumber" value="{{ $serialnumber }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>จำนวนเงิน (บาท)</label>
                                                                    @if ($errors->has('amount'))
                                                                        <span class="text-danger"
                                                                            style="font-size: 16px;">({{ $errors->first('amount') }})</span>
                                                                    @endif
                                                                    <input type="text" class="form-control"
                                                                        name="amount" value="{{$amount}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ผู้ออกคูปองส่วนลด</label>
                                                                    <input type="text" class="form-control"
                                                                        name="creator" value="{{ $creator }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>สถานะ</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="{{ $status }}">
                                                                            {{ $status }}</option>
                                                                        <option value="พร้อมใช้งาน">พร้อมใช้งาน</option>
                                                                        <option value="ยังไม่เปิดใช้งาน">ยังไม่เปิดใช้งาน
                                                                        </option>
                                                                        <option value="ใช้งานแล้ว">ใช้งานแล้ว
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">อัพเดตข้อมูลคูปองเงินสด</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                {{ $vouchers->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
