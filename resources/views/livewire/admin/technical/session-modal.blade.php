<div> {{-- ROOT TAG BẮT BUỘC CỦA LIVEWIRE --}}
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mới Session</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label">Tên Session</label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nhập tên...">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Đóng</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
