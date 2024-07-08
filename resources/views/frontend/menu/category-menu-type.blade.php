@extends("/frontend/layouts/template/template")
<style>
    .stock-center {
      position: relative;
      text-align: center;
    }
    .stock {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: red;
        font-size: 20px;
        font-weight: bold;
        background-color:#fff;
        border:1px solid rgb(255, 255, 255);    
        height:100px !important;
        border-radius:50%;
        -moz-border-radius:50%;
        -webkit-border-radius:50%;
        width:100px;
        
    }
    .btn-white-cart {
        color: #000 !important;
    }
    .btn-white-cart:hover {
        color: #fff !important;
    }
</style>
@section("content")
@php
    $menu_type_eng = DB::table('menu_types')->where('menu_type_eng',$menu_type)->value('menu_type');
@endphp
{{-- <div class="hero-wrap hero-bread" style="background-image: url('../../images/header/header-1.jpg');"></div> --}}
<div class="container-fluid mt-5">
    <div class="col-md-12">
        <div class="card">
            <center><div class="card-body"><a href="{{url('/category-menu')}}/{{$store_id}}">OUR MENU (HOME)</a> &nbsp<span class="icon-caret-right"></span> &nbsp{{$menu_type_eng}}</div></center>
        </div>
    </div>
</div>
@if(count($menus) != 0)
<div class="container-fluid mt-5">
  <div class="col-md-12">
    <div class="row">
        @foreach ($menus as $menu => $value)
            @php
                $image = DB::table('image_food_menus')->where('menu_id',$value->id)->value('image');
                $price = DB::table('menu_prices')->where('menu_id',$value->id)->where('status',"เปิด")->value('price');
                $price_promotion = DB::table('menu_price_promotions')->where('menu_id',$value->id)->where('status',"เปิด")->value('promotion_price');
                $price_promotion_format = number_format($price_promotion);
                $price_format = number_format($price);
            @endphp
            {{-- <a href="#" class="img-prod" data-toggle="modal" data-target="#ModalStatus{{$value->id}}" data-backdrop="static"> --}}
                <div class="col-md-3">
                    <div class="product">
                        @if($value->stock == 'สินค้าหมด')
                        <div class="stock-center">
                            <img class="img-fluid" src="{{url('/image_upload/image_food_menu')}}/{{$image}}" style="border-radius: 7px; opacity: 0.3;">
                            <div class="stock"><br>สินค้าหมด</div>
                        </div>
                        @else 
                            <img class="img-fluid" src="{{url('/image_upload/image_food_menu')}}/{{$image}}" style="border-radius: 7px;">
                        @endif
                        <div class="text py-3 pb-4 px-3 text-center">
                            <h3>{{$value->thai_name}}</h3>
                            <h3>{{$value->eng_name}}</h3>
                            <p class="price">
                                @if($price == null)
                                    <span class="price-sale">ราคา 0 บาท</span>
                                @elseif($price_promotion == null)
                                    <span class="price-sale">ราคา {{$price_format}} บาท</span>
                                @else 
                                    <span class="mr-2 price-dc">ราคา {{$price_format}} บาท</span>
                                    <span class="price-sale">ราคา {{$price_promotion_format}} บาท</span>
                                @endif
                            </p>
                        </div>
                        <center class="pb-4"><a href="" class="btn btn-white" data-backdrop="static">เลือกซื้อสินค้า</a></center>
                        {{-- <center class="pb-4"><a href="" class="btn btn-white" data-toggle="modal" data-target="#ModalStatus{{$value->id}}" data-backdrop="static">เลือกซื้อสินค้า</a></center> --}}
                    </div>
                </div>
            {{-- </a> --}}
            <!-- Modal -->
            <div class="modal fade" id="ModalStatus{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{$value->thai_name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    @if($value->stock == 'สินค้าหมด')
                                        <div class="stock-center">
                                            <a href="#" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_food_menu')}}/{{$image}}" style="border-radius: 7px; opacity: 0.3;"></a>
                                            <div class="stock"><br>สินค้าหมด</div>
                                        </div>
                                    @else 
                                        <a href="#" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_food_menu')}}/{{$image}}" style="border-radius: 7px;"></a>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-4">
                                    <h4>{{$value->thai_name}}</h4>
                                    <h6>{{$value->eng_name}}</h6>
                                    <p>{{$value->detail}}</p>
                                    <h4>
                                        @if($price == null)
                                            <span class="price-sale">ราคา 0 บาท</span>
                                        @elseif($price_promotion == null)
                                            <span class="price-sale">ราคา {{$price_format}} บาท</span>
                                        @else 
                                            <span style="text-decoration: line-through; color: #b3b3b3;">ราคา {{$price_format}} บาท</span>
                                            <span class="price-sale">ราคา {{$price_promotion_format}} บาท</span>
                                        @endif
                                    </h4><br>
                                    <div class="form-group">
                                        <div class="row">
                                            &nbsp;&nbsp;<button class="btn btn-primary" onclick="minus({{$value->id}})"><span class="icon-minus"></span></button>&nbsp;
                                            <input type="text" min="1" value="1" name="qty" id="number-{{$value->id}}" class="form-control" style="width:10%; text-align:center;">
                                            &nbsp;<button class="btn btn-primary" onclick="plus({{$value->id}})"><span class="icon-plus"></span></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control mt-5" id="comment-{{$value->id}}" placeholder="คำขอเพิ่มเติม (ถ้ามี)" name="comment" style="font-family: 'Noto Sans Thai'; width:80%; font-size:15px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($value->stock != 'สินค้าหมด')
                            <div class="modal-footer">
                                <p id="number-{{$value->id}}" style="display: none;"></p>
                                <a onclick="add({{$value->id}},{{$store_id}})" id="product-{{$value->id}}" class="btn btn-white btn-white-cart"><span class="icon-shopping_cart"></span> หยิบสินค้าใส่ตะกร้า</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</div>
<script>
    var qty = 1;
    document.getElementById(`number-{{$value->id}}`).innerHTML = qty;
    
    const url = "{{ url('/customer/addToCart/') }}"

    function add(productId,store_id) {
        const comment = document.getElementById(`comment-${productId}`).value
        document.location = `${url}/${productId}/${qty}/${store_id}?comment=${comment}`
    }

    function plus(productId){
        qty++;
        // console.log(document.getElementById(`number-${productId}`));
        document.getElementById(`number-${productId}`).value = qty;
    }

    function minus(productId){
        if (qty > 1) {
            qty--;
            console.log(qty);
            document.getElementById(`number-${productId}`).value = qty;
        } else {
            qty = 0;
            console.log(qty);
            document.getElementById(`number-${productId}`).value = qty;
        }
    }

</script>
@else 
    <center><h1 class="mt-5">ไม่มีรายการสินค้าที่เลือกในขณะนี้!</h1></center>
    <center><h3>-- เลือกรายการสินค้าที่มี --</h3></center><br>c
    @php
        $menu_types = DB::table('menu_types')->where('store_id',$store_id)->where('status',"เปิด")->get();
    @endphp

    <div class="container-fluid mt-5">
        <div class="col-md-12">
            <div class="row">
                @foreach ($menu_types as $menu_type => $value)
                <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">
                    <div class="col-md-3">
                        <div class="product">
                            <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_menu_type')}}/{{$value->image}}"></a>
                            <div class="text py-3 px-3 text-center"><hr>
                                <h3><a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">{{$value->menu_type}}</a></h3>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

@endsection