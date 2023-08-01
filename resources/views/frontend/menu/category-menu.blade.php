@extends("/frontend/layouts/template/template")

@section("content")
@php
    $menu_types = DB::table('menu_types')->where('store_id',$store_id)->where('status',"เปิด")->get();
@endphp
{{-- <h1 class="text-center mt-5" style="font-weight: bold;">Delivery Online<br>Coming Soon</h1> --}}
<div class="container-fluid mt-5">
  <div class="col-md-12">
    <h1 style="text-align: center;">OUR MENU<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h1><br>
    <div class="row">
        @foreach ($menu_types as $menu_type => $value)
          <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">
            <div class="col-md-3">
                <div class="product">
                    <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_menu_type')}}/{{$value->image}}"></a>
                    <div class="text py-3 px-3 text-center">
                      <h3><a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">{{$value->menu_type}}</a></h3>
                    </div>
                </div>
            </div>
          </a>
        @endforeach
    </div>
  </div>
</div>
@endsection