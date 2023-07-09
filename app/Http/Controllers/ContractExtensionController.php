<?php

namespace App\Http\Controllers;
use App\Models\Contract;
use App\Models\User;
use App\Models\Role;
use App\Models\ContractExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractExtensionController extends Controller
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
        $user_phones = $user->where('phone', '!=', '')->pluck('phone')->sort();
        $user_fullnames = $user->pluck('fullname')->unique()->sort();
        $role = Role::all();
        $this->breadcrumb['page'] = 'Danh sách người dùng';
        $data = [
            'user'      => $user,
            'role' => $role,
            'user_phone' => $user_phones,
            'user_fullname' => $user_fullnames
        ];
        return $this->openView("modules.{$this->module}.list_user", $data);
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

    public function loadAjaxListUser(Request $request)
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
        $filter['search'] =  $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);
        // Total records
        $totalRecords  = User::count();
        $totalRecordswithFilter = User::queryData($filter)->distinct()->count();
        $user = User::select(['users.*'])
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
            ->with(['role'])
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $user,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }

    public function loadFilterUser(Request $request)
    {
        $filteredObjects['fullname'] = [];
        $filteredObjects['phone']= [];
        $filteredObjects['role_id'] = [];

        $arrFullname = json_decode(($request->fullname));
        $arrPhone = json_decode(($request->phone));
        $arrRoleId = json_decode(($request->role_id));

        if($arrFullname==null)
        {
            if($arrPhone==null)
            {
                if($arrRoleId==null)
                {
                    $users= User::all();
                    foreach($users as $user)
                    {
                        if(!empty($user->fullname))
                        {
                            $flag = false;
                            foreach($filteredObjects['fullname'] as $fullname){
                                if($fullname==$user->fullname)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['fullname'],$user->fullname);
                            }
                        }
                        if(!empty($user->phone))
                        {
                            $flag = false;
                            foreach($filteredObjects['phone'] as $phone){
                                if($phone==$user->phone)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['phone'],$user->phone);
                            }
                        }
                    }
                    $roles= Role::all();
                    foreach($roles as $role)
                    {
                        array_push($filteredObjects['role_id'],$role);
                    }
                }
                else
                {
                    foreach($arrRoleId as $roleId)
                    {
                        $users= User::where('role_id', $roleId)->get();
                        foreach($users as $user)
                        {
                            if(!empty($user->fullname))
                            {
                                $flag = false;
                                foreach($filteredObjects['fullname'] as $fullname){
                                    if($fullname==$user->fullname)
                                    {
                                        $flag = true;
                                        break;
                                    }
                                }
                                if(!$flag){
                                    array_push($filteredObjects['fullname'],$user->fullname);
                                }
                            }
                            if(!empty($user->phone))
                            {
                                $flag = false;
                                foreach($filteredObjects['phone'] as $phone){
                                    if($phone==$user->phone)
                                    {
                                        $flag = true;
                                        break;
                                    }
                                }
                                if(!$flag){
                                    array_push($filteredObjects['phone'],$user->phone);
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                if($arrRoleId==null)
                {
                    foreach($arrPhone as $phone)
                    {
                        $user= User::where('phone', $phone)->first();
                        if(!empty($user->fullname))
                        {
                            $flag = false;
                            foreach($filteredObjects['fullname'] as $fullname){
                                if($fullname==$user->fullname)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['fullname'],$user->fullname);
                            }
                        }
                        if(!empty($user->role_id))
                        {
                            $roles= Role::find($user->role_id);
                            $flag = false;
                            foreach($filteredObjects['role_id'] as $role){
                                if($role['id']==$roles->id)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['role_id'],$roles);
                            }
                        }
                    }
                }
                else
                {
                    foreach($arrPhone as $phone)
                    {
                        foreach($arrRoleId as $roleId)
                        {
                            $users= User::where('phone', $phone)->where('role_id', $roleId)->get();
                            foreach($users as $user)
                            {
                                if(!empty($user->fullname))
                                {
                                    $flag = false;
                                    foreach($filteredObjects['fullname'] as $fullname){
                                        if($fullname==$user->fullname)
                                        {
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if(!$flag){
                                        array_push($filteredObjects['fullname'],$user->fullname);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else
        {
            if($arrPhone==null)
            {
                if($arrRoleId==null)
                {
                    foreach($arrFullname as $fullname)
                    {
                        $users= User::where('fullname',$fullname)->get();
                        foreach($users as $user)
                        {
                            if(!empty($user->phone))
                            {
                                $flag = false;
                                foreach($filteredObjects['phone'] as $phone){
                                    if($phone==$user->phone)
                                    {
                                        $flag = true;
                                        break;
                                    }
                                }
                                if(!$flag){
                                    array_push($filteredObjects['phone'],$user->phone);
                                }
                            }
                            $roles= Role::find($user->role_id);
                            $flag = false;
                            foreach($filteredObjects['role_id'] as $role){
                                if($role['id']==$roles->id)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['role_id'],$roles);
                            }
                        }
                    }
                }
                else
                {
                    foreach($arrFullname as $fullname)
                    {
                        foreach($arrRoleId as $roleId)
                        {
                            $users= User::where('fullname',$fullname)->where('role_id', $roleId)->get();
                            foreach($users as $user)
                            {
                                if(!empty($user->phone))
                                {
                                    $flag = false;
                                    foreach($filteredObjects['phone'] as $phone){
                                        if($phone==$user->phone)
                                        {
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if(!$flag){
                                        array_push($filteredObjects['phone'],$user->phone);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                if($arrRoleId==null)
                {
                    foreach($arrFullname as $fullname)
                    {
                        foreach($arrPhone as $phone)
                        {
                            $users= User::where('fullname',$fullname)->where('phone', $phone)->get();
                            foreach($users as $user)
                            {
                                if(!empty($user->role_id))
                                {
                                    $roles= Role::find($user->role_id);
                                    $flag = false;
                                    foreach($filteredObjects['role_id'] as $role){
                                        if($role['id']==$roles->id)
                                        {
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if(!$flag){
                                        array_push($filteredObjects['role_id'],$roles);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $filteredObjects;
    }

    public function contractOfUser($id)
    {
        $user = User::find($id);
        $this->breadcrumb['page'] = "Danh sách hợp đồng của ". $user->fullname;
        $data = [
            'user'         => $user,
            'id'            => $id,
        ];
        // dd($data);
        return $this->openView("modules.{$this->module}.list_contract_of_user", $data);
    }

    public function loadAjaxListContractOfUser(Request $request)
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
        $totalRecords  = Contract::where('user_id', $request->user_id)->count();
        $totalRecordswithFilter = Contract::where('user_id', $request->user_id)->distinct()->count();
        $Contract = Contract::select(['contracts.*'])->where('user_id', $request->user_id)
        ->with(['user'])
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

    public function renewPage($id)
    {
        $user = User::find($id);
        $contract = Contract::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $this->breadcrumb['page'] = 'Gia hạn hợp đồng '.$user->fullname;
        $data = [
            'user'      => $user,
            'contract'      => $contract,
        ];
        return $this->openView("modules.{$this->module}.renew_page", $data);
    }

    public function renew(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code'          => 'required|unique:App\Models\Contract,code,NULL,id,deleted_at,NULL',
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
            'contract_id'   =>  $request->contract_id,
        ]);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Thêm thành công',
                'redirect' => route('contracts.list_contract_of_user', ['id' => $request->user_id])
            ],
            200
        );
    }

    public function edit($id, $contract_id)
    {
        $user = User::find($id);
        $contract = Contract::find($contract_id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $data = [
            'user'         => $user,
            'contract'  => $contract,
        ];
        $this->title = 'Cập nhật';
        return $this->openView("modules.{$this->module}.update_renew", $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code'          =>  "required|unique:App\Models\Contract,code,{$request->contract_id},id,deleted_at,NULL",
                'start_date'    => 'required',
                'finish_date'   => 'required',
                'signing_date'  => 'required',
                'user_id'       => 'required',
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
        $update = Contract::find($request->contract_id);
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
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Cập nhật thành công',
                    'redirect' => route('contracts.list_contract_of_user', ['id' => $request->user_id])
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
}
