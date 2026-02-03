@extends('admin.layouts.master')

@section('title', 'Tổng quan Hệ thống')

@push('styles')
<style>
    /* ... (Giữ nguyên các biến CSS cũ) ... */
    :root {
        --db-card-bg: #ffffff;
        --db-text-main: #2b3445;
        --db-text-sub: #7d879c;
        --db-border-color: rgba(0,0,0,0.05);
        --db-shadow: 0 0.25rem 1rem rgba(0,0,0,0.05);
        --db-primary: #0d6efd;
        --db-tooltip-header: #f8f9fa;
    }
    /* ... (Dark mode giữ nguyên) ... */
    [data-theme="dark"], body.dark-mode {
        --db-card-bg: #1e1e2d;
        --db-text-main: #e4e6ef;
        --db-text-sub: #b5b5c3;
        --db-border-color: #2b2b40;
        --db-shadow: none;
        --db-tooltip-header: #151521;
    }

    /* ... (Utility class cũ) ... */
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

    /* Fix Tooltip */
    .apexcharts-tooltip {
        background-color: var(--db-card-bg) !important;
        border-color: var(--db-border-color) !important;
        color: var(--db-text-main) !important;
        box-shadow: var(--db-shadow) !important;
    }
    .apexcharts-tooltip-title {
        background-color: var(--db-tooltip-header) !important;
        border-bottom: 1px solid var(--db-border-color) !important;
        font-family: inherit !important;
        color: var(--db-text-main) !important;
    }
    .apexcharts-tooltip-text { color: var(--db-text-main) !important; font-family: inherit !important; }
    .apexcharts-tooltip-text-value { color: var(--db-text-main) !important; font-weight: 600; }
    .apexcharts-tooltip-marker { margin-right: 0.5rem; }

    /* [MỚI] Style cho Select Box trong Dark Mode */
    .db-select {
        background-color: var(--db-card-bg);
        color: var(--db-text-main);
        border-color: var(--db-border-color);
    }
    .db-select:focus {
        background-color: var(--db-card-bg);
        color: var(--db-text-main);
        border-color: var(--db-primary);
        box-shadow: none;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 mb-1 db-text-main">Dashboard Demo</h2>
            <p class="db-text-sub small mb-0">
                <i class="fa-solid fa-clock me-1"></i> Khám phá sức mạnh của ApexCharts & Livewire
            </p>
        </div>
    </div>

    <livewire:admin.dashboard.dashboard-stats />
</div>
@endsection

@push('scripts')
<script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function getCssVar(name) {
            return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        }

        // Hàm format số thông minh (Hỗ trợ Tỷ - Billion)
        function smartNumberFormatter(value) {
            if (value >= 1000000000) { // Lớn hơn 1 Tỷ
                return (value / 1000000000).toFixed(1).replace('.0', '') + 'B';
            }
            if (value >= 1000000) { // Lớn hơn 1 Triệu
                return (value / 1000000).toFixed(1).replace('.0', '') + 'M';
            }
            return new Intl.NumberFormat('vi-VN').format(value);
        }

        var options = {
            series: [{ name: 'Doanh thu', data: [] }],
            chart: {
                type: 'area', height: 350, background: 'transparent',
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            colors: [getCssVar('--db-primary') || '#0d6efd'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },

            xaxis: {
                type: 'category', categories: [],
                labels: {
                    style: { colors: getCssVar('--db-text-sub') },
                    rotate: -45, rotateAlways: false,
                },
                axisBorder: { show: false }, axisTicks: { show: false }, tooltip: { enabled: false }
            },

            yaxis: {
                labels: {
                    style: { colors: getCssVar('--db-text-sub') },
                    formatter: function (value) {
                        return smartNumberFormatter(value);
                    }
                }
            },
            grid: { borderColor: getCssVar('--db-border-color'), strokeDashArray: 4 },
            tooltip: {
                theme: false, style: { fontSize: '12px', fontFamily: 'inherit' },
                x: { show: true },
                y: {
                    formatter: function (val) {
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
                        yaxis: {
                            labels: {
                                style: { colors: getCssVar('--db-text-sub') },
                                formatter: function (value) { return smartNumberFormatter(value); }
                            }
                        }
                    });

                    chart.updateSeries([{ name: 'Doanh thu', data: data.series }]);
                }
            });
        }
    });
</script>
@endpush
