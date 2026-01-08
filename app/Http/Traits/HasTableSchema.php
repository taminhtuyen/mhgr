<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HasTableSchema
{
    /**
     * Lấy cấu trúc bảng và comment của cột
     */
    public function getSchema($tableName)
    {
        // 1. Kiểm tra bảng có tồn tại không bằng công cụ chuẩn của Laravel
        // (Cách cũ dùng SQL thô gây lỗi cú pháp trên MariaDB của bạn)
        if (!Schema::hasTable($tableName)) {
            return [];
        }

        // 2. Lấy thông tin cột (Field, Type, Comment)
        // Lưu ý: Tên bảng không thể truyền bằng tham số (?) trong SQL chuẩn,
        // nên ta nối chuỗi trực tiếp. Vì tên bảng do bạn khai báo trong Controller nên vẫn an toàn.
        return DB::select("SHOW FULL COLUMNS FROM `$tableName`");
    }
}
