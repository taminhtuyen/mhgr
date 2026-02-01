<?php
// File: run_setup.php

require_once 'generator_core.php';

// DANH SÁCH MENU MỚI
$newMenus = [
    'Inventory' => ['Packing'],
    'Logistics' => ['DeliveryFailure'],
    'Finance'   => ['ReviewRatingRule', 'RewardHistory'],
    'Marketing' => ['SearchHistory', 'PromotionLogicDictionary'],
    'Content'   => ['GameLanguage'],
    'CRM'       => ['MembershipTier'],
    'System'    => ['LeaveSchedule', 'TaxSchedule'],
    'Technical' => ['QueueJob', 'Session', 'Pulse']
];

echo "=============================================\n";
echo "🚀 BẮT ĐẦU TẠO FILE (CHUẨN FORMAT) \n";
echo "=============================================\n\n";

foreach ($newMenus as $module => $entities) {
    foreach ($entities as $entity) {
        generateModuleFiles($module, $entity);
        generateModalFiles($module, $entity);
        echo "✅ Hoàn tất: {$module} > {$entity}\n";
        echo "---------------------------------------------\n";
    }
}

echo "\n🎉 ĐÃ XONG! Code được sinh ra giống hệt mẫu bạn gửi.\n";
echo "👉 Chạy: php artisan optimize:clear\n";
