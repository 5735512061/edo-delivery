@extends("/frontend/layouts/template/template")
<style>

h1,
p {
  margin: 0;
  padding: 0;
  line-height: 1.5;
}

.app {
  width: 90%;
  max-width: 500px;
  margin: 0 auto;
}

.item {
  width: 90px;
  height: 90px;
  display: flex;
  justify-content: center;
  align-items: center;
  user-select: none;
}
.radio {
  display: none !important;
}
.radio ~ span {
  font-size: 3rem;
  filter: grayscale(100);
  cursor: pointer;
  transition: 0.3s;
}

.radio:checked ~ span { 
  filter: grayscale(0);
  font-size: 4rem;
}

</style>
@section("content")
<center><h1 style="font-size: 2rem; color: #00902b; padding: 1rem !important; font-weight:bolder;">ข้อเสนอแนะ และคำติชมเกี่ยวกับการให้บริการ</h1></center>
<center><p style="padding-left: 2rem !important; padding-right: 2rem !important;">ความคิดเห็นของลูกค้ามีผลต่อการปรับปรุงคุณภาพการให้บริการของพนักงานแก่ลูกค้า พัฒนาการให้บริการให้ดียิ่งขึ้น</p></center>
<div class="app">
    <div class="container">
        <form action="{{url('/customer-review')}}" enctype="multipart/form-data" method="post">@csrf
            <center><p style="color: red;">* กดเลือกคะแนนความพึงพอใจต่อการให้บริการ</p></center>
            <div class="row" style="margin-top: 5rem;">
                <div class="col-md-2 col-2">
                    <div class="item">
                        <label for="1">
                            <input class="radio" type="radio" name="feedback" id="1" value="1">
                            <center><p style="font-family: 'Mitr'; margin-bottom: 0rem;">1</p></center>
                            <span><center>😡</center></span>
                            <center><p>แย่</p></center>
                        </label>
                    </div>
                </div>
            
                <div class="col-md-2 col-2">
                    <div class="item">
                        <label for="2">
                            <input class="radio" type="radio" name="feedback" id="2" value="2">
                            <center><p style="font-family: 'Mitr'; margin-bottom: 0rem;">2</p></center>
                            <span><center>🙁</center></span>
                            <center><p>ปรับปรุง</p></center>
                        </label>
                    </div>
                </div>
            
                <div class="col-md-2 col-2">
                    <div class="item">
                        <label for="3">
                            <input class="radio" type="radio" name="feedback" id="3" value="3">
                            <center><p style="font-family: 'Mitr'; margin-bottom: 0rem;">3</p></center>
                            <span><center>😐</center></span>
                            <center><p>พอใช้</p></center>
                        </label>
                    </div>
                </div>
            
                <div class="col-md-2 col-2">
                    <div class="item">
                        <label for="4">
                            <input class="radio" type="radio" name="feedback" id="4" value="4">
                            <center><p style="font-family: 'Kanit'; margin-bottom: 0rem;">4</p></center>
                            <span><center>😁</center></span>
                            <center><p>ดี</p></center>
                        </label>
                    </div>
                </div>
            
                <div class="col-md-2 col-2">
                    <div class="item">
                        <label for="5">
                            <input class="radio" type="radio" name="feedback" id="5" value="5">
                            <center><p style="font-family: 'Kanit'; margin-bottom: 0rem;">5</p></center>
                            <span><center>😍</center></span>
                            <center><p>ดีมาก</p></center>
                        </label>
                    </div>
                </div>
                
            </div>
            <div class="row mt-5">
                <textarea name="comment" cols="30" rows="5" class="form-control" placeholder="ข้อเสนอแนะ / คำติชม" style="font-family: 'Mitr';"></textarea>
            </div>
            <input type="hidden" name="branch_name" value="{{$branch_name}}">
            <center><button type="submit" class="btn btn-success my-4" style="font-size: 1.5rem; font-family: 'Mitr';">แสดงความคิดเห็น</button></center>
        </form>
    </div>
</div>
@endsection