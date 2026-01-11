<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RawSqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --------------------------------------------------------------------------
        // CẤU HÌNH DANH SÁCH FILE VÀ CHỨC NĂNG XOÁ DỮ LIỆU
        // --------------------------------------------------------------------------
        // 'file': Tên file .sql trong thư mục database/data
        // 'table': Tên bảng trong database (để thực hiện lệnh làm sạch)
        // 'clean_data': true (Xoá sạch dữ liệu cũ trước khi nạp), false (Chỉ nạp thêm)
        // --------------------------------------------------------------------------

        $seedConfig = [
            [
                'file' => 'provinces.sql',
                'table' => 'provinces',
                'clean_data' => true
            ],
            [
                'file' => 'wards.sql',
                'table' => 'wards',
                'clean_data' => true
            ],
            [
                'file' => 'categories.sql',
                'table' => 'categories',
                'clean_data' => true
            ],
        ];

        $this->command->info('Bắt đầu quy trình nạp dữ liệu...');

        // 1. TẮT KIỂM TRA KHÓA NGOẠI (Bắt buộc để xoá được bảng cha trước bảng con)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($seedConfig as $item) {
            $fileName = $item['file'];
            $tableName = $item['table'];
            $shouldClean = $item['clean_data'];

            $path = database_path('data/' . $fileName);

            if (File::exists($path)) {
                try {
                    // Bước 1: Xoá dữ liệu cũ nếu được yêu cầu
                    if ($shouldClean) {
                        DB::table($tableName)->truncate();
                        $this->command->warn("--> Đã làm sạch bảng: {$tableName}");
                    }

                    // Bước 2: Đọc và chạy file SQL
                    $sql = File::get($path);
                    DB::unprepared($sql);

                    $this->command->info("--> Đã nạp thành công file: {$fileName}");

                } catch (\Exception $e) {
                    $this->command->error("--> LỖI tại file {$fileName}: " . $e->getMessage());
                }
            } else {
                $this->command->error("--> CẢNH BÁO: Không tìm thấy file database/data/{$fileName}");
            }
        }

        // 2. BẬT LẠI KIỂM TRA KHÓA NGOẠI
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('=== HOÀN TẤT TOÀN BỘ QUÁ TRÌNH ===');
    }
}
