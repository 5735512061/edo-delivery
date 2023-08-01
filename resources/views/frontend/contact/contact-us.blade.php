@extends("/frontend/layouts/template/template")

@section("content")
@php
    $stores = DB::table('stores')->get();
@endphp
<div class="hero-wrap hero-bread" style="background-image: url('images/header/header-1.png');"></div>
<div class="container-fluid mt-5">
    <div class="col-md-12">
        <h1 style="text-align: center;">ติดต่อเรา<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h1>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="row block-9">
            {{-- <div class="col-md-6 order-md-last d-flex">
                @foreach ($stores as $store => $value)
                    <form action="#" class="bg-white p-5 contact-form">
                        <h2>ข้อมูลติดต่อ</h2><hr>
                        <div class="media">
                            <div class="media-body">
                                <h4><span class="icon-phone_iphone"></span> <a href="tel:{{$value->phone}}">{{$value->phone}}</a></h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-body">
                                <h4><span class="icon-facebook"></span> &nbsp;<a href="{{$value->facebook_url}}">{{$value->facebook}}</a></h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-body">
                                <h4><span class="icon-instagram"></span> <a href="{{$value->instagram_url}}">{{$value->instagram}}</a></h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-body">
                                <h4>LINE : <a href="{{$value->line_url}}">{{$value->line}}</a></h4>
                            </div>
                        </div><hr>
                        <div class="media">
                            <div class="media-body">
                                <h5>{{$value->name}}<br>{{$value->address}}</h5>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div> --}}
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url('/contact-us')}}" enctype="multipart/form-data" method="post" class="bg-white p-5 contact-form">@csrf
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alertdesign alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endforeach
                    <div class="form-group">
                        @if ($errors->has('tel'))
                            <span class="text-danger" style="font-size: 16px;">({{ $errors->first('tel') }})</span>
                        @endif
                        <input type="text" class="phone_format form-control" placeholder="เบอร์โทรศัพท์" name="tel">
                    </div>
                    <div class="form-group">
                        @if ($errors->has('subject'))
                            <span class="text-danger" style="font-size: 16px;">({{ $errors->first('subject') }})</span>
                        @endif
                        <input type="text" class="form-control" placeholder="หัวข้อเรื่อง" name="subject">
                    </div>
                    <div class="form-group">
                        @if ($errors->has('message'))
                            <span class="text-danger" style="font-size: 16px;">({{ $errors->first('message') }})</span>
                        @endif
                        <textarea cols="30" rows="7" class="form-control" placeholder="ข้อความที่ต้องการส่ง" name="message"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="ส่งข้อความติดต่อ" class="btn btn-primary py-3 px-5">
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
{{-- <script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script> --}}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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