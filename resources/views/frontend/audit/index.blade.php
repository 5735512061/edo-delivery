@extends('/frontend/layouts/template/template-without-navbar')

@section('content')
    @php
        $branchs = DB::table('stores')->get();
    @endphp
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">QUALITY CHECK LIST</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row mt-5">
            @foreach ($branchs as $branch => $value)
                <div class="col-md-3 mt-3">
                    <a href="{{ url('audit-check-list') }}/{{ $value->id }}"
                        class="btn btn-block btn-info">{{ $value->name }} {{ $value->branch }}</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
