@extends('/frontend/layouts/template/template-without-navbar')

@section('content')
    @php
        $name = DB::table('stores')->where('id', $branch_id)->value('name');
        $branch = DB::table('stores')->where('id', $branch_id)->value('branch');

    @endphp
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Food Quality Check list ({{ $name }} {{ $branch }}) ปี
                        {{ $year }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            @foreach ($months as $month => $value)
                @php
                    if ($value->month == '01') {
                        $month = 'เดือนมกราคม';
                    }
                    if ($value->month == '02') {
                        $month = 'เดือนกุมภาพันธ์';
                    }
                    if ($value->month == '03') {
                        $month = 'เดือนมีนาคม';
                    }
                    if ($value->month == '04') {
                        $month = 'เดือนเมษายน';
                    }
                    if ($value->month == '05') {
                        $month = 'เดือนพฤษภาคม';
                    }
                    if ($value->month == '06') {
                        $month = 'เดือนมิถุนายน';
                    }
                    if ($value->month == '07') {
                        $month = 'เดือนกรกฎาคม';
                    }
                    if ($value->month == '08') {
                        $month = 'เดือนสิงหาคม';
                    }
                    if ($value->month == '09') {
                        $month = 'เดือนกันยายน';
                    }
                    if ($value->month == '10') {
                        $month = 'เดือนตุลาคม';
                    }
                    if ($value->month == '11') {
                        $month = 'เดือนพฤศจิกายน';
                    }
                    if ($value->month == '12') {
                        $month = 'เดือนธันวาคม';
                    }
                @endphp
                <div class="col-md-3">
                    <a href="{{ url('/result-audit-by-date') }}/{{ $branch_id }}/{{$year}}/{{ $value->month }}"
                        class="btn btn-info btn-block">{{ $month }}</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
