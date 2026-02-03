@extends('admin.layouts.master')

@section('title', 'Tổng quan Hệ thống')

@push('styles')
<style>
    /* -----------------------------------------------------------
       1. CẤU HÌNH BIẾN MÀU (CSS VARIABLES)
       ----------------------------------------------------------- */
    :root {
        --db-card-bg: #ffffff;
        --db-text-main: #2b3445;
        --db-text-sub: #7d879c;
        --db-border-color: rgba(0,0,0,0.05);
        --db-shadow: 0 0.25rem 1rem rgba(0,0,0,0.05);
        --db-primary: #0d6efd;

        /* Màu nền riêng cho Tooltip Header để tạo điểm nhấn */
        --db-tooltip-header: #f8f9fa;
    }

    /* CHẾ ĐỘ TỐI (DARK MODE) */
    [data-theme="dark"], body.dark-mode {
        --db-card-bg: #1e1e2d;
        --db-text-main: #e4e6ef;
        --db-text-sub: #b5b5c3;
        --db-border-color: #2b2b40;
        --db-shadow: none;

        /* Header tối hơn nền card một chút */
        --db-tooltip-header: #151521;
    }

    /* -----------------------------------------------------------
       2. UTILITY CLASSES
       ----------------------------------------------------------- */
    .db-card {
        background-color: var(--db-card-bg);
        color: var(--db-text-main);
        border: 0.0625rem solid var(--db-border-color);
        box-shadow: var(--db-shadow);
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .db-text-main { color: var(--db-text-main) !important; }
    .db-text-sub { color: var(--db-text-sub) !important; }
    .db-icon-box {
        width: 3rem; height: 3rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
    }
    .dashboard-wrapper { padding-top: 1.5rem; }

    /* -----------------------------------------------------------
       3. [MỚI] TÙY CHỈNH APEXCHARTS TOOLTIP (FIX DARK MODE)
       ----------------------------------------------------------- */
    /* Khung ngoài của Tooltip */
    .apexcharts-tooltip {
        background-color: var(--db-card-bg) !important;
        border-color: var(--db-border-color) !important;
        color: var(--db-text-main) !important;
        box-shadow: var(--db-shadow) !important;
    }

    /* Phần tiêu đề (Ngày tháng) */
    .apexcharts-tooltip-title {
        background-color: var(--db-tooltip-header) !important;
        border-bottom: 1px solid var(--db-border-color) !important;
        font-family: inherit !important; /* Dùng font của web */
        color: var(--db-text-main) !important;
    }

    /* Phần nội dung text (Series name: Value) */
    .apexcharts-tooltip-text {
        color: var(--db-text-main) !important;
        font-family: inherit !important;
    }

    /* Màu của con số giá trị */
    .apexcharts-tooltip-text-value,
    .apexcharts-tooltip-text-z-value,
    .apexcharts-tooltip-text-y-label {
        color: var(--db-text-main) !important;
        font-weight: 600;
    }

    /* Marker (chấm tròn màu) bên cạnh text */
    .apexcharts-tooltip-marker {
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 mb-1 db-text-main">Dashboard Demo</h2>
            <p class="db-text-sub small mb-0">
                <i class="fa-solid fa-clock me-1"></i> Số liệu & Biểu đồ cập nhật Live (10s/lần)
            </p>
        </div>
    </div>

    <livewire:admin.dashboard.dashboard-stats />
</div>
@endsection

@push('scripts')
{{-- Load thư viện ApexCharts từ Local --}}
<script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function getCssVar(name) {
            return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        }

        // Cấu hình Chart
        var options = {
            series: [{
                name: 'Doanh thu',
                data: []
            }],
            chart: {
                type: 'area',
                height: 350,
                background: 'transparent',
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            colors: [getCssVar('--db-primary') || '#0d6efd'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },

            // Trục X (Ngày tháng)
            xaxis: {
                type: 'category',
                categories: [],
                labels: {
                    style: { colors: getCssVar('--db-text-sub') },
                    rotate: -45,
                    rotateAlways: false,
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tooltip: { enabled: false }
            },

            // [CẬP NHẬT MỚI] Trục Y (Định dạng số tiền)
            yaxis: {
                labels: {
                    style: { colors: getCssVar('--db-text-sub') },
                    // Hàm định dạng số liệu trục Y
                    formatter: function (value) {
                        // Nếu số lớn hơn 1 triệu -> Chuyển thành 10M, 1.5M
                        if (value >= 1000000) {
                            // toFixed(1): Lấy 1 số thập phân (1.5)
                            // replace('.0', ''): Nếu là 10.0M thì bỏ .0 thành 10M cho đẹp
                            return (value / 1000000).toFixed(1).replace('.0', '') + 'M';
                        }
                        // Nếu số nhỏ hơn 1 triệu -> Hiển thị dạng 500.000
                        return new Intl.NumberFormat('vi-VN').format(value);
                    }
                }
            },

            grid: {
                borderColor: getCssVar('--db-border-color'),
                strokeDashArray: 4,
            },

            // Tooltip (Hiển thị chi tiết khi rê chuột)
            tooltip: {
                theme: false,
                style: { fontSize: '12px', fontFamily: 'inherit' },
                x: { show: true, format: 'dd/MM' },
                y: {
                    formatter: function (val) {
                        // Trong Tooltip vẫn hiển thị đầy đủ (10.000.000 ₫) cho chi tiết
                        return new Intl.NumberFormat('vi-VN').format(val) + ' ₫';
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.05, stops: [0, 90, 100] }
            }
        };

        var chartElement = document.querySelector("#revenueChart");

        if (chartElement) {
            var chart = new ApexCharts(chartElement, options);
            chart.render();

            Livewire.on('update-revenue-chart', (event) => {
                let data = event.data || (Array.isArray(event) ? event[0].data : event);

                if (data && data.series && data.categories) {
                    chart.updateOptions({
                        xaxis: {
                            categories: data.categories,
                            labels: { style: { colors: getCssVar('--db-text-sub') } }
                        },
                        colors: [getCssVar('--db-primary') || '#0d6efd'],
                        grid: { borderColor: getCssVar('--db-border-color') },
                        // Cập nhật lại màu text trục Y khi đổi theme
                        yaxis: {
                            labels: {
                                style: { colors: getCssVar('--db-text-sub') },
                                formatter: function (value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1).replace('.0', '') + 'M';
                                    }
                                    return new Intl.NumberFormat('vi-VN').format(value);
                                }
                            }
                        }
                    });

                    chart.updateSeries([{
                        name: 'Doanh thu',
                        data: data.series
                    }]);
                }
            });
        }
    });
</script>
@endpush
