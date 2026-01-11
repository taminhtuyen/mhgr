<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi file RawSqlSeeder để chạy các file SQL
        $this->call([
            RawSqlSeeder::class,
        ]);
    }
}


// Chạy lệnh để nạp dữ liệu: php artisan db:seed
