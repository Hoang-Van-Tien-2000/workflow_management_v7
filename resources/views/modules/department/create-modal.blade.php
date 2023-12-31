<div class="modal fade" id="create-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="create_form" id="frm-them-moi" method="POST" data-parsley-validate="" novalidate>
                    @csrf
                    <div class="mb-3 needs-validation">
                    <label class="form-label" for="ten-loai">Trưởng phòng<span class="required"> *</span></label>
                    <select class="form-control custom-select2"
                        data-parsley-errors-container="#error-parley-select-nv"
                        id="user_id" name="user_id">
                        <option value=""></option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-select-nv"></div>
                    </div>
                    <div class="mb-3 needs-validation">
                        <label class="form-label" for="ten-loai">Tên phòng ban<span class="required"> *</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                        placeholder="Tên phòng ban..."
                        data-parsley-required-message="Vui lòng nhập tên phòng ban"
                        data-parsley-maxlength="191"
                        data-parsley-maxlength-message="Tên phòng ban không thể nhập quá 191 ký tự"
                        required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <input id="btn-save-modal" type="submit" class="btn btn-primary" value="Lưu">
            </div>
        </div>
    </div>
</div>
