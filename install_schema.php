<?php

// Script tự động tích hợp Schema View vào các trang Admin
// Tác giả: Gemini - 2026

$targetDir = __DIR__ . '/resources/views/admin';
$includeString = "@include('admin.partials.schema-view')";

if (!is_dir($targetDir)) {
    die("❌ Lỗi: Không tìm thấy thư mục 'resources/views/admin'. Hãy đảm bảo file này nằm ở root dự án.\n");
}

echo "🚀 Đang bắt đầu quét và cập nhật views...\n\n";

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($targetDir, RecursiveDirectoryIterator::SKIP_DOTS)
);

$countUpdated = 0;
$countSkipped = 0;
$errors = [];

foreach ($iterator as $file) {
    // Chỉ xử lý file index.blade.php
    if ($file->getFilename() !== 'index.blade.php') {
        continue;
    }

    $filePath = $file->getRealPath();
    $relativePath = str_replace(__DIR__ . '/', '', $filePath);
    $content = file_get_contents($filePath);

    // 1. Kiểm tra xem đã include chưa
    if (strpos($content, "admin.partials.schema-view") !== false) {
        echo "⏭️  Đã tồn tại: $relativePath\n";
        $countSkipped++;
        continue;
    }

    // 2. Tìm vị trí @section('content') để chèn vào ngay sau nó
    // Regex tìm @section('content'), hỗ trợ khoảng trắng thừa
    $pattern = '/(@section\s*\(\s*[\'"]content[\'"]\s*\))/i';

    if (preg_match($pattern, $content)) {
        // Chèn include vào ngay sau @section('content')
        $newContent = preg_replace(
            $pattern,
            "$1\n    " . $includeString . "\n",
            $content,
            1 // Chỉ thay thế lần xuất hiện đầu tiên
        );

        if ($newContent && $newContent !== $content) {
            if (file_put_contents($filePath, $newContent)) {
                echo "✅ Đã cập nhật: $relativePath\n";
                $countUpdated++;
            } else {
                echo "❌ Lỗi ghi file: $relativePath\n";
                $errors[] = $relativePath;
            }
        }
    } else {
        echo "⚠️  Bỏ qua (Không tìm thấy section content): $relativePath\n";
        $countSkipped++;
    }
}

echo "\n========================================\n";
echo "🎉 HOÀN TẤT!\n";
echo "📊 Tổng file đã xử lý: " . ($countUpdated + $countSkipped) . "\n";
echo "✅ Đã cập nhật: $countUpdated file\n";
echo "⏭️  Đã bỏ qua: $countSkipped file\n";

if (count($errors) > 0) {
    echo "❌ Có lỗi xảy ra với các file sau:\n";
    print_r($errors);
}

// Xóa file script sau khi chạy xong (tùy chọn)
// unlink(__FILE__);
?>
