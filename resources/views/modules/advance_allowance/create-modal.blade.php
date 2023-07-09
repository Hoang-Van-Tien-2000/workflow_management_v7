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
                    <label class="form-label" for="ten-loai">Tên nhân viên<span class="required"> *</span></label>
                    <select class="form-control custom-select2"
                        data-parsley-required-message="Vui lòng chọn nhân viên"
                        data-parsley-errors-container="#error-parley-select-nv"
                        required
                        id="user_id" name="user_id">
                        <option value=""></option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-select-nv"></div>
                    </div>
                    <div class="mb-3 needs-validation">
                        <label class="form-label" for="ten-loai">Số tiền tạm ứng <span class="required"> *</span></label>
                        <input type="text" class="form-control" id="advance" name="advance" 
                        oninput="myFunction()"
                        onkeypress="return isNumberKey(event)"
                        placeholder="Tiền tạm ứng..."
                        data-parsley-required-message="Vui lòng nhập tiền tam ứng"
                        data-parsley-maxlength="191"
                        required>
                    </div>
                    <div class="mb-3 needs-validation">
                        <label class="form-label" for="ten-loai">Số tiền phụ cấp <span class="required"> *</span></label>
                        <input type="text" class="form-control" id="allowance" name="allowance" 
                        oninput="myFunction()"
                        onkeypress="return isNumberKey(event)"
                        placeholder="Tiền phụ cấp...."
                        data-parsley-required-message="Vui lòng nhập tiền phụ cấp"
                        data-parsley-maxlength="191"
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
