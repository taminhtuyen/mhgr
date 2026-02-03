<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Services\Dashboard\DashboardService;

class DashboardStats extends Component
{
    public $stats = [];
    public $chartData = [];

    // [QUAN TRỌNG] Gửi dữ liệu ngay khi component khởi tạo để vẽ chart luôn
    public function mount(DashboardService $service)
    {
        $this->loadData($service);
    }

    // Chạy mỗi lần poll
    public function render(DashboardService $service)
    {
        $this->loadData($service);

        // [QUAN TRỌNG] Bắn sự kiện cập nhật số liệu mới
        $this->dispatch('update-revenue-chart', data: $this->chartData);

        return view('livewire.admin.dashboard.dashboard-stats');
    }

    private function loadData($service)
    {
        $this->stats = $service->getSummaryStats();
        $this->chartData = $service->getRevenueChartData();
    }
}
