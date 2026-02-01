<?php

namespace App\Livewire\Admin\System;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Str;
use App\Events\SystemNotification;

class UserModal extends Component
{
    public $showModal = false;
    public $editMode = false;
    public $itemId;

    // Các trường dữ liệu cơ bản (Bạn cần map đúng fillable, đây là mẫu chung)
    public $name;
    public $is_active = true;

    protected $listeners = ['openUserModal' => 'openModal', 'deleteUser' => 'delete'];

    protected $rules = [
        'name' => 'required|min:2',
    ];

    public function render()
    {
        return view('livewire.admin.system.user-modal');
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['name', 'itemId', 'editMode']);

        if ($id) {
            $this->editMode = true;
            $this->itemId = $id;
            $item = User::find($id);
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
            User::find($this->itemId)->update($data);
            $message = 'Cập nhật thành công!';
        } else {
            User::create($data);
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
