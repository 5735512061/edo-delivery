@extends("/backend/layouts/template/template-admin-login")

@section("content")
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8"><br>
            <p class="text-center">
                {{-- <img src="{{ asset('/images/logo-2.png')}}" alt="#" width="25%" style="margin-bottom:10px;"> --}}
             </p>
            <div class="card">
                <div class="card-block">
                    <form action="{{url('/admin/login')}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('ชื่อเข้าใช้งาน') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('username'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('username') }})</span>
                                @endif
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่าน') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('password'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('password') }})</span>
                                @endif
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">เข้าสู่ระบบแอดมิน</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
@endsection
