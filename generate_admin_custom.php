<?php

/**
 * SCRIPT SỬA LỖI CÚ PHÁP THẺ LIVEWIRE (TAG FIXER)
 * -----------------------------------------------------
 * Mục tiêu: Chuyển đổi <livewire:admin.-system... /> thành <livewire:admin.system... />
 * Loại bỏ các dấu "-" dư thừa sau dấu "."
 */

echo "--- Đang khởi động Laravel Framework... ---\n";
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\File;

// Đường dẫn chứa các file index của Admin
$targetPath = resource_path('views/admin');

echo "--- BẮT ĐẦU QUÉT VÀ SỬA LỖI CÚ PHÁP... ---\n";

if (!File::isDirectory($targetPath)) {
    die("[LỖI] Không tìm thấy thư mục: $targetPath\n");
}

// Lấy tất cả file index.blade.php trong thư mục admin (đệ quy)
$files = File::allFiles($targetPath);

$count = 0;

foreach ($files as $file) {
    // Chỉ xử lý file index.blade.php
    if ($file->getFilename() !== 'index.blade.php') {
        continue;
    }

    $content = File::get($file->getPathname());
    $originalContent = $content;

    // 1. Sửa lỗi: admin.-module -> admin.module
    $content = str_replace('livewire:admin.-', 'livewire:admin.', $content);

    // 2. Sửa lỗi: module.-model -> module.model (ví dụ: system.-location)
    // Tìm các đoạn .- nằm trong thẻ livewire
    $content = preg_replace_callback('/<livewire:([^>]+) \/>/', function($matches) {
        // Thay thế .- bằng . trong tên component
        $fixedName = str_replace('.-', '.', $matches[1]);
        return "<livewire:$fixedName />";
    }, $content);

    if ($content !== $originalContent) {
        File::put($file->getPathname(), $content);
        echo "   [ĐÃ SỬA] " . $file->getRelativePathname() . "\n";
        $count++;
    }
}

echo "\n------------------------------------------------------------";
echo "\n[HOÀN TẤT] Đã sửa lỗi cú pháp cho $count file.";
echo "\n[LƯU Ý] Hãy chạy 'php artisan view:clear' để xóa cache giao diện cũ.";
echo "\n------------------------------------------------------------\n";
?>
