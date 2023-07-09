@extends('master')
@section('main-content')
<style>
ul {
    list-style-type: none;
}
</style>
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <input type="hidden" value="{{$role->id}}" name="id">
                        <div class="col-md-6" style="margin-bottom:1%">
                            <label class="form-label" for="ten">Tên phân quyền<span class="required">*</span></label>
                            <input type="text" class="form-control" id="role_name" name="role_name"
                                value="{{$role->name}}"
                                placeholder="Tên phân quyền..."
                                data-parsley-required-message="Vui lòng nhập tên phân quyền"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                                data-check-checkname 
                                data-check-checkname-message="Tên phân quyền đã tồn tại"
                                required>
                        </div>
                        <div class="col-md-12 col-sm-12" style="margin-bottom:1%">
                            <label class="form-label" for="ten">Chọn phân quyền<span style="color:red;"> *</span></label>
                            <span id="required_checkbox"></span>
                            <div class="col-md-6">
                                <ul>
                                    <li>
                                        <input type="checkbox" name="tall" id="tall">
                                        <label for="tall">Tất cả</label>
                                        <ul>
                                            <li>
                                                <input type="checkbox" name="tall-1" id="tall-1">
                                                <label>Dự án</label>
                                                <ul>
                                                    @foreach ($permissionProject as $permission)
                                                        @if ($permission->name != 'Danh sách dự án')
                                                            <li>
                                                                <input class="permission project" type="checkbox" name="permission"
                                                                
                                                                    value="{{ $permission->id }}" id="tall-1-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission project" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-1-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-2" id="tall-2">
                                                <label>Công việc</label>
                                                <ul>
                                                    @foreach ($permissionWork as $permission)
                                                        @if ($permission->name != 'Danh sách công việc')
                                                            <li>
                                                                <input class="permission work" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-2-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission work" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-2-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-3" id="tall-3">
                                                <label>Hợp đồng</label>
                                                <ul>
                                                    @foreach ($permissionContract as $permission)
                                                        @if ($permission->name == 'Danh sách tất cả hợp đồng')
                                                            <li>
                                                                <input class="permission contract contract2" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-3-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @elseif ($permission->name == 'Danh sách hợp đồng của từng nhân viên')
                                                            <li>
                                                                <input class="permission contract2" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-3-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission contract" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-3-4" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-4" id="tall-4">
                                                <label>Khách hàng</label>
                                                <ul>
                                                    @foreach ($permissionCustomer as $permission)
                                                        @if ($permission->name != 'Danh sách khách hàng')
                                                            <li>
                                                                <input class="permission customer" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-4-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission customer" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-4-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-5" id="tall-5">
                                                <label>Người dùng</label>
                                                <ul>
                                                    @foreach ($permissionUser as $permission)
                                                        @if ($permission->name != 'Danh sách nhân viên')
                                                            <li>
                                                                <input class="permission user" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-5-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission user" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-5-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-6" id="tall-6">
                                                <label>Phân quyền</label>
                                                <ul>
                                                    @foreach ($permissionRole as $permission)
                                                        @if ($permission->name == 'Danh sách chức vụ')
                                                            <li>
                                                                <input class="permission role" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-6-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox" 
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission role" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-6-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox" 
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-7" id="tall-7">
                                                <label>Phòng ban</label>
                                                <ul>
                                                    @foreach ($permissionDepartment as $permission)
                                                        @if ($permission->name != 'Danh sách phòng ban')
                                                            <li>
                                                                <input class="permission department" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-7-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission department" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-7-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-8" id="tall-8">
                                                <label>Bảng lương</label>
                                                <ul>
                                                    @foreach ($permissionSalary as $permission)
                                                        @if ($permission->name != 'Danh sách bảng lương')
                                                            <li>
                                                                <input class="permission salary" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-8-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission salary" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-8-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-9" id="tall-9">
                                                <label>Tạm ứng - phụ cấp</label>
                                                <ul>
                                                    @foreach ($permissionAdvance as $permission)
                                                        @if ($permission->name != 'Danh sách tạm ứng, phụ cấp')
                                                            <li>
                                                                <input class="permission advance" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-9-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission advance" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-9-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-10" id="tall-10">
                                                <label>Khen thưởng</label>
                                                <ul>
                                                    @foreach ($permissionBonus as $permission)
                                                        @if ($permission->name != 'Danh sách khen thưởng')
                                                            <li>
                                                                <input class="permission bonus" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-10-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission bonus" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-10-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-11" id="tall-11">
                                                <label>Xử phạt</label>
                                                <ul>
                                                    @foreach ($permissionDiscipline as $permission)
                                                        @if ($permission->name != 'Danh sách xử phạt')
                                                            <li>
                                                                <input class="permission discipline" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-11-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission discipline" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-11-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-12" id="tall-12">
                                                <label>Châm công</label>
                                                <ul>
                                                    @foreach ($permissionTimesheet as $permission)
                                                        @if ($permission->name != 'Danh sách chấm công')
                                                            <li>
                                                                <input class="permission timesheet" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-12-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission timesheet" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-12-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="tall-13" id="tall-13">
                                                <label>Nghĩ phép</label>
                                                <ul>
                                                    @foreach ($permissionAnnualLeave as $permission)
                                                        @if ($permission->name != 'Danh sách nghĩ phép')
                                                            <li>
                                                                <input class="permission annual" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-13-1" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input class="permission annual" type="checkbox" name="permission"
                                                                    value="{{ $permission->id }}" id="tall-13-2" required
                                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                                    data-parsley-errors-container="#required_checkbox"
                                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permission->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                                <label>{{ $permission->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li>
                                                <input class="permission config" type="checkbox" name="permission"
                                                    value="{{ $permissionConfig->id }}" id="tall-14" required
                                                    data-parsley-required-message="Vui lòng chọn ít nhất một quyền"
                                                    data-parsley-errors-container="#required_checkbox"
                                                    @foreach ($permissionOfRole as $value) 
                                                                        @if ($permissionConfig->id == $value->permission_id) 
                                                                            checked 
                                                                        @endif
                                                                    @endforeach>
                                                <label>{{ $permissionConfig->name }}</label>
                                            </li>
                                        </ul>
                                    </li>
                                </ul> 
                            </div>
                        </div>
                        <div class="d-lg-flex justify-content-end">
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <button id="btn-update-modal" type="button" class="btn btn-primary px-5">Lưu</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('user.list') }}" class="btn btn-outline-primary px-5">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>
</div>
@section('page-js')

    <script>
        $("#role_id").multipleSelect({
            filter: true,
            selectAllText: 'Chọn tất cả',
            allSelected: 'Đã chọn tất cả',
            countSelected: 'Đã chọn # trên %',
            noMatchesFound: 'Không tìm thấy kết quả',
            minimumCountSelected: 1
        });
    </script>
