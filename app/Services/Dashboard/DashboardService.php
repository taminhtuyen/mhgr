<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class DashboardService
{
    public function getSummaryStats(): array
    {
        // ... (Giữ nguyên logic random cũ) ...
        return [
            'revenue'   => rand(1200000000, 1300000000),
            'orders'    => rand(1200, 1300),
            'customers' => rand(3400, 3600),
            'products'  => rand(123, 234),
        ];
    }

    public function getRevenueChartData(): array
    {
        $dates = [];
        $revenues = [];

        // Tạo dữ liệu giả lập cho 7 ngày
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::now()->subDays($i)->format('d/m');
            // Random doanh thu từ 10tr - 50tr
            $revenues[] = rand(10, 50) * 1000000;
        }

        return [
            'categories' => $dates,
            'series' => $revenues
        ];
    }
}
