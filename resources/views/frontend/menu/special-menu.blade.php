@extends("/frontend/layouts/template/template")

@section("content")
{{-- <div class="hero-wrap hero-bread" style="background-image: url('../images/header/header-1.jpg');"></div> --}}
<div class="container-fluid mt-5">
    <div class="row">
        @foreach ($special_menus as $special_menu => $value)
        <div class="col-md-3">
            <div class="product">
                <img class="img-fluid" src="{{url('/image_upload/image_special_menu')}}/{{$value->image}}" style="border-radius: 7px;">
                <div class="text py-3 pb-4 px-3 text-center">
                    <h3>{{$value->heading}}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection