@extends('/backend/layouts/template/template-admin')

@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">จัดการข้อมูลร้านค้า</h2>
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
                                        <th>รหัสร้านค้า</th>
                                        <th>ชื่อร้านค้า</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>ที่อยู่ร้านค้า</th>
                                        <th>สถานะ</th>
                                        <th>โลโก้</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $store => $value)
                                        <tr>
                                            <td>{{ $NUM_PAGE * ($page - 1) + $store + 1 }}</td>
                                            <td>{{ $value->code }}</td>
                                            <td>{{ $value->name }} {{ $value->branch }}</td>
                                            <td>{{ $value->phone }}</td>
                                            <td>{{ $value->address }}</td>
                                            <td>{{ $value->status }}</td>
                                            <td><img src="{{ url('/image_upload/image_store_logo') }}/{{ $value->logo }}"
                                                    class="img-responsive" height="20px;"></td>
                                            <td>
                                                <a data-toggle="modal" data-target="#EditStore{{ $value->id }}">
                                                    <i class="fas fa-edit" style="color:blue;"></i>
                                                </a>
                                                <a href="{{ url('/admin/delete-store/') }}/{{ $value->id }}"
                                                    onclick="return confirm('Are you sure to delete ?')">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="EditStore{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="Title" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            แก้ไขข้อมูลร้านค้า</h5>
                                                    </div>
                                                    <form action="{{ url('/admin/update-store') }}"
                                                        enctype="multipart/form-data" method="post">@csrf
                                                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                                            @if (Session::has('alert-' . $msg))
                                                                <p class="alertdesign alert alert-{{ $msg }}">
                                                                    {{ Session::get('alert-' . $msg) }} <a href="#"
                                                                        class="close" data-dismiss="alert"
                                                                        aria-label="close">&times;</a></p>
                                                            @endif
                                                        @endforeach
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>รหัสร้านค้า</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" name="code"
                                                                        value="{{ $value->code }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ชื่อร้านค้า</label>
                                                                    @if ($errors->has('name'))
                                                                        <span class="text-danger"
                                                                            style="font-size: 16px;">({{ $errors->first('name') }})</span>
                                                                    @endif
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" name="name"
                                                                        value="{{ $value->name }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>หมายเลขโทรศัพท์</label>
                                                                    @if ($errors->has('phone'))
                                                                        <span class="text-danger"
                                                                            style="font-size: 16px;">({{ $errors->first('phone') }})</span>
                                                                    @endif
                                                                    <input type="text"
                                                                        class="phone_format form-control form-control-sm"
                                                                        name="phone" value="{{ $value->phone }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ที่อยู่ร้านค้า</label>
                                                                    @if ($errors->has('address'))
                                                                        <span class="text-danger"
                                                                            style="font-size: 16px;">({{ $errors->first('address') }})</span>
                                                                    @endif
                                                                    <textarea class="form-control" rows="3" name="address">{{ $value->address }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>สาขา</label>
                                                                    <textarea class="form-control" rows="3" name="branch">{{ $value->branch }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>FACEBOOK NAME</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" name="facebook"
                                                                        value="{{ $value->facebook }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>FACEBOOK URL</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="facebook_url"
                                                                        value="{{ $value->facebook_url }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>INSTAGRAM NAME</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="instagram" value="{{ $value->instagram }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>INSTAGRAM URL</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="instagram_url"
                                                                        value="{{ $value->instagram_url }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>LINE</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" name="line"
                                                                        value="{{ $value->line }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>LINE URL</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="line_url" value="{{ $value->line_url }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>MAIL</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mail" value="{{ $value->mail }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>สถานะ</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="{{ $value->status }}">
                                                                            {{ $value->status }}</option>
                                                                        <option value="เปิด">เปิด</option>
                                                                        <option value="ปิด">ปิด</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="logo">รูปภาพโลโก้ร้านค้า</label>
                                                                    @if ($errors->has('logo'))
                                                                        <span class="text-danger"
                                                                            style="font-size: 16px;">({{ $errors->first('logo') }})</span>
                                                                    @endif
                                                                    <input type="file" class="form-control-file"
                                                                        id="logo" name="logo"
                                                                        value="{{ $value->logo }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id"
                                                                value="{{ $value->id }}">
                                                            <button type="submit"
                                                                class="btn btn-primary">อัพเดตข้อมูล</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">ปิด</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                {{ $stores->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('https://code.jquery.com/jquery-3.2.1.min.js') }}"></script>
    <script>
        // number phone
        function phoneFormatter() {
            $('input.phone_format').on('input', function() {
                var number = $(this).val().replace(/[^\d]/g, '')
                if (number.length >= 5 && number.length < 10) {
                    number = number.replace(/(\d{3})(\d{2})/, "$1-$2");
                } else if (number.length >= 10) {
                    number = number.replace(/(\d{3})(\d{3})(\d{3})/, "$1-$2-$3");
                }
                $(this).val(number)
                $('input.phone_format').attr({
                    maxLength: 12
                });
            });
        };
        $(phoneFormatter);
    </script>
@endsection
