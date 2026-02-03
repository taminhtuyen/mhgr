<div wire:poll.10s>
    {{-- PHẦN 1: 4 WIDGET THỐNG KÊ --}}
    <div class="row g-3 mb-4">
        {{-- Widget 1: Doanh Thu --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="db-card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="db-icon-box bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="db-text-sub text-uppercase fw-bold mb-0" style="font-size: 0.75rem;">Doanh Thu</h6>
                    </div>
                </div>
                <h3 class="mb-0 fw-bold db-text-main" style="font-size: 1.5rem;">
                    {{ number_format($stats['revenue'] ?? 0, 0, ',', '.') }} ₫
                </h3>
                <small class="db-text-sub small">Tổng doanh thu thực tế</small>
            </div>
        </div>

        {{-- Widget 2: Đơn Hàng --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="db-card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="db-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-shopping-bag"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="db-text-sub text-uppercase fw-bold mb-0" style="font-size: 0.75rem;">Đơn Hàng</h6>
                    </div>
                </div>
                <h3 class="mb-0 fw-bold db-text-main" style="font-size: 1.5rem;">
                    {{ number_format($stats['orders'] ?? 0) }}
                </h3>
                <small class="db-text-sub small">Tổng số đơn hàng</small>
            </div>
        </div>

        {{-- Widget 3: Khách Hàng --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="db-card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="db-icon-box bg-info bg-opacity-10 text-info">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="db-text-sub text-uppercase fw-bold mb-0" style="font-size: 0.75rem;">Khách Hàng</h6>
                    </div>
                </div>
                <h3 class="mb-0 fw-bold db-text-main" style="font-size: 1.5rem;">
                    {{ number_format($stats['customers'] ?? 0) }}
                </h3>
                <small class="db-text-sub small">User hệ thống</small>
            </div>
        </div>

        {{-- Widget 4: Sản Phẩm --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="db-card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="db-icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="db-text-sub text-uppercase fw-bold mb-0" style="font-size: 0.75rem;">Sản Phẩm</h6>
                    </div>
                </div>
                <h3 class="mb-0 fw-bold db-text-main" style="font-size: 1.5rem;">
                    {{ number_format($stats['products'] ?? 0) }}
                </h3>
                <small class="db-text-sub small">Sản phẩm khả dụng</small>
            </div>
        </div>
    </div>

    {{-- PHẦN 2: BIỂU ĐỒ (QUAN TRỌNG) --}}
    <div class="row">
        <div class="col-12">
            <div class="db-card h-100">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--db-border-color) !important;">
                    <h6 class="mb-0 fw-bold db-text-main">
                        <i class="fa-solid fa-chart-area me-2 text-primary"></i>Doanh Thu 7 Ngày Qua (Demo)
                    </h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Live Update</span>
                </div>

                {{--
                wire:ignore -> Bắt buộc có để Livewire KHÔNG render lại thẻ này
                (tránh làm mất biểu đồ khi số liệu thay đổi)
                --}}
                <div class="p-3" wire:ignore>
                    <div id="revenueChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
