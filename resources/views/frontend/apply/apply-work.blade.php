@extends('/frontend/layouts/template/template')
<style>
    .top-buffer-1 {
        margin-top: 20px;
    }

    .top-buffer {
        margin-top: 2px;
    }

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: auto;
        padding: 0 1px;
        border-bottom: none;
    }

    .login-wrapper {
        width: 100%;
        height: 100%;
        position: absolute;
        display: table;
        z-index: 2;
    }

    .note {
        text-align: center;
        height: 80px;
        background-color: #000;
        color: #fff;
        font-weight: bold;
        line-height: 80px;
    }

    .note p {
        font-size: 24px;
        color: #fff;
    }

    .form-content {
        padding: 5%;
        border: 1px solid #ced4da;
        margin-bottom: 2%;
    }

    .form-control {
        border-radius: 1.5rem;
    }

    .bk {
        background-color: white;
    }

    .selectOption {
        font-size: 1.3rem !important;
        height: calc(2.5rem + 2px) !important;
    }

    label {
        font-weight: 500 !important;
    }

    .fileUpload {
        font-size: 1rem !important;
    }
</style>
@section('content')
    @php
        $branch = DB::table('url_apply_works')
            ->where('url_name', $branch_name)
            ->value('branch_name');
        $branch_id = DB::table('url_apply_works')
            ->where('url_name', $branch_name)
            ->value('id');
    @endphp
    <hr>
    <center>
        <h1>สมัครงานในเครือ Edo Group</h1>
    </center>
    <center>
        <h2>{{ $branch }}</h2>
    </center>
    <div class="container register-form top-buffer-1">
        <div class="form">
            <div class="note prompt">
                <p style="font-size: 24px; font-weight:normal;">ร่วมเป็นส่วนหนึ่งกับเรา</p>
            </div>
            <div class="form-content bk">
                <form action="{{ url('/apply-work') }}" enctype="multipart/form-data" method="post">@csrf
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if (Session::has('alert-' . $msg))
                                <p class="kanit alertdesign alert alert-{{ $msg }}">
                                    {{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                                        data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                    </div>
                    <fieldset class="scheduler-border kanit">
                        <div class="row">
                            <div class="col-md-3"><br>
                                @if ($errors->has('position'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('position') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>สมัครงานในตำแหน่ง</label>
                                <select class="form-control" name="position"
                                    style="border-radius: 4px; margin:8px 0; font-family:'Mitr' !important;">
                                    <option></option>
                                    <option>ผู้จัดการร้าน</option>
                                    <option>เชฟ</option>
                                    <option>ผู้ช่วยเชฟ</option>
                                    <option>บาร์น้ำ</option>
                                    <option>พนักงานเสิร์ฟ</option>
                                </select>
                            </div>
                            <div class="col-md-3"><br>
                                @if ($errors->has('salary'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('salary') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>เงินเดือนที่ต้องการ (บาท/เดือน)</label>
                                <input type="text" class="form-control" name="salary" value="{{ old('salary') }}">
                            </div>
                        </div><br>
                    </fieldset>
                    {{-- ประวัติส่วนตัว --}}
                    <fieldset class="scheduler-border kanit">
                        <legend class="scheduler-border">ประวัติส่วนตัว</legend>
                        <div class="row">
                            <div class="col-md-6">
                                @if ($errors->has('card_id'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('card_id') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>หมายเลขบัตรประชาชน</label>
                                <input type="text" class="form-control" name="card_id" value="{{ old('card_id') }}">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-3">
                                @if ($errors->has('name'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('name') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>ชื่อ</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="col-md-3">
                                @if ($errors->has('surname'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('surname') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>นามสกุล</label>
                                <input type="text" class="form-control" name="surname" value="{{ old('surname') }}">
                            </div>
                            <div class="col-md-2">
                                @if ($errors->has('age'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('age') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>อายุ (ปี)</label>
                                <input type="text" class="form-control" name="age" value="{{ old('age') }}">
                            </div>
                            <div class="col-md-3">
                                @if ($errors->has('tel'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('tel') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>เบอร์โทรศัพท์</label>
                                <input type="text" class="phone_format form-control" name="tel"
                                    value="{{ old('tel') }}">
                            </div>
                        </div>
                    </fieldset>
                    {{-- ประวัติการทำงาน --}}
                    <fieldset class="scheduler-border kanit">
                        <legend class="scheduler-border">ประวัติการทำงาน</legend>
                        <div class="row">
                            <div class="col-md-12">
                                @if ($errors->has('history_work'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('history_work') }})</span><br>
                                @endif
                                <textarea name="history_work" rows="4" class="form-control"
                                    style="border-radius: 4px; margin:8px 0; font-family:'Mitr' !important;"
                                    placeholder="ตัวอย่าง : 1. พนักงานเสิร์ฟ ร้านอาหาร ระยะเวลา 2 ปี" value="{{ old('history_work') }}"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    {{-- แนบไฟล์เอกสาร --}}
                    <fieldset class="scheduler-border kanit">
                        <legend class="scheduler-border">แนบไฟล์เอกสาร</legend>
                        <div class="row">
                            <div class="col-md-4">
                                @if ($errors->has('performance'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('performance') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>อัพโหลดไฟล์เอกสาร ผลงาน</label>
                                <input type="file" class="form-control fileUpload" name="performance"
                                    style="border-radius: 4px; margin:8px 0;" value="{{ old('performance') }}">
                            </div>
                            <div class="col-md-4">
                                @if ($errors->has('facebook'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('facebook') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>แคปภาพหน้า Facebook ให้ติดชื่อเฟส</label>
                                <input type="file" class="form-control fileUpload" name="facebook"
                                    style="border-radius: 4px; margin:8px 0;" value="{{ old('facebook') }}">
                            </div>
                            <div class="col-md-4">
                                @if ($errors->has('image'))
                                    <span class="text-danger"
                                        style="font-size: 15px;">({{ $errors->first('image') }})</span><br>
                                @endif
                                <label style="color: red;">*</label><label>รูปถ่ายปัจจุบัน</label>
                                <input type="file" class="form-control fileUpload" name="image"
                                    style="border-radius: 4px; margin:8px 0;" value="{{ old('image') }}">
                            </div>
                        </div>
                    </fieldset>
                    {{-- ข้อตกลง --}}
                    <fieldset class="scheduler-border kanit">
                        <legend class="scheduler-border">ข้อตกลง</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    ข้าพเจ้าขอรับรองว่าข้อมูลดังกล่าวข้างต้นเป็นความจริงทุกประการ หลังจากบริษัทฯ
                                    จ้างเข้ามาทำงานแล้วปรากฎว่า ข้อมูลข้างต้น หรือรายละเอียดที่ให้ไว้ไม่เป็นความจริง
                                    บริษัทฯ มีสิทธิ์ที่จะเลิกจ้างข้าพเจ้าได้โดยไม่ต้องจ่ายเงินชดเชยหรือค่าเสียหายใดๆทั้งสิ้น
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    {{-- สมัครงาน --}}
                    <center>
                        <div class="kanit">
                            <input type="hidden" name="branch_id" value="{{ $branch_id }}">
                            <input type="checkbox" id="checkme" /> ยอมรับข้อตกลง<br><br>
                            <button type="submit" class="btn btn-warning" value="submit"
                                style="font-family:'Mitr' !important; color:#fff; background-color:#CE7F5C; font-size:16px; border-color:#CE7F5C;"
                                disabled="disabled" id="sendNewSms">ส่งแบบฟอร์มสมัครงาน</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('https://code.jquery.com/jquery-3.2.1.min.js') }}"></script>
    <script>
        var checker = document.getElementById('checkme');
        var sendbtn = document.getElementById('sendNewSms');
        // when unchecked or checked, run the function
        checker.onchange = function() {
            if (this.checked) {
                sendbtn.disabled = false;
            } else {
                sendbtn.disabled = true;
            }
        }
    </script>

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
