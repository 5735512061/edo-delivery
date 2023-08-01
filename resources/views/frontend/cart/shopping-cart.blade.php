@extends("/frontend/layouts/template/template")

@section("content")
@php
    $store_id = $store_id;
@endphp
@if(Session::has('cart'))
    @foreach($products as $product)
        @php
            $product['store_id_session'];
        @endphp
    @endforeach
@endif
<section class="ftco-section ftco-cart" style="margin-top: -70px;">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">ตะกร้าสินค้า<hr class="col-md-1 col-1" style="border-top:5px solid rgb(0, 0, 0); width:50px;"></h2>
            </div>
        </div>   		
    </div>
    @if(Session::has('cart') && ($product['store_id_session'] == $store_id))
    <div class="container">
        <div class="row">
        <div class="col-md-12 ftco-animate">
            <div class="cart-list">
                <table class="table">
                    @php
                        $price = 0;
                    @endphp
                    <thead class="thead-primary">
                      <tr class="text-center">
                        <th>รายการอาหาร</th>
                        {{-- <th>ราคา</th> --}}
                        <th>ปริมาณ</th>
                        <th>ราคารวม</th>
                        {{-- <th>หมายเหตุ</th> --}}
                        <th>ยกเลิกรายการ</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="text-center">
                                @php 
                                    $store_id_session = $product['store_id_session'];
                                    $id = $product['item'];
                                    $comment = $product['comment'];
                                    $thai_name = DB::table('food_menus')->where('id',$id)->where('store_id',$store_id)->value('thai_name'); 
                                    $eng_name = DB::table('food_menus')->where('id',$id)->where('store_id',$store_id)->value('eng_name');
                                    $menu_id = DB::table('food_menus')->where('id',$id)->where('store_id',$store_id)->value('id'); 
                                    $product_price = DB::table('menu_prices')->where('menu_id',$menu_id)->orderBy('id','desc')->value('price'); 
                                    $promotion_price = DB::table('menu_price_promotions')->where('menu_id',$menu_id)->orderBy('id','desc')->value('promotion_price');
                                    $price += $product['price'];
						        @endphp
                                <td class="product-name">
                                    <h3>{{$thai_name}}</h3>
                                    {{-- <p>{{$eng_name}}</p> --}}
                                </td>
                                {{-- @if($promotion_price == null)
                                    <td class="price">{{$product_price}}.-</td>
                                @else
                                    <td class="price">{{$promotion_price}}.-</td>
                                @endif   --}}
                                <td class="quantity">{{$product['qty']}}</td>
                                <td class="total">{{ number_format($product['price']) }}.-</td>
                                {{-- <td>{{$product['comment']}}</td> --}}
                                <td><a href="{{ route('remove', ['id' => $product['item'], 'store_id' => $store_id]) }}">X</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
            <div class="cart-total mb-3">
                <h3>Cart Totals</h3>
                <p class="d-flex">
                    <span>Subtotal</span>
                    <span>{{ number_format($price) }}.00 บาท</span>
                </p>
                <p class="d-flex">
                    <span>Delivery</span>
                    <span>0.00 บาท</span>
                </p>
                <hr>
                <p class="d-flex total-price">
                    <span>Total</span>
                    <span>{{ number_format($price) }}.00 บาท</span>
                </p>
            </div>
            <p><a href="{{ route('checkout', ['store_id' => $store_id]) }}" class="btn btn-primary">ดำเนินการชำระเงิน</a></p>
        </div>
    </div>
    </div>
    @else 
    <center><h1>ไม่มีรายการสินค้าในตะกร้า!</h1></center>
    <center><h3>-- กรุณาเลือกรายการสินค้า --</h3></center><br>
    @php
        $menu_types = DB::table('menu_types')->where('store_id',$store_id)->where('status',"เปิด")->get();
    @endphp

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                @foreach ($menu_types as $menu_type => $value)
                <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">
                    <div class="col-md-3">
                        <div class="product">
                            <a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_menu_type')}}/{{$value->image}}"></a>
                            <div class="text py-3 px-3 text-center"><hr>
                                <h3 style="font-weight: bold;"><a href="{{url('/category')}}/{{$value->menu_type_eng}}/{{$store_id}}">{{$value->menu_type}}</a></h3>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</section>
@endsection