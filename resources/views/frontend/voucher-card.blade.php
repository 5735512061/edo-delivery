@extends('/frontend/layouts/template/template-card')

@section('content')
    <hr>
    <center>
        <h2><strong>EDO GROUP</strong></h2>
    </center>
    <hr style="width: 10%; border-top: 5px solid rgb(0, 0, 0);">
    <center>
        <h3 style="font-weight: bolder;">VOUCHER CARD</h3>
    </center>
    <hr>
    <div class="container mb-5">
        <div class="row ftco-animate">
            <div class="col-md-12 mt-3">
                <h5><strong>เงื่อนไขการใช้สิทธิ์</strong></h5>
                <ul>
                    <li>สามารถใช้สิทธิ์ได้ที่ร้านอาหารทุกร้านในเครือเอโดะกรุ๊ป</li>
                    <li>สิทธิ์ส่วนลดนี้ไม่สามารถแลกเปลี่ยน หรือทอนเป็นเงินสดได้</li>
                    <li>ไม่สามารถใช้ร่วมกับโปรโมชั่นส่งเสริมการขายอื่นได้</li>
                    <li>เงื่อนไขเป็นไปตามที่บริษัทฯกำหนด ขอสงวนสิทธิ์ในการเปลี่ยนแปลง แก้ไข หรือยกเลิก
                        โดยไม่ต้องแจ้งให้ทราบล่วงหน้า</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="row mt-3">
                    <div class="col-md-1"></div>
                    <div class="col-md-2 col-4 mt-3">
                        <img src="{{ asset('/images/edo-group/littleedo.png') }}" class="img-responsive" width="100%">
                    </div>
                    <div class="col-md-2 col-4 mt-3">
                        <img src="{{ asset('/images/edo-group/edoramen.png') }}" class="img-responsive" width="100%">
                    </div>
                    <div class="col-md-2 col-4 mt-3">
                        <img src="{{ asset('/images/edo-group/edoyakiniku.png') }}" class="img-responsive" width="100%">
                    </div>
                    <div class="col-md-2 col-4 mt-3">
                        <img src="{{ asset('/images/edo-group/edoomakase.png') }}" class="img-responsive" width="100%">
                    </div>
                    <div class="col-md-2 col-4 mt-3">
                        <img src="{{ asset('/images/edo-group/edocoffee.jpg') }}" class="img-responsive" width="100%">
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
