<?php
// File: scan_and_fix_livewire_modals.php

use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';

// Cấu hình đường dẫn
$baseLivewirePath = __DIR__ . '/app/Livewire/Admin';
$baseViewPath = __DIR__ . '/resources/views/livewire/admin';

if (!is_dir($baseLivewirePath)) {
    die("❌ Không tìm thấy thư mục: $baseLivewirePath\n");
}

echo "=============================================\n";
echo "🕵️  BẮT ĐẦU QUÉT & BỔ SUNG MODAL CÒN THIẾU\n";
echo "=============================================\n\n";

// Hàm quét thư mục đệ quy
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseLivewirePath));
$missingCount = 0;

foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), 'Table.php')) {

        // 1. Phân tích tên file và đường dẫn
        // Ví dụ: file là .../Admin/Content/NewsTable.php
        $fullPath = $file->getPathname();
        $fileName = $file->getFilename(); // NewsTable.php
        $dirPath  = $file->getPath();     // .../Admin/Content

        // Tên Entity: NewsTable -> News
        $entityName = str_replace('Table.php', '', $fileName);

        // Tên file Modal cần kiểm tra: NewsModal.php
        $modalFileName = $entityName . 'Modal.php';
        $modalFilePath = $dirPath . '/' . $modalFileName;

        // 2. Xác định Module (Folder cha) để set Namespace
        // Lấy phần đường dẫn sau 'app/Livewire/Admin/'
        // Ví dụ: 'Content' hoặc 'Catalog'
        $relativePath = str_replace(str_replace('\\', '/', $baseLivewirePath), '', str_replace('\\', '/', $dirPath));
        $moduleName = trim($relativePath, '/');

        // Namespace: App\Livewire\Admin\Content
        $namespace = 'App\\Livewire\\Admin';
        if ($moduleName) {
            $namespace .= '\\' . str_replace('/', '\\', $moduleName);
        }

        // 3. Kiểm tra xem file Modal có tồn tại không
        if (!file_exists($modalFilePath)) {
            echo "⚠️  Phát hiện thiếu: [{$moduleName}] {$modalFileName} (vì đã có {$fileName})\n";

            // --> TẠO FILE CLASS PHP
            createModalClass($modalFilePath, $namespace, $entityName, $moduleName);

            // --> TẠO FILE VIEW BLADE
            createModalView($moduleName, $entityName);

            $missingCount++;
        }
    }
}

if ($missingCount == 0) {
    echo "\n✅ Tuyệt vời! Tất cả các Table đều đã có Modal tương ứng.\n";
} else {
    echo "\n🎉 Đã tự động tạo xong {$missingCount} Modal còn thiếu.\n";
    echo "👉 Hãy chạy: php artisan optimize:clear\n";
}

// ----------------------------------------------------------------
// HÀM TẠO CLASS MODAL (PHP)
// ----------------------------------------------------------------
function createModalClass($path, $namespace, $entity, $module) {
    $moduleKebab = Str::kebab($module);
    $entityKebab = Str::kebab($entity);

    $content = "<?php

namespace {$namespace};

use Livewire\Component;
use App\Models\\{$entity};
use Illuminate\Support\Str;
use App\Events\SystemNotification;

class {$entity}Modal extends Component
{
    public \$showModal = false;
    public \$editMode = false;
    public \$itemId;

    // Các trường dữ liệu cơ bản (Bạn cần map đúng fillable, đây là mẫu chung)
    public \$name;
    public \$is_active = true;

    protected \$listeners = ['open{$entity}Modal' => 'openModal', 'delete{$entity}' => 'delete'];

    protected \$rules = [
        'name' => 'required|min:2',
    ];

    public function render()
    {
        return view('livewire.admin.{$moduleKebab}.{$entityKebab}-modal');
    }

    public function openModal(\$id = null)
    {
        \$this->resetValidation();
        \$this->reset(['name', 'itemId', 'editMode']);

        if (\$id) {
            \$this->editMode = true;
            \$this->itemId = \$id;
            \$item = {$entity}::find(\$id);
            if(\$item) {
                \$this->name = \$item->name ?? ''; // Cố gắng lấy trường name
                // Map thêm các trường khác tại đây nếu cần
            }
        }

        \$this->showModal = true;
    }

    public function closeModal()
    {
        \$this->showModal = false;
    }

    public function save()
    {
        \$this->validate();

        \$data = [
            'name' => \$this->name,
            // Thêm các trường khác vào đây
        ];

        if (\$this->editMode) {
            {$entity}::find(\$this->itemId)->update(\$data);
            \$message = 'Cập nhật thành công!';
        } else {
            {$entity}::create(\$data);
            \$message = 'Thêm mới thành công!';
        }

        \$this->closeModal();
        \$this->dispatch('refreshTable'); // Reload bảng

        event(new SystemNotification([
            'type' => 'success',
            'title' => 'Thành công',
            'content' => \$message
        ]));
    }
}
";
    file_put_contents($path, $content);
    echo "   + Đã tạo Class: {$path}\n";
}

// ----------------------------------------------------------------
// HÀM TẠO VIEW MODAL (BLADE)
// ----------------------------------------------------------------
function createModalView($module, $entity) {
    global $baseViewPath;

    $moduleKebab = Str::kebab($module);
    $entityKebab = Str::kebab($entity);
    $entityStudly = Str::studly($entity); // Ví dụ: ShippingPartner

    // Đường dẫn view: resources/views/livewire/admin/content/news-modal.blade.php
    $folderPath = $baseViewPath . '/' . $moduleKebab;
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0755, true);
    }

    $viewPath = $folderPath . '/' . $entityKebab . '-modal.blade.php';

    // Nội dung View chuẩn Bootstrap + Livewire
    $content = "<div>
    {{-- MODAL GIAO DIỆN --}}
    @if(\$showModal)
    <div class=\"modal fade show d-block\" tabindex=\"-1\" role=\"dialog\" style=\"background: rgba(0,0,0,0.5);\">
        <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">{{ \$editMode ? 'Cập nhật' : 'Thêm mới' }} {$entityStudly}</h5>
                    <button type=\"button\" class=\"btn-close\" wire:click=\"closeModal\"></button>
                </div>
                <div class=\"modal-body\">
                    <form wire:submit.prevent=\"save\">
                        {{-- Mẫu trường Name --}}
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Tên / Tiêu đề</label>
                            <input type=\"text\" class=\"form-control @error('name') is-invalid @enderror\" wire:model=\"name\" placeholder=\"Nhập thông tin...\">
                            @error('name') <span class=\"text-danger small\">{{ \$message }}</span> @enderror
                        </div>

                        {{-- Có thể bổ sung thêm trường tại đây --}}

                    </form>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" wire:click=\"closeModal\">Đóng</button>
                    <button type=\"button\" class=\"btn btn-primary\" wire:click=\"save\">
                        <i class=\"fa-solid fa-save\"></i> Lưu lại
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>";

    if (!file_exists($viewPath)) {
        file_put_contents($viewPath, $content);
        echo "   + Đã tạo View:  {$viewPath}\n";
    }
}
?>
