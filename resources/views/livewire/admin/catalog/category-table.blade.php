<div class="category-manager-wrapper">
    @push('styles')
    <style>
        /* --- 1. MODERN PALETTE (Sang trọng & Tinh tế) --- */
        :root {
            /* [LIGHT MODE] */
            --cat-card-bg: #ffffff;
            --cat-card-border: #e2e8f0;    /* Viền xám nhạt */
            --cat-text-primary: #334155;   /* Màu chữ chính (Slate-700) */
            --cat-text-secondary: #64748b; /* Màu chữ phụ (Slate-500) */
            --cat-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --cat-hover-border: #3b82f6;   /* Xanh dương khi hover */
            --cat-line-color: #cbd5e1;     /* Đường kẻ nối */
        }

        /* [DARK MODE] - Tông màu Slate chuyên nghiệp */
        .dark-mode, [data-bs-theme="dark"] {
            --cat-card-bg: #1e293b !important;  /* Slate-800 */
            --cat-card-border: #334155 !important; /* Slate-700 */
            --cat-text-primary: #f1f5f9 !important; /* Trắng sáng */
            --cat-text-secondary: #94a3b8 !important; /* Xám bạc */
            --cat-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3) !important;
            --cat-hover-border: #60a5fa !important;
            --cat-line-color: #475569 !important;
        }

        /* --- 2. CARD STYLE --- */
        .category-card {
            background-color: var(--cat-card-bg) !important;
            border: 1px solid var(--cat-card-border) !important;
            color: var(--cat-text-primary);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            position: relative;
            transition: all 0.2s ease-in-out;
            box-shadow: var(--cat-shadow) !important;
        }

        .category-card:hover {
            border-color: var(--cat-hover-border) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        }

        /* --- 3. TYPOGRAPHY --- */
        .card-title-text {
            font-weight: 600;
            font-size: 1rem;
            color: var(--cat-text-primary);
        }

        /* --- 4. TREE STRUCTURE (Cấu trúc cây) --- */
        .children-container {
            margin-top: 16px;
            padding-left: 24px;
            border-left: 2px dashed var(--cat-line-color);
        }

        .children-container .category-card {
            margin-bottom: 10px;
        }

        /* --- 5. BUTTONS & ACTIONS --- */
        .btn-action-group {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid transparent;
            background-color: transparent;
            color: var(--cat-text-secondary);
            transition: all 0.2s;
        }

        .btn-add:hover { background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .btn-edit:hover { background-color: rgba(14, 165, 233, 0.1); color: #0ea5e9; }
        .btn-delete:hover { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .btn-action:disabled { opacity: 0.3; cursor: not-allowed; }

        /* --- 6. TOGGLE ARROW & ICONS --- */
        .toggle-arrow {
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            color: var(--cat-text-secondary);
            transition: all 0.2s;
        }
        .toggle-arrow:hover { background-color: rgba(128, 128, 128, 0.15); color: var(--cat-text-primary); }
        .toggle-arrow.expanded i { transform: rotate(180deg); }

        /* Badge ẩn */
        .badge-hidden {
            font-size: 0.75em;
            padding: 2px 8px;
            border-radius: 12px;
            background-color: rgba(100, 116, 139, 0.15);
            color: var(--cat-text-secondary);
        }
    </style>
    @endpush

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Sơ đồ Danh mục</h4>
        <button class="btn btn-primary shadow-sm px-3">
            <i class="fas fa-plus me-1"></i> Tạo Mới
        </button>
    </div>

    <div class="category-tree-container {{ session('theme_mode') == 'dark' ? 'dark-mode' : '' }}">
        @forelse($categories as $category)
        @include('livewire.admin.catalog.partials.category-row', ['category' => $category])
        @empty
        <div class="alert alert-light text-center p-5 border shadow-sm rounded-3">
            <i class="fas fa-folder-open fa-3x mb-3 text-muted" style="opacity: 0.3;"></i>
            <p class="m-0 fw-bold text-muted">Chưa có danh mục nào.</p>
        </div>
        @endforelse
    </div>
</div>
