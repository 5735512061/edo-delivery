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
                        {{ $date }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="card mb-4">
            <div class="card-body">
                @if (count($results) != 0)
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
                            @foreach ($results as $result => $value)
                                @php
                                    $number = DB::table('audits')
                                        ->where('id', $value->list_id)
                                        ->value('number');
                                    $list = DB::table('audits')
                                        ->where('id', $value->list_id)
                                        ->value('list');
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $number }}</td>
                                        <td>{{ $list }}</td>
                                        <td>
                                            @if ($value->checklist == 'ปกติ')
                                                <input type="radio" id="normal{{ $value->id }}"
                                                    name="checklist[{{ $value->id }}]" value="ปกติ" checked>
                                                <label for="normal{{ $value->id }}">ปกติ</label>
                                                <input type="radio" id="notnormal{{ $value->id }}"
                                                    name="checklist[{{ $value->id }}]" value="ไม่ปกติ">
                                                <label for="notnormal{{ $value->id }}">
                                                    <div style="color:red;">ไม่ปกติ</div>
                                                </label>
                                            @else
                                                <input type="radio" id="normal{{ $value->id }}"
                                                    name="checklist[{{ $value->id }}]" value="ปกติ">
                                                <label for="normal{{ $value->id }}">ปกติ</label>
                                                <input type="radio" id="notnormal{{ $value->id }}"
                                                    name="checklist[{{ $value->id }}]" value="ไม่ปกติ" checked>
                                                <label for="notnormal{{ $value->id }}">
                                                    <div style="color:red;">ไม่ปกติ</div>
                                                </label>
                                            @endif
                                        </td>
                                        <td><input name="comment[{{ $value->id }}]" type="text"
                                                value="{{ $value->comment }}" /></td>
                                        {{-- <td>
                                                    <input type="file" name="image[{{ $value->id }}]">
                                                </td> --}}
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                        <textarea name="comment_detail" cols="30" rows="5" class="form-control" placeholder="ข้อเสนอแนะอื่นๆ">{{ $value->comment_detail }}</textarea>
                    </div><br>
                @endif
            </div>
        </div>
    </div>
@endsection
