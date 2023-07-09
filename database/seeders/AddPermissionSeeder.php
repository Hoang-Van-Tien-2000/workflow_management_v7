<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; 

class AddPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permission_add = Permission::where('name', 'Thêm mới người dùng')->first();
        $permission_edit = Permission::where('name', 'Cập nhật người dùng')->first();
        $permission_delete = Permission::where('name', 'Xoá người dùng')->first();
        $permission_role = Permission::where('name', 'Phân quyền')->first();

        $permission_add->name = "Danh sách dự án";
        $permission_add->save();

        $permission_edit->name = "Thêm dự án";
        $permission_edit->save();

        $permission_delete->name =  "Cập nhật dự án";
        $permission_delete->save();

        $permission_role->name =  "Xóa dự án";
        $permission_role->save();
        
        $arr_permission = [
            'Danh sách công việc',
            'Thêm công việc',
            'Cập nhật công việc',
            'Xóa công việc',
            'Danh sách tất cả hợp đồng',
            'Danh sách hợp đồng của từng nhân viên',
            'Thêm hợp đồng',
            'Cập nhật hợp đồng',
            'Gia hạn hợp đồng',
            'Danh sách khách hàng',
            'Thêm khách hàng',
            'Cập nhật khách hàng',
            'Xóa khách hàng',
            'Danh sách nhân viên',
            'Cập nhật nhân viên',
            'Danh sách chức vụ',
            'Thêm chức vụ',
            'Cập nhật chức vụ',
            'Xóa chức vụ',
            'Danh sách phòng ban',
            'Thêm phòng ban',
            'Cập nhật phòng ban',
            'Xóa phòng ban',
            'Danh sách bảng lương',
            'Export bảng lương',
            'Danh sách tạm ứng, phụ cấp',
            'Thêm tạm ứng, phụ cấp',
            'Cập nhật tạm ứng, phụ cấp',
            'Xóa tạm ứng, phụ cấp',
            'Danh sách khen thưởng',
            'Thêm khen thưởng',
            'Cập nhật khen thưởng',
            'Xóa khen thưởng',
            'Danh sách xử phạt',
            'Thêm xử phạt',
            'Cập nhật xử phạt',
            'Xóa xử phạt',
            'Danh sách chấm công',
            'Duyệt chấm công',
            'Export chấm công',
            'Danh sách nghĩ phép',
            'Thêm mới nghĩ phép',
            'Cập nhật nghĩ phép',
            'Xóa nghĩ phép',
            'Duyệt nghĩ phép',
            'Quản lý cấu hình',
        ];

        for($i=1; $i<= 46; $i++)
        {
            Permission::create([
                'name'  =>  $arr_permission[$i -1]
            ]);
        }
    }
}
