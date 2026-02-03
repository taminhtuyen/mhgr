<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class DashboardService
{
    // ... (Giữ nguyên hàm getSummaryStats) ...
    public function getSummaryStats(): array
    {
        return [
            'revenue'   => rand(1200000000, 1500000000),
            'orders'    => rand(1200, 1300),
            'customers' => rand(3400, 3600),
            'products'  => rand(123, 234),
        ];
    }

    /**
     * Lấy dữ liệu biểu đồ theo bộ lọc
     * @param string $filterType: '7days', '30days', '12months', '10years'
     */
    public function getRevenueChartData($filterType = '7days'): array
    {
        $dates = [];
        $revenues = [];

        // CẤU HÌNH LOGIC THEO TỪNG LOẠI
        switch ($filterType) {
            case '30days':
                $loops = 29;
                $format = 'd/m';
                $unit = 'day';
                break;
            case '12months':
                $loops = 11;
                $format = 'm/Y';
                $unit = 'month';
                break;
            case '10years':
                // [LOGIC ĐẶC BIỆT]: Kiểm tra tuổi đời hệ thống
                // Lấy ngày tạo của user đầu tiên (Admin) để xác định năm bắt đầu
                $oldestUser = DB::table('users')->orderBy('created_at', 'asc')->first();
                $startYear = $oldestUser ? Carbon::parse($oldestUser->created_at)->year : Carbon::now()->year;
                $currentYear = Carbon::now()->year;

                // Nếu tài khoản mới tạo năm nay -> Ít nhất hiện 1 cột
                // Nếu tài khoản tạo 3 năm trước -> Hiện 3 cột
                // Tối đa 10 năm
                $yearsActive = $currentYear - $startYear;
                $loops = min($yearsActive, 9); // 0-9 là 10 năm

                // Fallback cho Demo: Giả lập hệ thống đã chạy được 5 năm
                if ($yearsActive == 0) $loops = 4;

                $format = 'Y';
                $unit = 'year';
                break;
            case '7days':
            default:
                $loops = 6;
                $format = 'd/m';
                $unit = 'day';
                break;
        }

        // TẠO DỮ LIỆU (FAKE DATA ĐỂ DEMO)
        for ($i = $loops; $i >= 0; $i--) {
            if ($unit == 'day') {
                $time = Carbon::now()->subDays($i);
                $minVal = 10; $maxVal = 50; // 10-50 triệu
            } elseif ($unit == 'month') {
                $time = Carbon::now()->subMonths($i);
                $minVal = 300; $maxVal = 900; // 300-900 triệu (Doanh thu tháng phải to hơn ngày)
            } else { // year
                $time = Carbon::now()->subYears($i);
                $minVal = 5000; $maxVal = 15000; // 5-15 Tỷ (Doanh thu năm)
            }

            $dates[] = $time->format($format);

            // Random doanh thu * 1.000.000
            $revenues[] = rand($minVal, $maxVal) * 1000000;
        }

        return [
            'categories' => $dates,
            'series' => $revenues,
            'filter' => $filterType // Trả về để Frontend biết đang ở chế độ nào
        ];
    }
}
