@extends("/frontend/layouts/template/template")

@section("content")
<div class="login">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">    
                <div class="register-form">
                    <h3 style="text-align: center;">แก้ไขข้อมูลส่วนตัว</h3><hr>
                    <form action="{{url('/customer/update-profile')}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="flash-message">
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                              @if(Session::has('alert-' . $msg))
        
                              <p style="font-size: 16px;" class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                              @endif
                            @endforeach
                        </div>     
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" name="customer_code" value="{{$customer->code_gen}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('ชื่อ') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('name'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('name') }})</span>
                                @endif
                                <input type="text" class="form-control" name="name" value="{{$customer->name}}" style="font-family: 'Mitr'">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('นามสกุล') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('surname'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('surname') }})</span>
                                @endif
                                <input type="text" class="form-control" name="surname" value="{{$customer->surname}}" style="font-family: 'Mitr'">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทรศัพท์') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('phone'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('phone') }})</span>
                                @endif
                                <input type="text" class="phone_format form-control" name="phone" value="{{$customer->phone}}" style="font-family: 'Mitr'"> 
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('ชื่อเข้าใช้งาน (ภาษาอังกฤษ)') }}</label>

                            <div class="col-md-6">
                                @if ($errors->has('username'))
                                    <span class="text-danger" style="font-size: 17px;">({{ $errors->first('username') }})</span>
                                @endif
                                <input type="text" class="form-control" name="username" value="{{$customer->username}}" style="font-family: 'Mitr'">
                            </div>
                        </div>

                        <input type="hidden" name="id" value="{{$customer->id}}">
                        <input type="hidden" name="store_id" value="{{$store_id}}">
                        <div class="form-group row mb-5">
                            <div class="col-md-6 offset-md-4">
                                <p><button style="font-family: 'Mitr'" type="submit" class="btn btn-primary">อัพเดตข้อมูลส่วนตัว</button></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login End -->
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