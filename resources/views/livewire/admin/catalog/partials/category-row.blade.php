@php
// --- LOGIC TÍNH TOÁN THỐNG KÊ CON CHÁU (RECURSIVE COUNT) ---
// Mục đích: Tạo ra chuỗi [3-2]-5 để hiển thị số lượng con ở từng cấp độ sâu.

$stats = [];            // Mảng chứa số lượng phần tử tại mỗi cấp: [Cấp 1, Cấp 2, Cấp 3...]
$totalDescendants = 0;  // Tổng số con cháu

// Sử dụng hàng đợi để duyệt cây (Breadth-First Search) để tránh đệ quy quá sâu
// Bắt đầu với danh sách con trực tiếp của danh mục hiện tại
$queue = [];
if($category->children->count() > 0) {
$queue[] = ['items' => $category->children, 'depth' => 0];
}

// Vòng lặp duyệt cây
while(count($queue) > 0) {
$node = array_shift($queue);
$items = $node['items'];
$depth = $node['depth'];

$count = $items->count();
if ($count > 0) {
// Cộng dồn vào mảng thống kê theo cấp độ sâu
if (!isset($stats[$depth])) $stats[$depth] = 0;
$stats[$depth] += $count;
$totalDescendants += $count;

// Tiếp tục đưa con của các item này vào hàng đợi để duyệt cấp tiếp theo
foreach ($items as $item) {
if ($item->children->count() > 0) {
$queue[] = ['items' => $item->children, 'depth' => $depth + 1];
}
}
}
}

// Tạo chuỗi hiển thị: [3-2-8]-13
$statString = '';
if (!empty($stats)) {
// Phần trong ngoặc: [3-2-8]
$statString = '[' . implode('-', $stats) . ']';

// Nếu có nhiều hơn 1 cấp độ con, hiển thị thêm tổng số (-13)
if (count($stats) > 1) {
$statString .= '-' . $totalDescendants;
}
}

// Xác định Parent ID để xử lý đóng mở Accordion
$parentId = $category->parent_id ?? 'root';
@endphp

<div x-data="{
        open: false,
        id: {{ $category->id }},
        parentId: '{{ $parentId }}',
        toggle() {
            this.open = !this.open;
            if (this.open) {
                // Khi mở, gửi sự kiện để đóng các thẻ anh em
                $dispatch('accordion-change', { id: this.id, parentId: this.parentId });
            }
        }
     }"
     @accordion-change.window="
        if ($event.detail.parentId == parentId && $event.detail.id != id) {
            open = false;
        }
     "
     class="w-100">

    {{-- THẺ CARD --}}
    <div class="category-card">

        {{-- 1. HEADER (DÒNG TRÊN): TÊN & ICON FA (CỐ ĐỊNH PHẢI) --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            {{-- Trái: Tên & Badge --}}
            <div class="d-flex align-items-center" style="min-width: 0;"> {{-- min-width: 0 giúp text-truncate hoạt động tốt --}}
                <span class="card-title-text text-truncate me-2">
                    {{ $category->name }}
                </span>
                                                                          @if(!$category->is_active)
                <span class="badge-hidden">Ẩn</span>
                                                                          @endif
            </div>

            {{-- Phải: ICON FA (Nằm cố định góc phải trên) --}}
            <div class="d-flex gap-3 ms-3" style="color: var(--cat-text-secondary); font-size: 1.1rem; opacity: 0.9; white-space: nowrap;">
                @if($category->fa_icon)
                <i class="{{ $category->fa_icon }}" title="Icon Chính"></i>
                @endif
                @if($category->fa_icon_back)
                <i class="{{ $category->fa_icon_back }}" title="Icon Phụ"></i>
                @endif
            </div>
        </div>

        {{-- 2. TOOLBAR (DÒNG DƯỚI): NÚT BẤM & THỐNG KÊ & MŨI TÊN --}}
        <div class="d-flex justify-content-between align-items-center">

            {{-- Trái: Nút bấm --}}
            <div class="btn-action-group">
                <button class="btn-action btn-add" title="Thêm danh mục con">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="btn-action btn-edit" title="Chỉnh sửa">
                    <i class="fas fa-pen" style="font-size: 0.9em;"></i>
                </button>
                <button class="btn-action btn-delete"
                        title="Xóa"
                        @if($category->children->count() > 0) disabled @endif
                                       wire:confirm="Bạn có chắc chắn muốn xóa danh mục này?"
                                       wire:click="deleteCategory({{ $category->id }})">
                    <i class="fas fa-trash" style="font-size: 0.9em;"></i>
                </button>
            </div>

            {{-- Phải: Thống kê + Mũi tên --}}
            <div class="d-flex align-items-center">

                {{-- [NEW] THỐNG KÊ SỐ LƯỢNG CON CHÁU --}}
                @if($statString)
                <span class="text-muted font-monospace me-2 user-select-none"
                      style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.8;"
                      title="Thống kê cấp độ con: [C1-C2-C3]-Tổng">
                        {{ $statString }}
                    </span>
                @endif

                {{-- Mũi tên Toggle --}}
                @if($category->children->count() > 0)
                <div class="toggle-arrow"
                     @click="toggle()"
                     :class="{ 'expanded': open }"
                     title="Mở rộng / Thu gọn">
                    <i class="fas fa-chevron-down"></i>
                </div>
                @else
                {{-- Giữ chỗ để layout cân đối nếu không có con --}}
                <div style="width: 28px;"></div>
                @endif
            </div>
        </div>

        {{-- 3. DANH MỤC CON --}}
        @if($category->children->count() > 0)
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="children-container"
             style="display: none;">

            @foreach($category->children as $child)
            @include('livewire.admin.catalog.partials.category-row', ['category' => $child])
            @endforeach

        </div>
        @endif

    </div>
</div>
