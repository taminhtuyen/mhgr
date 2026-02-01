<?php

namespace App\Livewire\Admin\Catalog;

use Livewire\Component;
use App\Models\PriceGroup;
use Illuminate\Support\Str;
use App\Events\SystemNotification;

class PriceGroupModal extends Component
{
    public $showModal = false;
    public $editMode = false;
    public $itemId;

    // Các trường dữ liệu cơ bản (Bạn cần map đúng fillable, đây là mẫu chung)
    public $name;
    public $is_active = true;

    protected $listeners = ['openPriceGroupModal' => 'openModal', 'deletePriceGroup' => 'delete'];

    protected $rules = [
        'name' => 'required|min:2',
    ];

    public function render()
    {
        return view('livewire.admin.catalog.price-group-modal');
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['name', 'itemId', 'editMode']);

        if ($id) {
            $this->editMode = true;
            $this->itemId = $id;
            $item = PriceGroup::find($id);
            if($item) {
                $this->name = $item->name ?? ''; // Cố gắng lấy trường name
                // Map thêm các trường khác tại đây nếu cần
            }
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            // Thêm các trường khác vào đây
        ];

        if ($this->editMode) {
            PriceGroup::find($this->itemId)->update($data);
            $message = 'Cập nhật thành công!';
        } else {
            PriceGroup::create($data);
            $message = 'Thêm mới thành công!';
        }

        $this->closeModal();
        $this->dispatch('refreshTable'); // Reload bảng

        event(new SystemNotification([
            'type' => 'success',
            'title' => 'Thành công',
            'content' => $message
        ]));
    }
}
