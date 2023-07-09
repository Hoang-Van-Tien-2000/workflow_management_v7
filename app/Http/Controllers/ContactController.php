<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->module = 'contracts';
        $this->breadcrumb = [
            'object'    => 'Hợp đồng',
            'page'      => ''
        ];
        $this->title = 'Hợp đồng';
    }

    public function index()
    {
        $user = User::all();
        $Contract = Contract::all();
        $salary = Salary::all();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'contract' => $Contract,
            'users'      => $user,
            'salary'    =>$salary
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function getMaHoaDon()
    {
        $idNext = Contract::withTrashed()->max('id') + 1;
        return response()->json([
                'status' => 'success',
                'data' => 'HD'.$idNext,
            ], 200);
    }
    
    public function contractIsAboutToExpire()
    {
        $user = User::all();
        $Contracts = Contract::all();
        $listConTract = [];
        foreach($Contracts as $Contract)
        {
            if( Carbon::now()->diffInMonths(Carbon::parse($Contract->finish_date)) <= 6)
            {
                $listConTract[] = $Contract;
            }
        }
        $salary = Salary::all();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'contract' => $listConTract,
            'users'      => $user,
            'salary'    =>$salary
        ];
        return $this->openView("modules.{$this->module}.about_to_expire", $data);
    }

    public function create()
    {
        $user   = User::all();
        $salary = Salary::all();
        $role   = Role::where('name', '!=', 'Super Admin')->get();
        $department = Department::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'users'         => $user,
            'salary'        => $salary,
            'roles'         => $role,
            'departments'   => $department,
        ];
        $this->title = 'Thêm mới';
        return $this->openView("modules.{$this->module}.create", $data);
    }

    public function createNewUser()
    {
        $user = User::all();
        $salary = Salary::all();
        $role = Role::all();
        $department = Department::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'users'         => $user,
            'salary'        => $salary,
            'roles'         => $role,
            'departments'   => $department,
        ];
        $this->title = 'Thêm mới';
        return $this->openView("modules.{$this->module}.create_new_user", $data);
    }

    public function createOldUser()
    {
        $contracts = Contract::all();
        $user = User::all();
        foreach($contracts as $contract)
        {
            $user = $user->where('id', '!=' , $contract->user_id);
        }
        $salary = Salary::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'users'         => $user,
            'salary'    =>$salary,
        ];
        $this->title = 'Thêm mới';
        return $this->openView("modules.{$this->module}.create_old_user", $data);
    }

    public function storeOldUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code'          => 'required|unique:App\Models\Contract,code,NULL,id,deleted_at,NULL',
                'start_date'    => 'required',
                'finish_date'   => 'required',
                'signing_date'  => 'required',
                'user_id'       =>  'required|unique:App\Models\Contract,user_id,NULL,id,deleted_at,NULL',
                'content'       => 'required',
                'salary'        => 'required',
            ],
            [
                'code.required'         =>'Chưa có mã hợp đồng',
                'code.unique'           =>'Mã hợp đồng đã tồn tại',
                'user_id.required'      =>'Chưa chọn nhân viên',
                'user_id.unique'        =>'Nhân viên này đã có hợp đồng rồi bạn không thể tạo thêm',
                'start_date.required'   => 'Bạn chưa chọn ngày bắt đầu',
                'finish_date.required'  => 'Bạn chưa chọn ngày kết thúc',
                'signing_date.required' => 'Bạn chưa chọn ngày kí hợp đồng',
                'content.required'      => 'Bạn chưa nhập nội dung',
                'salary.required'       =>'Bạn chưa nhập lương',
                'content.required'      =>'Bạn chưa nhập nội dung',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newContract = Contract::create([
            'code'          =>  $request->code,
            'start_date'    =>  $request->start_date,
            'finish_date'   =>  $request->finish_date,
            'signing_date'  =>  $request->signing_date,
            'user_id'       =>  $request->user_id,
            'content'       =>  $request->content,
            'salary'        =>  $request->salary,
        ]);
        $route = "{$this->module}.list";
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Thêm thành công',
                'redirect' => route($route)
            ],
            200
        );
    }

    public function storeNewUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code'          => 'required|unique:App\Models\Contract,code,NULL,id,deleted_at,NULL',
                'start_date'    => 'required',
                'finish_date'   => 'required',
                'signing_date'  => 'required',
                'content'       => 'required',
                'salary'        => 'required',
                'fullname'      => 'required',
                'username'      => 'required|unique:App\Models\User,username,NULL,id,deleted_at,NULL',
                'password'      => 'required',
                'birthday'      => 'required',
                'phone'         => 'required|unique:App\Models\User,phone,NULL,id,deleted_at,NULL',
                'address'       => 'required',
                'citizen_identification' => 'required|unique:App\Models\User,citizen_identification,NULL,id,deleted_at,NULL',
                'email'         => 'required|unique:App\Models\User,email,NULL,id,deleted_at,NULL',
                'role_id'       => 'required',
                'department_id' => 'required',
            ],
            [
                'code.required'         =>'Chưa có mã hợp đồng',
                'code.unique'           =>'Mã hợp đồng đã tồn tại',
                'user_id.required'      =>'Chưa chọn nhân viên',
                'start_date.required'   => 'Bạn chưa chọn ngày bắt đầu',
                'finish_date.required'  => 'Bạn chưa chọn ngày kết thúc',
                'signing_date.required' => 'Bạn chưa chọn ngày kí hợp đồng',
                'content.required'      => 'Bạn chưa nhập nội dung',
                'salary.required'       =>'Bạn chưa nhập lương',
                'content.required'      =>'Bạn chưa nhập nội dung',
                'fullname.required'     => 'Họ tên không được trống',
                'username.required'     => 'Tên đăng nhập không được trống',
                'username.unique'       => 'Tên đăng nhập đã tồn tại',
                'password.required'     => 'Mật khẩu không được trống',
                'birthday.required'     => 'Ngày sinh không được trống',
                'phone.unique'          => 'Số điện thoại đã tồn tại',
                'phone.required'        => 'Số điện thoại không được trống',
                'address.required'      => 'Địa chỉ không được trống',
                'citizen_identification.required' => 'CMND/CCCD không được trống',
                'citizen_identification.unique' => 'CMND/CCCD đã tồn tại',
                'email.required'        => 'Email không được trống',
                'email.unique'          => 'Email đã tồn tại',
                'role_id.required'      => 'Chưa chọn chức vụ',
                'department_id.required' => 'Chưa chọn phòng ban',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::create(
            [
                'code'                      => $request->code_nv,
                'fullname'                  => $request->fullname,
                'username'                  => $request->username,
                'password'                  => Hash::make($request->password),
                'birthday'                  => $request->birthday,
                'phone'                     => preg_replace('/\s+/', '', $request->phone),
                'address'                   => $request->address,
                'citizen_identification'    => $request->citizen_identification,
                'email'                     => $request->email,
                'role_id'                   => $request->role_id,
                'department_id'             => $request->department_id,
                'avatar'                    => "upload/avatars/avatar.png"
            ]
        );
        if($user)
        {
            $role = Role::find($request->role_id);
            $user->assignRole($role->name);
        }

        $newContract = Contract::create([
            'code'          =>  $request->code,
            'start_date'    =>  $request->start_date,
            'finish_date'   =>  $request->finish_date,
            'signing_date'  =>  $request->signing_date,
            'user_id'       =>  $user->id,
            'content'       =>  $request->content,
            'salary'        =>  $request->salary,
        ]);
        $route = "{$this->module}.list";
        return response()->json(
            [
                'status'    => 'success',
                'message'   => 'Thêm thành công',
                'redirect'  => route($route)
            ],
            200
        );
    }

    public function edit($id)
    {
        $user = User::all();
        $contract = Contract::find($id);
        $salary = Salary::all();
        $this->breadcrumb['page'] = 'Cập nhật';
        $data = [
            'users'     => $user,
            'contract'  => $contract,
            'salary'    => $salary,
        ];
        $this->title = 'Cập nhật';
        return $this->openView("modules.{$this->module}.update", $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code'          =>  "required|unique:App\Models\Contract,code,{$request->id},id,deleted_at,NULL",
                'start_date'    => 'required',
                'finish_date'   => 'required',
                'signing_date'  => 'required',
                'user_id'       =>  'required',
                'content'       => 'required',
                'salary'        => 'required',
            ],
            [
                'code.required'         =>'Chưa có mã hợp đồng',
                'code.unique'           =>'Mã hợp đồng đã tồn tại',
                'user_id.required'      =>'Chưa chọn nhân viên',
                'start_date.required'   => 'Bạn chưa chọn ngày bắt đầu',
                'finish_date.required'  => 'Bạn chưa chọn ngày kết thúc',
                'signing_date.required' => 'Bạn chưa chọn ngày kí hợp đồng',
                'content.required'      => 'Bạn chưa nhập nội dung',
                'salary.required'       =>'Bạn chưa chọn loại lương',
                'content.required'      =>'Bạn chưa nhập nội dung',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $update = Contract::find($request->id);
        $oldContract = Contract::where('contract_id', $update->id)->first();
        if($oldContract != null)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Không được phép cập nhật hợp đồng cũ',
            ], 200);
        }
        $update->start_date     = $request->start_date;
        $update-> finish_date   = $request->finish_date;
        $update-> signing_date  = $request->signing_date;
        $update-> user_id       = $request->user_id;
        $update-> content       = $request->content;
        $update-> salary        = $request->salary;
        $update->save();
        if (!empty($update)) {
            $route = "{$this->module}.list";
            return response()->json(
                [
                    'status'    => 'success',
                    'message'   => 'Cập nhật thành công',
                    'redirect'  => route($route)
                ],
                200
            );
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thất bại',
            ], 200);
        }
    }

    public function destroy(Request $request)
    {
        try {
            Contract::destroy($request->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Đã xoá dữ liệu',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy yêu cầu',
            ], 200);
        }
    }

    public function customFilterAjax($filter, $columns)
    {
        if (!empty($columns)) {
            foreach ($columns as $column) {
                if ($column["search"]["value"] != null) {
                    $filter[$column["name"]] = $column["search"]["value"];
                }
            }
        }

        return $filter;
    }
    public function loadAjaxListContract(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowperpage      = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');
        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = trim($search_arr['value']); // Search value
        $filter['name'] =  $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);
        // Total records
        $totalRecords  = Contract::count();
        $totalRecordswithFilter = Contract::queryData($filter)->distinct()->count();
        $Contract = Contract::select(['contracts.*'])
        ->with(['user'])
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $Contract,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
    public function loadAjaxContractIsAboutToExpire(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowperpage      = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');
        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = trim($search_arr['value']); // Search value
        $filter['name'] =  $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);
        // Total records
        $totalRecords  = Contract::count();
        $totalRecordswithFilter = Contract::queryData($filter)->distinct()->count();
        $Contracts = Contract::select(['contracts.*'])
        ->with(['user'])
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $listConTract = [];
        foreach($Contracts as $Contract)
        {
            if( Carbon::now()->diffInMonths(Carbon::parse($Contract->finish_date)) <= 6)
            {
                $listConTract[] = $Contract;
            }
        }
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $listConTract,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}
