<div>
    {{-- MODAL GIAO DIỆN --}}
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Cập nhật' : 'Thêm mới' }} RewardWallet</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        {{-- Mẫu trường Name --}}
                        <div class="mb-3">
                            <label class="form-label">Tên / Tiêu đề</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Nhập thông tin...">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Có thể bổ sung thêm trường tại đây --}}

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Đóng</button>
                    <button type="button" class="btn btn-primary" wire:click="save">
                        <i class="fa-solid fa-save"></i> Lưu lại
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>