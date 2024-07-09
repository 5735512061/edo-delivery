@extends('/backend/layouts/template/template-seller')

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
            <div class="col-md-4">
                <div class="card">
                    <form action="{{ url('/seller/search-voucher') }}" enctype="multipart/form-data" method="post">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="navbar-left navbar-form nav-search mr-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-search pr-1">
                                                    <i class="fa fa-search search-icon"></i>
                                                </button>
                                            </div>
                                            <input id="ssn1" maxlength="19" minlength="19" type="text"
                                                placeholder="ค้นหาหมายเลขคูปอง" class="form-control" name="serialnumber">
                                        </div>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                                        <th>สาขาที่ใช้</th>
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
                                            $store_id = DB::table('sellers')
                                                ->where('id', $value->staff_branch_id)
                                                ->value('store_id');
                                            $store_name = DB::table('stores')->where('id', $store_id)->value('name');
                                            $store_branch = DB::table('stores')
                                                ->where('id', $store_id)
                                                ->value('branch');
                                            $amount_format = number_format($value->amount);
                                        @endphp
                                        <tr>
                                            <td>{{ $NUM_PAGE * ($page - 1) + $voucher + 1 }}</td>
                                            <td>{{ $value->serialnumber }}</td>
                                            <td>{{ $amount_format }}</td>
                                            <td>{{ $name }} {{ $branch }}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ $value->date }}</td>
                                            <td>{{ $store_name }} {{ $store_branch }}</td>
                                            @if ($value->status == 'พร้อมใช้งาน')
                                                <td>{{ $value->status }}</td>
                                            @elseif($value->status == 'ยังไม่เปิดใช้งาน')
                                                <td style="color:red;">{{ $value->status }}</td>
                                            @elseif($value->status == 'ใช้งานแล้ว')
                                                <td style="color: green;">{{ $value->status }}</td>
                                            @endif
                                            @if ($value->status == 'ใช้งานแล้ว')
                                            <td></td>
                                            @else
                                                <td>
                                                    <a data-toggle="modal" data-target="#updateStatus{{ $value->id }}">
                                                        <i class="fas fa-edit" style="color:#31CE36;"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="updateStatus{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="Title" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            ยืนยันการใช้คูปองเงินสด</h5>
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
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>ร้านค้า</label>
                                                                    <input type="text" class="form-control"
                                                                        name="serialnumber"
                                                                        value="{{ $name }} {{ $branch }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>หมายเลขบัตร</label>
                                                                    <input type="text" class="form-control"
                                                                        name="serialnumber"
                                                                        value="{{ $value->serialnumber }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>จำนวนเงิน (บาท)</label>
                                                                    @if ($errors->has('amount'))
                                                                        <span class="text-danger"
                                                                            style="font-size: 16px;">({{ $errors->first('amount') }})</span>
                                                                    @endif
                                                                    <input type="text" class="form-control"
                                                                        name="amount" value="{{ $amount_format }}"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ผู้ออกคูปองส่วนลด</label>
                                                                    <input type="text" class="form-control"
                                                                        name="creator" value="{{ $value->creator }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $value->id }}">
                                                                    <input type="hidden" name="status" value="ใช้งานแล้ว">
                                                                    <input type="hidden" name="staff_branch_id"
                                                                        value="{{ Auth::guard('seller')->user()->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">ยืนยันการใช้คูปองเงินสด</button>
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
    <script type="text/javascript" src="{{ asset('https://code.jquery.com/jquery-3.2.1.min.js') }}"></script>
    <script>
        // serial number
        $('#ssn1').keyup(function() {
            var val = this.value.replace(/\D/g, '');
            var newVal = '';
            while (val.length > 4) {
                newVal += val.substr(0, 4) + '-';
                val = val.substr(4);
            }
            newVal += val;
            this.value = newVal;
        });
    </script>
@endsection
