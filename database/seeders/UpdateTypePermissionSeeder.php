<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; 
use Spatie\Permission\Models\Role;

class UpdateTypePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_permission = [
            'Dự án',
            'Dự án',
            'Dự án',
            'Dự án',
            'Công việc',
            'Công việc',
            'Công việc',
            'Công việc',
            'Hợp đồng',
            'Hợp đồng',
            'Hợp đồng',
            'Hợp đồng',
            'Hợp đồng',
            'Khách hàng',
            'Khách hàng',
            'Khách hàng',
            'Khách hàng',
            'Nhân viên',
            'Nhân viên',
            'Chức vụ',
            'Chức vụ',
            'Chức vụ',
            'Chức vụ',
            'Phòng ban',
            'Phòng ban',
            'Phòng ban',
            'Phòng ban',
            'Bảng lương',
            'Bảng lương',
            'Tạm ứng, phụ cấp',
            'Tạm ứng, phụ cấp',
            'Tạm ứng, phụ cấp',
            'Tạm ứng, phụ cấp',
            'Khen thưởng',
            'Khen thưởng',
            'Khen thưởng',
            'Khen thưởng',
            'Xử phạt',
            'Xử phạt',
            'Xử phạt',
            'Xử phạt',
            'Chấm công',
            'Chấm công',
            'Chấm công',
            'Nghĩ phép',
            'Nghĩ phép',
            'Nghĩ phép',
            'Nghĩ phép',
            'Nghĩ phép',
            'Cấu hình',
        ];

        foreach(Permission::all() as $permission) {
            $permission->type = $arr_permission[$permission->id-1];
            $permission->save();
        }

        $role_admin = Role::where('name','Super Admin')->first();

        $arr_permission = [
            5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,
            41,42,43,44,45,46,47,48,49,50  // quyền nv thu tiền
        ];
       
        foreach(Permission::all() as $permission) {
            if(in_array($permission->id, $arr_permission)) {
                $permission->assignRole($role_admin);
            }
        }
    }
}
