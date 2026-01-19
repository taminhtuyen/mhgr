@php
    // Lấy tên view hiện tại (ví dụ: admin.sales.orders.index)
    $currentView = Request::route()->getName(); // admin.sales.orders.index
    // Tách lấy phần entity (orders)
    $parts = explode('.', $currentView);
    $entity = (count($parts) >= 3) ? $parts[count($parts) - 2] : '';

    // Fix case: 'index' route name might differ from folder structure
    // Fallback: Lấy từ URL
    if(!$entity) {
         $segments = Request::segments();
         $entity = end($segments);
    }

    $map = \App\Services\System\SchemaDocsService::getModuleMap();
    $config = $map[$entity] ?? null;
@endphp

<div class="schema-docs-container p-4">
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <h4 class="alert-heading fw-bold"><i class="fa-solid fa-compass-drafting"></i> CHẾ ĐỘ THIẾT KẾ (BLUEPRINT MODE)</h4>
        <p class="mb-0">Đây là giao diện tạm thời giúp bạn hình dung cấu trúc dữ liệu trước khi viết code chức năng. Sau khi hoàn thiện, giao diện này sẽ được thay thế bằng danh sách dữ liệu thực tế.</p>
    </div>

    @if($config)
        {{-- BẢNG CHÍNH --}}
        @php $mainTable = \App\Services\System\SchemaDocsService::getTableDetails($config['main']); @endphp
        @if($mainTable)
            <div class="card mb-4 border-primary shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-database"></i> BẢNG CHÍNH: {{ strtoupper($config['main']) }}</h5>
                    <span class="badge bg-white text-primary">Core Entity</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Tên Cột</th>
                                    <th width="15%">Kiểu Dữ Liệu</th>
                                    <th width="10%">Null?</th>
                                    <th width="10%">Mặc định</th>
                                    <th width="50%">Tác Dụng / Ý Nghĩa (Mô tả)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainTable['columns'] as $col)
                                    <tr>
                                        <td class="font-monospace text-primary fw-bold">
                                            {{ $col['name'] }}
                                            @if($col['key'] == 'PRI') <i class="fa-solid fa-key text-warning ms-1" title="Primary Key"></i> @endif
                                            @if($col['key'] == 'MUL') <i class="fa-solid fa-link text-secondary ms-1" title="Foreign Key/Index"></i> @endif
                                        </td>
                                        <td><span class="badge bg-secondary">{{ $col['type'] }}</span></td>
                                        <td>{{ $col['null'] }}</td>
                                        <td class="text-muted">{{ $col['default'] ?? 'NULL' }}</td>
                                        <td>{{ $col['comment'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger">Không tìm thấy bảng <strong>{{ $config['main'] }}</strong> trong CSDL.</div>
        @endif

        {{-- CÁC BẢNG LIÊN QUAN --}}
        @if(!empty($config['related']))
            <h5 class="fw-bold text-secondary mb-3 mt-5"><i class="fa-solid fa-project-diagram"></i> CÁC BẢNG PHỤ TRỢ (RELATED TABLES)</h5>
            <div class="row">
                @foreach($config['related'] as $relTable)
                    @php $subTable = \App\Services\System\SchemaDocsService::getTableDetails($relTable); @endphp
                    @if($subTable)
                        <div class="col-12 mb-4">
                            <div class="card border-secondary shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <span class="fw-bold"><i class="fa-solid fa-table"></i> {{ $relTable }}</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="20%">Cột</th>
                                                    <th width="20%">Kiểu</th>
                                                    <th width="60%">Mô tả</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subTable['columns'] as $col)
                                                    <tr>
                                                        <td class="font-monospace fw-bold">{{ $col['name'] }}</td>
                                                        <td>{{ $col['type'] }}</td>
                                                        <td class="small">{{ $col['comment'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

    @else
        <div class="text-center py-5">
            <h3 class="text-muted">Chưa có dữ liệu thiết kế cho Module này</h3>
            <p>Vui lòng cập nhật mapping trong <code>SchemaDocsService.php</code></p>
            <p class="text-monospace">Key hiện tại: <strong>{{ $entity }}</strong></p>
        </div>
    @endif
</div>