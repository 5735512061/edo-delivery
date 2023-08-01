@extends("/frontend/layouts/template/template")
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="{{asset('/frontend/js/halkaBox.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/halkaBox.min.css')}}">
<script type="text/javascript" src="{{asset('/frontend/js/image-lightbox.js')}}"></script>
@section("content")
@php
    $gallerys = DB::table('image_gallerys')->get();
@endphp
{{-- <div class="hero-wrap hero-bread" style="background-image: url('../images/header/header-2.jpg');"></div> --}}
<h1 style="text-align: center;" class="mt-3">GALLERY<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h1><br>
    <div class="container">
        <div class="row">
            @foreach ($gallerys as $gallery => $value)
            <div class="col-md-6 col-lg-3 col-6">
                <div class="product" id="single-images">
                    <a href="{{url('/image_upload/image_gallery')}}/{{$value->image}}" class="singleImage2 img-prod"><img width="100%;" class="img-fluid" src="{{url('/image_upload/image_gallery')}}/{{$value->image}}"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>  
@endsection