@extends('/backend/layouts/template/template-admin')

@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">URL รับสมัครงาน</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ url('/admin/url-apply-work') }}" enctype="multipart/form-data" method="post">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="navbar-left navbar-form  mr-md-3">
                                        <div class="input-group">
                                            <input type="text" placeholder="กรุณากรอกชื่อร้านค้า / สาขาในเครือ"
                                                class="form-control" name="branch_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="navbar-left navbar-form  mr-md-3">
                                        <div class="input-group">
                                            <input type="text" placeholder="กรุณากรอก URL หรือชื่อร้านค้าภาษาอังกฤษ"
                                                class="form-control" name="url_name">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">บันทึกชื่อร้านค้า / สาขา</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อร้านค้าในเครือ</th>
                                        <th>ชื่อ URL</th>
                                        <th>Copy Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($url_apply_works as $url_apply_work => $value)
                                        <tr>
                                            <td>{{ $NUM_PAGE * ($page - 1) + $url_apply_work + 1 }}</td>
                                            <td>{{ $value->branch_name }}</td>
                                            <td>{{ $value->url_name }}</td>
                                            {{-- <td>{{ url('/apply-work') }}/{{ $value->url_name }}</td> --}}
                                            <td>
                                                <p id="{{ $value->id }}" style="display: none;">    
                                                    {{ url('/apply-work') }}/{{ $value->url_name }}</p>
                                                <a href="" style="color: #1229f5;"
                                                    onclick="copyToClipboard({{ $value->id }})">COPY LINK</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{ $url_apply_works->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        function copyToClipboard(elementId) {
            var aux = document.createElement("input");
            aux.setAttribute("value", document.getElementById(elementId).innerHTML);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
        }
    </script>
@endsection
