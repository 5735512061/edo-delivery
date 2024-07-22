@extends('/frontend/layouts/template/template-without-navbar')

@section('content')
    @php
        $name = DB::table('stores')->where('id', $branch_id)->value('name');
        $branch = DB::table('stores')->where('id', $branch_id)->value('branch');
        if ($month == '01') {
            $month_ = 'เดือนมกราคม';
        }
        if ($month == '02') {
            $month_ = 'เดือนกุมภาพันธ์';
        }
        if ($month == '03') {
            $month_ = 'เดือนมีนาคม';
        }
        if ($month == '04') {
            $month_ = 'เดือนเมษายน';
        }
        if ($month == '05') {
            $month_ = 'เดือนพฤษภาคม';
        }
        if ($month == '06') {
            $month_ = 'เดือนมิถุนายน';
        }
        if ($month == '07') {
            $month_ = 'เดือนกรกฎาคม';
        }
        if ($month == '08') {
            $month_ = 'เดือนสิงหาคม';
        }
        if ($month == '09') {
            $month_ = 'เดือนกันยายน';
        }
        if ($month == '10') {
            $month_ = 'เดือนตุลาคม';
        }
        if ($month == '11') {
            $month_ = 'เดือนพฤศจิกายน';
        }
        if ($month == '12') {
            $month_ = 'เดือนธันวาคม';
        }
    @endphp
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Food Quality Check list ({{ $name }} {{ $branch }}) ปี
                        {{ $year }} {{ $month_ }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            @foreach ($days as $day => $value)
                <div class="col-md-3">
                    <a href="{{ url('/result-audit-detail') }}/{{ $branch_id }}/{{ $value->date }}"
                        class="btn btn-info btn-block">ครั้งที่ {{$day+1}} {{ $value->date }}</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
