@extends("/frontend/layouts/template/template")

@section("content")
<div class="container mt-5">
    <div class="row">
        @foreach ($branchs as $branch => $value)
            <div class="col-md-4 mt-3">
                <div class="card text-white kanit">
                    <div class="card-body" style="text-align: center;">

                        @if($value->branch_name == "littleedophuket")
                            <h2>Little Edo สาขาภูเก็ต</h2>
                        @endif

                        @php
                            $feedbacks = DB::table('customer_reviews')->where('branch_name',$value->branch_name)->get();
                            $count_feedback = count($feedbacks);
                            
                            $comments = DB::table('customer_reviews')->where('branch_name',$value->branch_name)
                                                                     ->where('comment','!=',NULL)->get();
                            $count_comment = count($comments);
                        @endphp
                        <hr style="border-top:2px solid #000000;">
                        <h3>Feedback  {{$count_feedback}} รายการ</h3>
                        <h3>ความคิดเห็น  {{$count_comment}} รายการ</h3><br>
                        <a href="{{url('/customer-feedback-detail')}}/{{$value->branch_name}}" style="text-decoration: none;"><h3 style="text-align: right; color: #000000;">รายละเอียด >></h3></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection