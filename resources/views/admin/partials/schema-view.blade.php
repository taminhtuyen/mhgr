@php
// 1. Logic nhận diện Module
$currentRoute = Request::route() ? Request::route()->getName() : '';
$parts = explode('.', $currentRoute);

$entity = '';
if (count($parts) >= 2) {
$entity = (count($parts) >= 3) ? $parts[count($parts) - 2] : end($parts);
}
if (!$entity) {
$segments = Request::segments();
$entity = end($segments);
}

$map = \App\Services\System\SchemaDocsService::getModuleMap();
$config = $map[$entity] ?? null;

// 2. Logic Nạp dữ liệu
$tablesToFetch = [];
$mainTableData = null;

if ($config) {
$mainTableData = \App\Services\System\SchemaDocsService::getTableDetails($config['main']);

if ($mainTableData) {
$tablesToFetch[$config['main']] = $mainTableData;

// Quét tìm bảng liên kết từ Main Table
foreach ($mainTableData['columns'] as $col) {
if (!empty($col['foreign_key'])) {
$tablesToFetch[$col['foreign_key']['table']] = true;
}
}
}

// Thêm các bảng related thủ công
foreach ($config['related'] as $rel) {
$tablesToFetch[$rel] = true;
}
}

$allSchemaData = [];
foreach ($tablesToFetch as $tableName => $val) {
if (is_array($val)) {
$allSchemaData[$tableName] = $val;
} else {
$data = \App\Services\System\SchemaDocsService::getTableDetails($tableName);
if ($data) {
$allSchemaData[$tableName] = $data;
}
}
}
@endphp

<style>
    /* CSS Variables */
    :root {
        --sv-bg: #ffffff;
        --sv-text: #334155;
        --sv-text-mute: #64748b;
        --sv-border: #e2e8f0;
        --sv-card-bg: #f8fafc;
        --sv-header-bg: #f1f5f9;
        --sv-hl-text: #0f172a;
        --sv-accent: #3b82f6;
        --sv-code: #d946ef;
        --sv-link-color: #0d6efd;
    }

    body.dark-mode {
        --sv-bg: #1e1e2d;
        --sv-text: #cbd5e1;
        --sv-text-mute: #94a3b8;
        --sv-border: #2d2d3b;
        --sv-card-bg: #151521;
        --sv-header-bg: #2b2b40;
        --sv-hl-text: #ffffff;
        --sv-accent: #60a5fa;
        --sv-code: #f0abfc;
        --sv-link-color: #60a5fa;
    }

    .schema-box { background-color: var(--sv-bg); color: var(--sv-text); border: 1px dashed var(--sv-border); border-radius: 8px; margin-bottom: 1.5rem; }
    .schema-card { background-color: var(--sv-card-bg); border: 1px solid var(--sv-border); border-radius: 6px; overflow: hidden; }
    .schema-card-header { background-color: var(--sv-header-bg); border-bottom: 1px solid var(--sv-border); padding: 10px 15px; font-weight: 600; display: flex; justify-content: space-between; align-items: center; color: var(--sv-hl-text); }
    .schema-table th { background-color: var(--sv-header-bg); color: var(--sv-text); border-bottom: 2px solid var(--sv-border); font-size: 0.8rem; text-transform: uppercase; font-weight: 700; padding: 12px 15px; white-space: nowrap; }
    .schema-table td { border-bottom: 1px solid var(--sv-border); color: var(--sv-text); font-size: 0.95rem; padding: 10px 15px; vertical-align: middle; line-height: 1.5; }

    .sv-col-name { font-family: 'Consolas', 'Monaco', monospace; color: var(--sv-code); font-weight: 600; }
    .sv-col-type { font-family: 'Consolas', 'Monaco', monospace; font-weight: 500; color: var(--sv-text); }

    .fk-link { color: var(--sv-link-color); text-decoration: none; border-bottom: 1px dashed var(--sv-link-color); cursor: pointer; transition: all 0.2s; }
    .fk-link:hover { opacity: 0.8; border-bottom-style: solid; }

    .col-meta { font-size: 0.85rem; line-height: 1.4; }
    .meta-label { color: var(--sv-text-mute); font-size: 0.75em; text-transform: uppercase; margin-right: 4px; }

    .scroll-table-container { max-height: 350px; overflow-y: auto; }
    .scroll-table-container::-webkit-scrollbar { width: 6px; height: 6px; }
    .scroll-table-container::-webkit-scrollbar-thumb { background: var(--sv-border); border-radius: 3px; }

    /* MODAL FIX */
    #schemaModal { z-index: 10000 !important; }
    #schemaModal .modal-content { background-color: var(--sv-bg); color: var(--sv-text); border: 1px solid var(--sv-border); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    #schemaModal .modal-header { border-bottom: 1px solid var(--sv-border); }
    #schemaModal .modal-footer { border-top: 1px solid var(--sv-border); }
    #schemaModal .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
    body:not(.dark-mode) #schemaModal .btn-close { filter: none; }
