
@extends("/frontend/layouts/template/template")
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="{{asset('/frontend/js/halkaBox.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/halkaBox.min.css')}}">
<script type="text/javascript" src="{{asset('/frontend/js/image-lightbox.js')}}"></script>
<style>
	@media only screen and (max-width: 768px) {
        #mobile {
            display: inline !important;
        }
        #desktop {
            display: none;
        }
    }
</style>
@section("content")

@php
    $slides = DB::table('image_slide_websites')->get();
    $menu_types = DB::table('menu_types')->where('status',"เปิด")->get();
    $gallerys = DB::table('image_gallerys')->paginate(12);
    $galleryMobiles = DB::table('image_gallerys')->paginate(6);
    $blogs = DB::table('blogs')->paginate(2);
@endphp

<section id="home-section" class="hero">
    <div class="home-slider owl-carousel ">
        @foreach ($slides as $slide => $value)
            <div class="slider-item" style="background-image: url('image_upload/image_slide_website/{{$value->image}}')">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true"></div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@include("/frontend/store-define/template")

<div class="container-fluid mt-5" >
    {{-- Desktop --}}
    <div class="col-md-12" id="desktop">
        <h1 style="text-align: center;">GALLERY<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h1><br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row">
                    @foreach ($gallerys as $gallery => $value)
                    <div class="col-md-2 col-lg-2 col-6" style="padding-left: 0px !important;">
                        <div class="product" id="single-images">
                            <a href="{{url('/image_upload/image_gallery')}}/{{$value->image}}" class="singleImage2 img-prod">
                                <img class="img-fluid" src="{{url('/image_upload/image_gallery')}}/{{$value->image}}" width="100%;">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <center><a href="{{url('/gallery')}}">GO TO GALLERY<hr class="col-md-1 col-1" style="border-top:2px solid rgb(0, 0, 0); width:50px;"></a></center> 
    </div>
    {{-- Mobile --}}
    <div class="col-md-12" id="mobile" style="display: none;">
        <h1 style="text-align: center;">GALLERY<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h1><br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row">
                    @foreach ($galleryMobiles as $galleryMobile => $value)
                    <div class="col-md-2 col-lg-2 col-6" style="padding: 2px !important;">
                        <div class="product" id="single-images" style="margin-bottom: 2px !important">
                            <a href="{{url('/image_upload/image_gallery')}}/{{$value->image}}" class="singleImage2 img-prod">
                                <img class="img-fluid" src="{{url('/image_upload/image_gallery')}}/{{$value->image}}" width="100%;">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-1"></div>
        </div><br>
        <center><a href="{{url('/gallery')}}">GO TO GALLERY<hr class="col-md-1 col-1" style="border-top:2px solid rgb(0, 0, 0); width:50px;"></a></center> 
    </div>
</div>  

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <a href="{{url('/review')}}"><div class="hero-wrap hero-bread" style="background-image: url('images/review/banner-review.png'); padding: 6em 0 !important;"></div></a>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>


<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h1 style="text-align: center;">BLOG<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h1><br>
            <div class="row">
                @foreach ($blogs as $blog => $value)
                    <div class="col-md-6">
                        <div class="row" style="border: 1px solid rgb(212, 212, 212); margin:3px;"> 
                            <div class="col-md-6 mt-3 mb-3">
                                <img src="{{url('/image_upload/image_blog')}}/{{$value->image}}" class="img-responsive" width="100%">
                            </div>
                            <div class="col-md-6">
                                {{-- <h2 class="mt-5">{{$value->thai_name}}</h2> --}}
                                <p>{{$value->detail}}</p>
                            </div>
                        </div><br>
                    </div>
                @endforeach
            </div>
            <center><a href="{{url('/blog')}}">GO TO BLOG<hr class="col-md-1 col-1" style="border-top:2px solid rgb(0, 0, 0); width:50px;"></a></center> 
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
@endsection    