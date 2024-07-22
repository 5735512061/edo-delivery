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
                    <h2 class="text-white pb-2 fw-bold">Food Quality Check list ({{ $name }} {{ $branch }}) 
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            @foreach ($years as $year => $value)
                <div class="col-md-3">
                    <a href="{{ url('/result-audit-by-month') }}/{{ $branch_id }}/{{ $value->year }}" class="btn btn-info btn-block">ปี {{$value->year}}</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