<script>
  $( "#btn-update-modal" ).click(function() {
    if($('#frm-them-moi').parsley().validate()) {
        var formData = new FormData();
        $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
        $(".permission").each(function(i) {
                if (this.checked) {
                    formData.append('permission[]', this.value);
                }
            });
        $("input[name='role_name']").map(function() {
                formData.append('name', this.value)
        }).get();
        $.ajax({
                url: "{{route('role.update')}}",
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                if (res.status == 'success') {
                swal.fire({
                    title: res.message,
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    position: 'center',
                    padding: '2em',
                    timer: 1500,
                }).then((result) => {
                   if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.replace(res.redirect)
                    }
                })
            }else {
                Swal.fire({
                    title: res.message,
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    position: 'center',
                    padding: '2em',
                    timer: 1500,
                })
            }
        });
    }
})
</script>

<script>
    $('input[type="checkbox"]').change(function(e) {
    var checked = $(this).prop("checked"),
        container = $(this).parent(),
        siblings = container.siblings();

    container.find('input[type="checkbox"]').prop({
      indeterminate: false,
      checked: checked
    });

    function checkSiblings(el) {

      var parent = el.parent().parent(),
          all = true;

      el.siblings().each(function() {
        let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
        return returnValue;
      });
      
      if (all && checked) {

        parent.children('input[type="checkbox"]').prop({
          indeterminate: false,
          checked: checked
        });

        checkSiblings(parent);

      } else if (all && !checked) {

        parent.children('input[type="checkbox"]').prop("checked", checked);
        parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
        checkSiblings(parent);

      } else {

        el.parents("li").children('input[type="checkbox"]').prop({
          indeterminate: true,
          checked: false
        });

      }

    }
    checkSiblings(container);
    });
</script>
<script>
    $(".project").change(function() {
        var flag = false;
        $(".project").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-1-2").prop("checked", true);
        }
    });
