<?php
// File: generator_core.php

require __DIR__ . '/vendor/autoload.php';
use Illuminate\Support\Str;

function createDirectories($paths) {
    foreach ($paths as $path) {
        if (!is_dir($path)) mkdir($path, 0755, true);
    }
}

function generateModuleFiles($module, $entity) {
    $moduleStudly = Str::studly($module);
    $entityStudly = Str::studly($entity);
    $moduleLower = Str::lower($moduleStudly);
    $entityKebab = Str::kebab($entityStudly);
    $entityPluralKebab = Str::kebab(Str::plural($entityStudly));
    $permissionPrefix = "{$moduleLower}." . Str::plural($entityKebab);

    echo "⚙️ Đang tạo Module: [{$moduleStudly}] -> {$entityStudly}...\n";

    $paths = [
        'controller' => "app/Http/Controllers/Admin/{$moduleStudly}",
        'request'    => "app/Http/Requests/Admin/{$moduleStudly}",
        'service'    => "app/Services/{$moduleStudly}",
        'livewire'   => "app/Livewire/Admin/{$moduleStudly}",
        'policy'     => "app/Policies",
        'view_index' => "resources/views/admin/{$moduleLower}/{$entityPluralKebab}",
        'view_lw'    => "resources/views/livewire/admin/{$moduleLower}",
    ];
    createDirectories($paths);

    // 1. Controller
    $content = "<?php
namespace App\Http\Controllers\Admin\\{$moduleStudly};
use App\Services\\{$moduleStudly}\\{$entityStudly}Service;
use App\Http\Requests\Admin\\{$moduleStudly}\\{$entityStudly}Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasTableSchema;

class {$entityStudly}Controller extends Controller {
    use HasTableSchema;
    public function index() {
        return view('admin.{$moduleLower}.{$entityPluralKebab}.index', [
            'title' => 'Danh Sách {$entityStudly}'
        ]);
    }
}
";
    file_put_contents("{$paths['controller']}/{$entityStudly}Controller.php", $content);

    // 2. Request
    $content = "<?php

namespace App\Http\Requests\Admin\\{$moduleStudly};

use Illuminate\Foundation\Http\FormRequest;

class {$entityStudly}Request extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return []; }
}
";
    file_put_contents("{$paths['request']}/{$entityStudly}Request.php", $content);

    // 3. Service
    $content = "<?php

namespace App\Services\\{$moduleStudly};

class {$entityStudly}Service
{
    public function __construct() {}
}
";
    file_put_contents("{$paths['service']}/{$entityStudly}Service.php", $content);

    // 4. Policy
    $content = "<?php

namespace App\Policies;

use App\Models\User;
use App\Models\\{$entityStudly};
use Illuminate\Auth\Access\HandlesAuthorization;

class {$entityStudly}Policy
{
    use HandlesAuthorization;

    public function before(User \$user, \$ability) {
        if (in_array(\$user->user_type, ['admin_super', 'admin_standard'])) return true;
    }
    public function viewAny(User \$user): bool { return \$user->hasPermissionTo('{$permissionPrefix}.view'); }
    public function create(User \$user): bool { return \$user->hasPermissionTo('{$permissionPrefix}.create'); }
    public function update(User \$user, {$entityStudly} \$model): bool { return \$user->hasPermissionTo('{$permissionPrefix}.edit'); }
    public function delete(User \$user, {$entityStudly} \$model): bool { return \$user->hasPermissionTo('{$permissionPrefix}.delete'); }
}
";
    file_put_contents("{$paths['policy']}/{$entityStudly}Policy.php", $content);

    // 5. Livewire Table Component
    $content = "<?php

namespace App\Livewire\Admin\\{$moduleStudly};

use Livewire\Component;
use Livewire\WithPagination;

class {$entityStudly}Table extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.{$moduleLower}.{$entityKebab}-table');
    }
}
";
    file_put_contents("{$paths['livewire']}/{$entityStudly}Table.php", $content);

    // 6. View Index
    $content = "@extends('admin.layouts.master')

@section('title', \$title ?? 'Quản lý {$entityStudly}')

@section('content')
    <livewire:admin.{$moduleLower}.{$entityKebab}-table />
    <livewire:admin.{$moduleLower}.{$entityKebab}-modal />
@endsection
";
    file_put_contents("{$paths['view_index']}/index.blade.php", $content);

    // 7. View Table
    $content = "<div class=\"p-4\">
    <div class=\"alert alert-success\">
        <i class=\"fa-solid fa-code\"></i> Livewire Component: <strong>Admin\\{$moduleStudly}\\{$entityStudly}Table</strong> đang hoạt động.
    </div>
</div>
";
    file_put_contents("{$paths['view_lw']}/{$entityKebab}-table.blade.php", $content);
}

function generateModalFiles($module, $entity) {
    $moduleStudly = Str::studly($module);
    $entityStudly = Str::studly($entity);
    $moduleLower = Str::lower($moduleStudly);
    $entityKebab = Str::kebab($entityStudly);

    echo "🛠  Đang tạo Modal: [{$moduleStudly}] -> {$entityStudly}Modal...\n";

    $paths = [
        'class' => "app/Livewire/Admin/{$moduleStudly}",
        'view'  => "resources/views/livewire/admin/{$moduleLower}",
    ];
    createDirectories($paths);

    // 1. Livewire Modal Class
    $content = "<?php

namespace App\Livewire\Admin\\{$moduleStudly};

use Livewire\Component;

class {$entityStudly}Modal extends Component
{
    public bool \$showModal = false;
    public \$name;

    protected \$listeners = ['show{$entityStudly}Modal' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.{$moduleLower}.{$entityKebab}-modal');
    }

    public function openModal()
    {
        \$this->reset();
        \$this->showModal = true;
    }

    public function closeModal()
    {
        \$this->showModal = false;
    }

    public function save()
    {
        \$this->dispatch('refreshTable');
        \$this->closeModal();
        \$this->dispatch('show-toast', type: 'success', message: 'Thành công!');
    }
}
";
    file_put_contents("{$paths['class']}/{$entityStudly}Modal.php", $content);

    // 2. View Modal (ĐÃ SỬA LỖI: Thêm thẻ div bao ngoài cùng)
    $content = "<div> {{-- ROOT TAG BẮT BUỘC CỦA LIVEWIRE --}}
    @if(\$showModal)
    <div class=\"modal fade show d-block\" tabindex=\"-1\" role=\"dialog\" style=\"background: rgba(0,0,0,0.5);\">
        <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">Thêm mới {$entityStudly}</h5>
                    <button type=\"button\" class=\"btn-close\" wire:click=\"closeModal\"></button>
                </div>
                <div class=\"modal-body\">
                    <form wire:submit.prevent=\"save\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Tên {$entityStudly}</label>
                            <input type=\"text\" class=\"form-control\" wire:model=\"name\" placeholder=\"Nhập tên...\">
                            @error('name') <span class=\"text-danger small\">{{ \$message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" wire:click=\"closeModal\">Đóng</button>
                    <button type=\"button\" class=\"btn btn-primary\" wire:click=\"save\">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
";
    file_put_contents("{$paths['view']}/{$entityKebab}-modal.blade.php", $content);
}
