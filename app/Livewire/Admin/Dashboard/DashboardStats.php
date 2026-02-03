<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Services\Dashboard\DashboardService;

class DashboardStats extends Component
{
    public $stats = [];
    public $chartData = [];

    // [MỚI] Biến lưu trạng thái bộ lọc
    public $filterType = '7days';

    public function mount(DashboardService $service)
    {
        $this->loadData($service);
    }

    // [MỚI] Hàm này tự động chạy khi $filterType thay đổi (nhờ wire:model.live)
    public function updatedFilterType()
    {
        // Gọi lại logic load data và render lại
        // Livewire sẽ tự động trigger render() sau hàm này
    }

    public function render(DashboardService $service)
    {
        // Truyền $this->filterType vào Service
        $this->loadData($service);

        $this->dispatch('update-revenue-chart', data: $this->chartData);

        return view('livewire.admin.dashboard.dashboard-stats');
    }

    private function loadData($service)
    {
        $this->stats = $service->getSummaryStats();
        // Truyền loại lọc vào service
        $this->chartData = $service->getRevenueChartData($this->filterType);
    }
}