</style>

<div class="schema-box p-4">
    {{-- HEADER --}}
    <div class="d-flex align-items-center mb-4">
        <div class="me-3 fs-1 text-primary"><i class="fa-duotone fa-map-location-dot"></i></div>
        <div>
            <h5 class="fw-bold text-uppercase mb-1" style="color: var(--sv-hl-text);">
                BẢN ĐỒ: <span class="text-primary">{{ isset($config['title']) ? strtoupper($config['title']) : strtoupper($entity) }}</span>
            </h5>
            <p class="mb-0 small text-muted">
                @if($config && isset($config['description']))
                <i class="fa-solid fa-bullseye me-1"></i> {{ $config['description'] }}
                @else
                <span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>Chưa định nghĩa Map cho module: <strong>{{ $entity }}</strong></span>
                @endif
            </p>
        </div>
    </div>

    @if($config && $mainTableData)
    <div class="row g-4">
        {{-- 1. BẢNG CHÍNH --}}
        <div class="col-12">
            <div class="mb-2 fw-bold text-uppercase border-start border-3 border-primary ps-2" style="color: var(--sv-text);">
                <i class="fa-solid fa-database me-2"></i>Bảng Dữ Liệu Chính
            </div>

            <div class="card schema-card shadow-sm mb-4">
                <div class="schema-card-header">
                    <span><i class="fa-solid fa-table me-2"></i><span class="font-monospace fs-5">{{ $config['main'] }}</span></span>
                    <span class="badge bg-primary">Primary Entity</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table schema-table table-borderless mb-0 w-100">
                            <thead>
                            <tr>
                                <th width="25%">Cột (Column)</th>
                                <th width="20%">Kiểu (Type)</th>
                                <th width="20%">DEFAULT / NULL</th>
                                <th width="35%">Ý nghĩa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mainTableData['columns'] as $col)
                            <tr>
                                <td class="sv-col-name">
                                    @if(!empty($col['foreign_key']))
                                    {{-- LOGIC MỚI: Kiểm tra nếu bảng liên kết KHÁC bảng hiện tại thì mới cho click --}}
                                    @if($col['foreign_key']['table'] !== $config['main'])
                                    {{-- Link Popup (Cho bảng khác) --}}
                                    <a href="javascript:void(0)" class="fk-link"
                                       onclick="openSchemaModal('{{ $col['foreign_key']['table'] }}', '{{ $col['foreign_key']['column'] }}')">
                                        {{ $col['name'] }}
                                    </a>
                                    <i class="fa-solid fa-arrow-up-right-from-square ms-1 text-muted" style="font-size: 0.6em"></i>
                                    @else
                                    {{-- Nếu liên kết với chính nó (VD: parent_id) -> Không click, hiện icon đệ quy --}}
                                    {{ $col['name'] }}
                                    <span class="badge text-secondary border ms-1" title="Liên kết nội bộ (Self-Reference)">
                                        <i class="fa-solid fa-rotate-left me-1"></i>Self
                                    </span>
                                    @endif
                                    @else
                                    {{ $col['name'] }}
                                    @endif

                                    @if($col['key'] == 'PRI') <i class="fa-solid fa-key text-warning ms-1 small" title="PK"></i> @endif
                                </td>
                                <td class="sv-col-type">{{ $col['type'] }}</td>

                                <td class="col-meta">
                                    <div class="d-flex align-items-center">
                                        <span class="meta-label" style="min-width: 60px;">DEFAULT:</span>
                                        <span class="fw-bold">{{ $col['default'] === null ? 'NULL' : ($col['default'] === '' ? "''" : $col['default']) }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="meta-label" style="min-width: 60px;">NULL:</span>
                                        <span class="{{ $col['nullable'] == 'Yes' ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                            {{ $col['nullable'] }}
                                        </span>
                                    </div>
                                </td>

                                <td>{{ $col['comment'] }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. BẢNG LIÊN QUAN --}}
        @if(!empty($config['related']))
        <div class="col-12">
            <div class="mb-3 fw-bold text-uppercase border-start border-3 border-info ps-2" style="color: var(--sv-text);">
                <i class="fa-solid fa-project-diagram me-2"></i>Bảng Phụ / Chi Tiết
            </div>

            <div class="row g-3">
                @foreach($config['related'] as $relTable)
                @if(isset($allSchemaData[$relTable]))
                @php $subTable = $allSchemaData[$relTable]; @endphp
                <div class="col-lg-6 col-12">
                    <div class="card schema-card h-100 shadow-sm">
                        <div class="schema-card-header">
                            <span class="fs-6"><i class="fa-solid fa-table-cells me-2 text-muted"></i><span class="font-monospace">{{ $relTable }}</span></span>
                            <i class="fa-solid fa-link text-muted small"></i>
                        </div>
                        <div class="card-body p-0">
                            <div class="scroll-table-container">
                                <table class="table schema-table table-sm table-borderless mb-0 w-100">
                                    <thead class="sticky-top" style="z-index: 1;">
                                    <tr>
                                        <th width="35%">Cột</th>
                                        <th width="20%">Kiểu</th>
                                        <th width="20%">DEFAULT/NULL</th>
                                        <th width="25%">Ý nghĩa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subTable['columns'] as $col)
                                    <tr>
                                        <td class="sv-col-name small">
                                            {{ $col['name'] }}
                                            @if($col['key'] == 'PRI') <i class="fa-solid fa-key text-warning" style="font-size: 0.7em"></i> @endif
                                        </td>
                                        <td class="sv-col-type small">
                                            {{ $col['type'] }}
                                        </td>

                                        <td class="small">
                                            <div class="d-flex flex-column">
                                                                        <span class="text-muted" style="font-size: 0.8em">
                                                                            {{ $col['default'] === null ? 'NULL' : $col['default'] }}
                                                                        </span>
                                                <span class="{{ $col['nullable'] == 'Yes' ? 'text-success' : 'text-danger' }}" style="font-size: 0.8em">
                                                                            {{ $col['nullable'] }}
                                                                        </span>
                                            </div>
                                        </td>

                                        <td class="small">{{ Str::limit($col['comment'], 45) }}</td>
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
        </div>
        @endif
    </div>
    @else
    <div class="alert alert-danger">Không tìm thấy dữ liệu bảng <strong>{{ $config['main'] }}</strong> trong Database!</div>
    @endif
