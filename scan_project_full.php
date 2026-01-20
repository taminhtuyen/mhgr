<?php

// scan_v2.php
// Script quét toàn bộ mã nguồn project (Fix lỗi đường dẫn Windows/XAMPP)

$outputFilename = 'FULL_PROJECT_SCAN_V2.txt';
$basePath = __DIR__;

// Danh sách các thư mục quan trọng cần kiểm tra
$targetDirectories = [
    'app/Http/Controllers',
    'app/Http/Requests',
    'app/Services',
    'app/Models',
    'routes',
    'resources/views/admin', // Chỉ quét admin views để file đỡ quá nặng
];

$handle = fopen($outputFilename, 'w');
if (!$handle) {
    die("❌ Lỗi: Không thể tạo file $outputFilename. Hãy kiểm tra quyền ghi folder.\n");
}

echo "--- BẮT ĐẦU QUÉT HỆ THỐNG (V2) ---\n";
fwrite($handle, "SCAN REPORT - TIME: " . date('Y-m-d H:i:s') . "\n");
fwrite($handle, "ROOT PATH: " . $basePath . "\n\n");

foreach ($targetDirectories as $dir) {
    $fullPath = $basePath . DIRECTORY_SEPARATOR . $dir;

    // Kiểm tra thư mục có tồn tại không
    if (!is_dir($fullPath)) {
        echo "⚠ Cảnh báo: Không tìm thấy thư mục '$dir'\n";
        fwrite($handle, "!!! MISSING DIRECTORY: $dir\n\n");
        continue;
    }

    echo " -> Đang đọc: $dir ...\n";

    // Sử dụng Iterator để quét đệ quy
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($fullPath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        // Chỉ xử lý file (bỏ qua thư mục)
        if ($item->isFile()) {
            $ext = $item->getExtension();

            // Chỉ lấy file code
            if (in_array(strtolower($ext), ['php', 'blade.php', 'js', 'json'])) {
                $realFilePath = $item->getRealPath();

                // Tạo đường dẫn tương đối dễ nhìn
                $relativePath = str_replace($basePath, '', $realFilePath);
                $relativePath = ltrim($relativePath, '/\\'); // Xóa dấu gạch chéo đầu

                // Đọc nội dung
                $content = file_get_contents($realFilePath);

                if ($content === false) {
                    $content = "[LỖI: KHÔNG ĐỌC ĐƯỢC NỘI DUNG FILE]";
                }

                // Ghi vào file kết quả
                fwrite($handle, "====================================================================\n");
                fwrite($handle, "FILE: " . $relativePath . "\n");
                fwrite($handle, "PATH: " . $realFilePath . "\n");
                fwrite($handle, "====================================================================\n");
                fwrite($handle, $content . "\n");
                fwrite($handle, "\n\n"); // Dòng trống ngăn cách
            }
        }
    }
}

fclose($handle);

echo "\n-------------------------------------------------------\n";
echo " ✅ HOÀN TẤT!\n";
echo " File kết quả: " . $outputFilename . "\n";
echo " Vui lòng gửi file này cho tôi để kiểm tra.\n";
echo "-------------------------------------------------------\n";
?>
