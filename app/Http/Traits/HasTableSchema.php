<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait HasTableSchema
{
    /**
     * Lấy cấu trúc bảng và comment của cột
     */
    public function getSchema($tableName)
    {

        try {
            return DB::select("SHOW FULL COLUMNS FROM `$tableName`");
        } catch (\Exception $e) {
            return [];
        }
    }
}
