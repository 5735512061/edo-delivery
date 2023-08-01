@extends("/backend/layouts/template/template-seller-login")

@section("content")
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8"><br>
            <p class="text-center">
                <img src="{{ asset('/images/logo-2.png')}}" alt="#" width="25%" style="margin-bottom:10px;">
             </p>
            <div class="card">
                <div class="card-block">
                    <form action="{{ route('seller.password.update') }}" enctype="multipart/form-data" method="post">@csrf
                      <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has('alert-' . $msg))
    
                          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
                      </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่านเก่า') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('oldpassword'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('oldpassword') }})</span>
                                @endif
                                <input type="password" class="form-control" name="oldpassword" value="{{ old('oldpassword') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่านใหม่') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('password'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('password') }})</span>
                                @endif
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('ยืนยันรหัสผ่าน') }}</label>

                          <div class="col-md-6">
                              @if ($errors->has('password_confirmation'))
                                  <span class="text-danger" style="font-size: 17px;">({{ $errors->first('password_confirmation') }})</span>
                              @endif
                              <input id="password" type="password" class="form-control" name="password_confirmation">
                          </div>
                      </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">เปลี่ยนรหัสผ่าน</button>
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
