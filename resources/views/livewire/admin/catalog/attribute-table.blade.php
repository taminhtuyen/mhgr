<div class="category-manager-wrapper">
    {{-- Import Custom CSS --}}
    @push('styles')
    <style>
        /* CSS Variables cho Dark/Light Mode */
        :root {
            --cat-border-color: #dee2e6;
            --cat-bg-color: #ffffff;
            --cat-text-color: #212529;
            --cat-hover-bg: #f8f9fa;
            --cat-line-color: #e9ecef;
        }

        /* Dark Mode Overrides (Nếu class cha là .dark-mode) */
        .dark-mode {
            --cat-border-color: #495057;
            --cat-bg-color: #212529;
            --cat-text-color: #f8f9fa;
            --cat-hover-bg: #343a40;
            --cat-line-color: #343a40;
        }

        .category-tree {
            font-size: 0.95rem; /* rem unit */
        }

        .category-node {
            background-color: var(--cat-bg-color);
            color: var(--cat-text-color);
            border: 1px solid var(--cat-border-color);
            border-radius: 0.375rem; /* Bootstrap rounded */
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
        }

        /* Hiệu ứng đổ bóng nhẹ cho các khối */
        .category-node {
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .category-header {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; /* Cho phép xuống dòng trên mobile */
            gap: 0.5rem;
        }

        .category-header:hover {
            background-color: var(--cat-hover-bg);
        }

        .category-name {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-grow: 1;
        }

        .category-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-icons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-right: 1rem;
            color: #6c757d; /* Muted text */
        }

        /* Container cho con */
        .category-children {
            padding: 0.5rem 0.5rem 0.5rem 1.5rem; /* Thụt lề trái */
            border-top: 1px solid var(--cat-border-color);
            background-color: rgba(0,0,0,0.02); /* Màu nền rất nhạt để phân biệt */
        }

        /* Responsive chỉnh sửa */
        @media (max-width: 576px) {
            .category-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .category-actions {
                width: 100%;
                justify-content: space-between;
                margin-top: 0.5rem;
            }
            .category-children {
                padding-left: 0.5rem; /* Giảm thụt lề trên mobile */
            }
        }

        /* Toggle Icon xoay */
        .toggle-icon {
            transition: transform 0.2s;
            cursor: pointer;
        }
        .toggle-icon.expanded {
            transform: rotate(90deg);
        }
    </style>
    @endpush

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Sơ đồ Danh mục</h4>
        <button class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tạo Danh Mục Gốc
        </button>
    </div>

    <div class="category-tree {{ session('theme_mode') == 'dark' ? 'dark-mode' : '' }}">
        @forelse($categories as $category)
        @include('livewire.admin.catalog.partials.category-row', ['category' => $category])
        @empty
        <div class="alert alert-info text-center">
            Chưa có danh mục nào. Hãy tạo danh mục đầu tiên!
        </div>
        @endforelse
    </div>
</div>
