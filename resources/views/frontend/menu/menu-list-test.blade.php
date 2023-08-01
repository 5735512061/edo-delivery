@extends("/frontend/layouts/template/template")
<style>
.filters ul{
  display: flex;
  justify-content: center;
  list-style: none;
  margin: 30px 15px
}
.filters ul li{
  display: inlnie-block;
  text-align: center;
  margin-right: 10px;
  padding: 5px 5px 5px 5px;
  font-weight: 700;
  font-size: 14px; 
  cursor: pointer;
  position: relative;
  margin-bottom: -2px;
  color: #777;
  transition: 0.3s;
  text-transform: uppercase;
}
.filters ul li:hover{
  color: #EB2D3A;
}
.filters ul li.is-checked{
  border-bottom: 2px solid #EB2D3A;
}
.filters ul li:last-child{
  margin-right: 0;
}

</style>    
@section("content")
@php
    $menu_types = DB::table('menu_types')->where('store_id',$store_id)->where('status',"เปิด")->get();
@endphp
<div class="container-fluid">
  <div class="row justify-content-center mb-3 pb-3">
    <div class="col-md-12 heading-section text-center ftco-animate">
      <h2 class="mb-4">MENU LIST</h2>
    </div>
</div>

<div class="filters">
  <ul>
    <li class="is-checked" data-filter="*">All</li>
    @foreach ($menu_types as $menu_type => $value)
        <li data-filter=".{{$value->menu_type_eng}}">{{$value->menu_type}}</li>
    @endforeach
  </ul>
</div>

<div class="container-fluid">
  <div class="col-md-12">
    <div class="rows grid data-isotope='{ "itemSelector": ".grid-item", "masonry": { "columnWidth": 200 } }'">
        @foreach ($menus as $menu => $value)
            @php
                $image = DB::table('image_food_menus')->where('menu_id',$value->id)->value('image');
                $price = DB::table('menu_prices')->where('menu_id',$value->id)->where('status','เปิด')->orderBy('id','desc')->value('price');
                $price_promotion = DB::table('menu_price_promotions')->where('menu_id',$value->id)->where('status','เปิด')->orderBy('id','desc')->value('promotion_price');
                $menu_type_eng = DB::table('menu_types')->where('id',$value->menu_type_id)->value('menu_type_eng');
            @endphp
            <div class="col-md-3 grid-item {{$menu_type_eng}}">
                <div class="product">
                    <a href="#" class="img-prod"><img class="img-fluid" src="{{url('/image_upload/image_food_menu')}}/{{$image}}"></a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3><a href="#">{{$value->thai_name}}</a></h3>
                        <h3><a href="#">{{$value->eng_name}}</a></h3>
                        <p class="price">
                            @if($price == null)
                                <span class="price-sale">ราคา 0 บาท</span>
                            @elseif($price_promotion == null)
                                <span class="price-sale">ราคา {{$price}} บาท</span>
                            @else 
                                <span class="mr-2 price-dc">ราคา {{$price}} บาท</span>
                                <span class="price-sale">ราคา {{$price_promotion}} บาท</span>
                            @endif
                        </p>
                    </div>
                    <center class="pb-4"><a href="{{url('/customer/addToCart')}}/{{$value->id}}/{{$store_id}}" class="btn btn-black">หยิบสินค้าใส่ตะกร้า</a></center>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
<script type="text/javascript" src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.min.js"></script>  
<script>
  var $grid = $('.grid').isotope({
    // options
    itemSelector: '.grid-item',
    layoutMode: 'fitRows',
  });

  // change is-checked class on buttons
  var $buttonGroup = $('.filters');
  $buttonGroup.on( 'click', 'li', function( event ) {
    $buttonGroup.find('.is-checked').removeClass('is-checked');
    var $button = $( event.currentTarget );
    $button.addClass('is-checked');
    var filterValue = $button.attr('data-filter');
    $grid.isotope({ filter: filterValue });
  });
</script>
@endsection