</script>
<script>
    $(".work").change(function() {
        var flag = false;
        $(".work").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-2-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".contract").change(function() {
        var flag = false;
        $(".contract").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-3-1").prop("checked", true);
            $("#tall-3-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".contract2").change(function() {
        var flag = false;
        $(".contract2").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-3-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".contract3").change(function() {
        var flag = false;
        $(".contract3").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-3-1").prop("checked", true);
            $("#tall-3-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".customer").change(function() {
        var flag = false;
        $(".customer").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-4-2").prop("checked", true);
        }
    });
</script>  
<script>
    $(".user").change(function() {
        var flag = false;
        $(".user").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-5-2").prop("checked", true);
        }
    });
</script>
<script>
    $(".role").change(function() {
        var flag = false;
        $(".role").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-6-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".department").change(function() {
        var flag = false;
        $(".department").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-7-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".salary").change(function() {
        var flag = false;
        $(".salary").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-8-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".advance").change(function() {
        var flag = false;
        $(".advance").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-9-2").prop("checked", true);
        }
    });
</script>   
<script>
    $(".bonus").change(function() {
        var flag = false;
        $(".bonus").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-10-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".discipline").change(function() {
        var flag = false;
        $(".discipline").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-11-2").prop("checked", true);
        }
    });
</script> 
<script>
    $(".timesheet").change(function() {
        var flag = false;
        $(".timesheet").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-12-2").prop("checked", true);
        }
    });
</script>       
<script>
    $(".annual").change(function() {
        var flag = false;
        $(".annual").each(function(i) {
            if (this.checked) {
                flag = true;
            }
        });
        if (flag) {
            $("#tall-13-2").prop("checked", true);
        }
    });
</script>    
<script>
    $(document).ready(function() {
        var checkedLenght = $(".project").length;
        var total = 0;
        $(".project").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-1").prop("checked", true);
        } else {
            $("#tall-1").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".work").length;
        var total = 0;
        $(".work").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-2").prop("checked", true);
        } else {
            $("#tall-2").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".contract").length;
        var total = 0;
        $(".contract").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-3").prop("checked", true);
        } else {
            $("#tall-3").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".customer").length;
        var total = 0;
        $(".customer").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-4").prop("checked", true);
        } else {
            $("#tall-4").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".user").length;
        var total = 0;
        $(".user").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-5").prop("checked", true);
        } else {
            $("#tall-5").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".role").length;
        var total = 0;
        $(".role").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-6").prop("checked", true);
        } else {
            $("#tall-6").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".department").length;
        var total = 0;
        $(".department").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-7").prop("checked", true);
        } else {
            $("#tall-7").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".salary").length;
        var total = 0;
        $(".salary").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-8").prop("checked", true);
        } else {
            $("#tall-8").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".advance").length;
        var total = 0;
        $(".advance").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-9").prop("checked", true);
        } else {
            $("#tall-9").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".bonus").length;
        var total = 0;
        $(".bonus").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-10").prop("checked", true);
        } else {
            $("#tall-10").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".discipline").length;
        var total = 0;
        $(".discipline").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-11").prop("checked", true);
        } else {
            $("#tall-11").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".timesheet").length;
        var total = 0;
        $(".timesheet").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-12").prop("checked", true);
        } else {
            $("#tall-12").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var checkedLenght = $(".annual").length;
        var total = 0;
        $(".annual").each(function(i) {
            if (this.checked) {
                total++;
            }
        });
        if (total == checkedLenght) {
            $("#tall-13").prop("checked", true);
        } else {
            $("#tall-13").prop("indeterminate", true);
        }
    });
</script>
<script>
    $(document).ready(function() {
        var project         =    $("#tall-1")[0].checked;
        var work            =    $("#tall-2")[0].checked;
        var contract        =    $("#tall-3")[0].checked;
        var customer        =    $("#tall-4")[0].checked;
        var user            =    $("#tall-5")[0].checked;
        var role            =    $("#tall-6")[0].checked;
        var department      =    $("#tall-7")[0].checked;
        var salary          =    $("#tall-8")[0].checked;
        var advance         =    $("#tall-9")[0].checked;
        var bonus           =    $("#tall-10")[0].checked;
        var discipline      =    $("#tall-11")[0].checked;
        var timesheet       =    $("#tall-12")[0].checked;
        var annual          =    $("#tall-13")[0].checked;
        var config          =    $("#tall-14")[0].checked;
        if (project && work && customer && contract  && user  && role  && department && salary && advance && bonus && discipline && timesheet  && annual  && config) {
            $("#tall").prop("checked", true);
        } else {
            $("#tall").prop("indeterminate", true);
        }
    });
</script>
@endsection
@endsection
