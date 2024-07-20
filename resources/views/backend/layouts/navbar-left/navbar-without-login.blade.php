<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a data-toggle="collapse" href="#branch">
                        <i class="fas fa-th-list"></i>
                        <p>Audit Checklist</p>
                        <span class="caret"></span>
                    </a>
                    @php
                        $branchs = DB::table('stores')->get();
                    @endphp
                    <div class="collapse" id="branch">
                        <ul class="nav nav-collapse">
                            @foreach ($branchs as $branch => $value)
                                <li>
                                    <a href="{{ url('audit-check-list') }}/{{ $value->id }}">
                                        <span class="sub-item">{{ $value->name }} {{ $value->branch }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#audit">
                        <i class="fas fa-th-list"></i>
                        <p>ผลการตรวจเช็ค Audit</p>
                        <span class="caret"></span>
                    </a>
                    @php
                        $branchs = DB::table('stores')->get();
                    @endphp
                    <div class="collapse" id="audit">
                        <ul class="nav nav-collapse">
                            @foreach ($branchs as $branch => $value)
                                <li>
                                    <a href="{{ url('audit-check-list') }}/{{ $value->id }}">
                                        <span class="sub-item">{{ $value->name }} {{ $value->branch }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