</div>

{{-- MODAL --}}
<div class="modal fade" id="schemaModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold font-monospace" id="schemaModalLabel">Table Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <table class="table schema-table table-borderless mb-0 w-100" id="schemaModalTable">
                    <thead class="sticky-top">
                    <tr>
                        <th width="30%">Cột</th>
                        <th width="20%">Kiểu</th>
                        <th width="20%">DEFAULT/NULL</th>
                        <th width="30%">Ý nghĩa</th>
                    </tr>
                    </thead>
                    <tbody id="schemaModalBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.schemaData = @json($allSchemaData);

    function openSchemaModal(tableName, targetColumn) {
        const data = window.schemaData[tableName];
        if (!data) {
            alert('Không tìm thấy dữ liệu bảng: ' + tableName);
            return;
        }

        // Move modal to body to fix stacking issues
        const modalEl = document.getElementById('schemaModal');
        if (modalEl.parentElement !== document.body) {
            document.body.appendChild(modalEl);
        }

        document.getElementById('schemaModalLabel').innerHTML = '<i class="fa-solid fa-table me-2"></i>' + tableName.toUpperCase();

        const tbody = document.getElementById('schemaModalBody');
        tbody.innerHTML = '';

        data.columns.forEach(col => {
            const tr = document.createElement('tr');

            // Xóa logic highlight nền đỏ, để hiển thị bình thường

            let defaultVal = col.default === null ? 'NULL' : col.default;
            let nullClass = col.nullable === 'Yes' ? 'text-success' : 'text-danger';
            let keyIcon = col.key === 'PRI' ? '<i class="fa-solid fa-key ms-1 text-warning" style="font-size: 0.8em"></i>' : '';

            tr.innerHTML = `
                <td class="sv-col-name">${col.name} ${keyIcon}</td>
                <td class="sv-col-type">${col.type}</td>
                <td class="small">
                    <div><span class="text-muted small me-1">DEFAULT:</span><b>${defaultVal}</b></div>
                    <div><span class="text-muted small me-1">NULL:</span><span class="${nullClass}">${col.nullable}</span></div>
                </td>
                <td>${col.comment || ''}</td>
            `;
            tbody.appendChild(tr);
        });

        const myModal = new bootstrap.Modal(modalEl);
        myModal.show();
    }
</script>
