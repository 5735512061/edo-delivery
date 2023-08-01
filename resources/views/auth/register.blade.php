@extends("/backend/layouts/template/template-admin-login")

@section("content")
<div class="container">
    <div class="row">
        <div class="col-sm-12"><br>
            <div class="card">
                <div class="card-block">
                    <form action="{{url('/register')}}" enctype="multipart/form-data" method="post">@csrf
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                        @php
                            $random = rand(1111,9999);  
                            $random_format = wordwrap($random , 4 , '-' , true );
                            $id = 'EDO-ADMIN-'.$random_format;
                            
                            $admin_code = DB::table('admins')->where('admin_code',$id)->value('admin_code');
                                if($admin_code == null) {
                                    $id_gen = $id;
                                } else {
                                    $random = rand(111111,999999);  
                                    $random_format = wordwrap($random , 4 , '-' , true );
                                    $id_gen = 'EDO-ADMIN-'.$random_format;
                                }
                        @endphp
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('รหัสผู้ดูแลระบบ') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('admin_code') ? ' is-invalid' : '' }}" name="admin_code" value="{{$id_gen}}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('ชื่อ') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('นามสกุล') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทรศัพท์') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="phone_format form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('บทบาท') }}</label>

                            <div class="col-md-6">
                                <select name="role" class="form-control">
                                    <option value="ผู้ดูแล">ผู้ดูแล</option>
                                    <option value="ผู้แก้ไข">ผู้แก้ไข</option>
                                </select>

                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('สถานะ') }}</label>

                            <div class="col-md-6">
                                <select name="status" class="form-control">
                                    <option value="เปิด">เปิด</option>
                                    <option value="ปิด">ปิด</option>
                                </select>

                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('ชื่อเข้าใช้งาน') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่าน') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('password'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('password') }})</span>
                                @endif
                                <input id="password" type="password" class="form-control" name="password" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('ยืนยันรหัสผ่าน') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('password_confirmation') }})</span>
                                @endif
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn">
                                    {{ __('ลงทะเบียนผู้ดูแลระบบ') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script>
<script>
    // number phone
    function phoneFormatter() {
         $('input.phone_format').on('input', function() {
             var number = $(this).val().replace(/[^\d]/g, '')
                 if (number.length >= 5 && number.length < 10) { number = number.replace(/(\d{3})(\d{2})/, "$1-$2"); } else if (number.length >= 10) {
                     number = number.replace(/(\d{3})(\d{3})(\d{3})/, "$1-$2-$3"); 
                 }
             $(this).val(number)
             $('input.phone_format').attr({ maxLength : 12 });    
         });
     };
     $(phoneFormatter);
 </script>
@endsection
