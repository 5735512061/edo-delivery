@extends('/frontend/layouts/template/template-without-navbar')

@section('content')
    @php
        $name = DB::table('stores')->where('id', $branch_id)->value('name');
        $branch = DB::table('stores')->where('id', $branch_id)->value('branch');
        $date = Carbon\Carbon::now();
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
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has('alert-' . $msg))
                <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
            @endif
        @endforeach
        <div class="card mb-4">
            <form action="{{ url('/checklist-audit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if (count($checklists) != 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>list</th>
                                        <th>ปกติ/ไม่ปกติ</th>
                                        <th>หมายเหตุ</th>
                                        {{-- <th>รูปภาพ</th> --}}
                                    </tr>
                                </thead>
                                @foreach ($checklists as $checklist => $value)
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>{{ $value->number }}</td>
                                            <td>{{ $value->list }}</td>
                                            <td>
                                                <input type="radio" id="normal{{ $value->id }}"
                                                    name="checklist[{{ $value->id }}]" value="ปกติ">
                                                <label for="normal{{ $value->id }}">ปกติ</label>
                                                <input type="radio" id="notnormal{{ $value->id }}"
                                                    name="checklist[{{ $value->id }}]" value="ไม่ปกติ">
                                                <label for="notnormal{{ $value->id }}">
                                                    <div style="color:red;">ไม่ปกติ</div>
                                                </label>
                                            </td>
                                            <td><input name="comment[{{ $value->id }}]" type="text" /></td>
                                            {{-- <td>
                                                <input type="file" name="image[{{ $value->id }}]">
                                            </td> --}}
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div><br>
                    @endif
                    <input type="hidden" name="branch_id" value="{{ $branch_id }}">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <center><button class="btn btn-info mt-3" style="font-family:Noto Sans Thai; ">บันทึกข้อมูล</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
@endsection
