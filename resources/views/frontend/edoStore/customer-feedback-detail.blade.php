@extends("/frontend/layouts/template/template")

@section("content")
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-2">
            <div class="card text-black kanit">
                <div class="card-body" style="text-align: center;">
                    @php
                        $all_feedback = count(DB::table('customer_reviews')->where('branch_name',$branch_name)->get());

                        $bad = count(DB::table('customer_reviews')->where('branch_name',$branch_name)->where('feedback','1')->get());
                        $percent_bad = ($bad/$all_feedback)*100;

                        $adjust = count(DB::table('customer_reviews')->where('branch_name',$branch_name)->where('feedback','2')->get());
                        $percent_adjust = ($adjust/$all_feedback)*100;

                        $fair = count(DB::table('customer_reviews')->where('branch_name',$branch_name)->where('feedback','3')->get());
                        $percent_fair = ($fair/$all_feedback)*100;

                        $good = count(DB::table('customer_reviews')->where('branch_name',$branch_name)->where('feedback','4')->get());
                        $percent_good = ($fair/$all_feedback)*100;

                        $verygood = count(DB::table('customer_reviews')->where('branch_name',$branch_name)->where('feedback','5')->get());
                        $percent_verygood = ($verygood/$all_feedback)*100;

                    @endphp
                    แย่  : {{$percent_bad}}% <br>
                    ปรับปรุง  : {{$percent_adjust}}%<br>
                    พอใช้ : {{$percent_fair}}%<br>
                    ดี : {{$percent_good}}%<br>
                    ดีมาก : {{$percent_verygood}}%
                </div>
            </div>
        </div>

        <div class="col-xl-12 order-xl-1 mt-5">
            {{$feedbacks->links()}}
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        @if($branch_name == "littleedophuket")
                            @php
                                $branch_name = "Little Edo สาขาภูเก็ต";
                            @endphp
                        @endif
                        <div class="col-12">
                            <center><h3 class="mb-0 kanit">ข้อร้องเรียน / ความคิดเห็นของลูกค้าที่มีต่อ {{$branch_name}}</h3></center>
                            <center><p style="color:red;">** เฉพาะการประเมินแบบ พอใช้ ปรับปรุง และแย่</p></center>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th style="text-align:center;">#</th>
                                    <th style="text-align:center;">FEEDBACK</th>
                                    <th style="text-align:center;">COMMENT</th>
                                    <th style="text-align:center;">วันที่แสดงความเห็น</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                            </thead>
                            @foreach($feedbacks as $feedback => $value)
                            <tbody>
                                <tr>
                                    <td style="color:#070707; text-align:center;">{{$NUM_PAGE1*($page-1) + $feedback+1}}</td>
                                    @if($value->feedback == "1")
                                        <td style="color:#070707; text-align:center;">แย่</td>   
                                    @elseif($value->feedback == "2")
                                        <td style="color:#070707; text-align:center;">ปรับปรุง</td>   
                                    @elseif($value->feedback == "3")
                                        <td style="color:#070707; text-align:center;">พอใช้</td>   
                                    @elseif($value->feedback == "4")
                                        <td style="color:#070707; text-align:center;">ดี</td>   
                                    @elseif($value->feedback == "5")
                                        <td style="color:#070707; text-align:center;">ดีมาก</td>
                                    @else
                                        <td style="color:#070707; text-align:center;"></td>
                                    @endif
                                    <td style="color:#070707; text-align:center;">{{$value->comment}}</td>
                                    <td style="color:#070707; text-align:center;">{{$value->created_at}}</td>
                                    <td style="color:#070707; text-align:center;"></td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 order-xl-1 mt-5">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        @if($branch_name == "littleedophuket")
                            @php
                                $branch_name = "Little Edo สาขาภูเก็ต";
                            @endphp
                        @endif
                        <div class="col-12">
                            <center><h3 class="mb-0 kanit">ข้อร้องเรียน / ความคิดเห็นของลูกค้าที่มีต่อ{{$branch_name}}</h3></center>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{$allfeedbacks->links()}}
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th style="text-align:center;">#</th>
                                    <th style="text-align:center;">FEEDBACK</th>
                                    <th style="text-align:center;">COMMENT</th>
                                    <th style="text-align:center;">วันที่แสดงความเห็น</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                            </thead>
                            @foreach($allfeedbacks as $allfeedback => $value)
                            <tbody>
                                <tr>
                                    <td style="color:#070707; text-align:center;">{{$NUM_PAGE2*($page-1) + $allfeedback+1}}</td>
                                    @if($value->feedback == "1")
                                        <td style="color:#070707; text-align:center;">แย่</td>   
                                    @elseif($value->feedback == "2")
                                        <td style="color:#070707; text-align:center;">ปรับปรุง</td>   
                                    @elseif($value->feedback == "3")
                                        <td style="color:#070707; text-align:center;">พอใช้</td>   
                                    @elseif($value->feedback == "4")
                                        <td style="color:#070707; text-align:center;">ดี</td>   
                                    @elseif($value->feedback == "5")
                                        <td style="color:#070707; text-align:center;">ดีมาก</td>
                                    @else
                                        <td style="color:#070707; text-align:center;"></td>
                                    @endif
                                    <td style="color:#070707; text-align:center;">{{$value->comment}}</td>
                                    <td style="color:#070707; text-align:center;">{{$value->created_at}}</td>
                                    <td style="color:#070707; text-align:center;"></td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection