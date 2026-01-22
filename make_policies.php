<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// --- CẤU HÌNH MAPPING MODULE (Giữ nguyên) ---
$moduleMapping = [
    // Catalog
    'Category' => 'catalog', 'Product' => 'catalog', 'Attribute' => 'catalog',
    'Supplier' => 'catalog', 'ProductReview' => 'catalog', 'Brand' => 'catalog',

    // Sales
    'Order' => 'sales', 'OrderItem' => 'sales', 'ShippingShipment' => 'sales',
    'OrderReturn' => 'sales', 'TaxInvoice' => 'sales', 'Cart' => 'sales',

    // CRM
    'Customer' => 'crm', 'ChatConversation' => 'crm', 'Request' => 'crm',

    // Inventory
    'Warehouse' => 'inventory', 'InventoryStock' => 'inventory',
    'InventoryTransaction' => 'inventory', 'ImportOrder' => 'inventory',

    // Marketing
    'Promotion' => 'marketing', 'FlashSale' => 'marketing',
    'AffiliateLink' => 'marketing', 'Banner' => 'marketing', 'Post' => 'marketing',

    // System
    'User' => 'system', 'Role' => 'system', 'Permission' => 'system',
    'Setting' => 'system', 'SystemLog' => 'system', 'Location' => 'system',
];

$policyPath = app_path('Policies');

echo "--- BẮT ĐẦU TẠO POLICIES (ADMIN SUPER & STANDARD) ---\n";

if (!is_dir($policyPath)) {
    mkdir($policyPath, 0755, true);
}

// Quét toàn bộ file trong app/Models
$files = scandir(app_path('Models'));

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;

    $modelName = pathinfo($file, PATHINFO_FILENAME);

    // Bỏ qua các Model phụ
    if (in_array($modelName, ['Permission', 'ActivityLog', 'Pivot'])) continue;

    $module = $moduleMapping[$modelName] ?? 'general';
    $resource = Str::plural(Str::kebab($modelName));

    $policyFileName = "{$modelName}Policy.php";
    $targetFile = "$policyPath/$policyFileName";

    if (file_exists($targetFile)) {
        echo "[SKIP] $modelName đã có Policy.\n";
        continue;
    }

    // --- NỘI DUNG POLICY MỚI ---
    $content = <<<PHP
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\\$modelName;
use Illuminate\Auth\Access\HandlesAuthorization;

class {$modelName}Policy
{
    use HandlesAuthorization;

    /**
     * BỘ LỌC ADMIN (SUPER & STANDARD)
     * Hiện tại: Cả 2 loại admin đều có quyền tuyệt đối (bypass check).
     * Sau này: Nếu muốn cắt quyền admin_standard, chỉ cần xóa khỏi mảng bên dưới.
     */
    public function before(User \$user, \$ability)
    {
        if (in_array(\$user->user_type, ['admin_super', 'admin_standard'])) {
            return true;
        }
    }

    /**
     * Quyền xem danh sách
     * Permission: {$module}.{$resource}.view
     */
    public function viewAny(User \$user): bool
    {
        return \$user->hasPermissionTo('{$module}.{$resource}.view');
    }

    /**
     * Quyền xem chi tiết
     */
    public function view(User \$user, $modelName \$model): bool
    {
        return \$user->hasPermissionTo('{$module}.{$resource}.view');
    }

    /**
     * Quyền tạo mới
     * Permission: {$module}.{$resource}.create
     */
    public function create(User \$user): bool
    {
        return \$user->hasPermissionTo('{$module}.{$resource}.create');
    }

    /**
     * Quyền cập nhật
     * Permission: {$module}.{$resource}.edit
     */
    public function update(User \$user, $modelName \$model): bool
    {
        return \$user->hasPermissionTo('{$module}.{$resource}.edit');
    }

    /**
     * Quyền xóa
     * Permission: {$module}.{$resource}.delete
     */
    public function delete(User \$user, $modelName \$model): bool
    {
        return \$user->hasPermissionTo('{$module}.{$resource}.delete');
    }
}
PHP;

    file_put_contents($targetFile, $content);
    echo "[OK] Đã tạo: $policyFileName\n";
}

echo "--- HOÀN TẤT ---\n";
