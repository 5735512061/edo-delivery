@extends("/frontend/layouts/template/template")
<style>
.ellipsis-verti{
    display:block;
    width:100%;
    text-overflow:ellipsis;
    overflow:hidden;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    height: 110px;
}
</style>
@section("content")
@php
    $blogs = DB::table('blogs')->get();
@endphp
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
                                {{-- <h4 class="mt-5">{{$value->thai_name}}</h4> --}}
                                <p class="ellipsis-verti">{{$value->detail}}</p>
                                <a href="" style="color: red;"><strong>อ่านเพิ่มเติม ...</strong></a>
                            </div>
                        </div><br>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
@endsection