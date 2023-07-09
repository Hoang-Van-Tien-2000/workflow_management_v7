<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Socialite;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->module = 'user';
        $this->breadcrumb = [
            'object'    => 'Nhân viên',
            'page'      => ''
        ];
        $this->title = 'Người dùng';
    }
    
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function createUser($getInfo, $provider)
    {

        $Account = User::where('email', $getInfo['email'])->first();

        if (empty($Account)) {
            $time = time();
            $random = Str::random(6);
            Storage::disk('avt')->put($time . $random . ".png", file_get_contents($getInfo->avatar));

            $user = new User();
            $user->name = $getInfo->name;
            $user->username = $getInfo->email;
            $user->phone = "";
            $user->email = $getInfo->email;
            $user->avatar = $time . $random . ".png";
            $user->role_id = 1;
            $user->nationality_id = 1;
            $user->password = "";
            $user->provider = $provider;
            $user->token = "";
            $user->otp = "";
            $user->expired_time = null;
            $user->google_id = "";
            $user->active = 1;
            $user->status = 1;
            $user->save();
            if ($provider == "github") {
                $infouser = $getInfo->user;
                $opts = [
                    'http' => [
                        'method' => 'GET',
                        'header' => [
                            'User-Agent: PHP',
                        ],
                    ],
                ];

                $context = stream_context_create($opts);
                $json = file_get_contents($infouser["repos_url"], false, $context);
                $decode = json_decode($json);
            }
            return $user;
        }

        return $Account;
    }
    public function callback(Request $request, $provider)
    {

        $getInfo = Socialite::driver($provider)->stateless()->user();
        $user = $this->createUser($getInfo, $provider);
        auth()->login($user);
        return redirect()->to('/');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = User::all();
        $user_phones = $user->where('phone', '!=', '')->pluck('phone')->sort();
        $user_fullnames = $user->pluck('fullname')->unique()->sort();
        $role = Role::all();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'user'      => $user,
            'role' => $role,
            'user_phone' => $user_phones,
            'user_fullname' => $user_fullnames
        ];
// return Auth::user();
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function getMaNhanVien()
    {
        $idNext = User::withTrashed()->max('id') + 1;
        return response()->json([
                'status' => 'success',
                'data' => 'NV'.$idNext,
            ], 200);
    }

    public function show(Request $request)
    {
        $id                         = $request->id;
        $user                       = User::find($id)->toArray();
        $role                       = Role::find($user['role_id']);
        $department                 = Department::find($user['department_id']);
        $user['role_name']          = $role->name;
        $user['department_name']    = $department->name;
        return response()->json($user);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        $department = Department::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'roles'         => $role,
            'departments'   => $department,
        ];
        $this->title = 'Thêm mới nhân viên';
        return $this->openView("modules.{$this->module}.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required',
                'username' => 'required|unique:App\Models\User,username,NULL,id,deleted_at,NULL',
                'password' => 'required',
                'birthday' => 'required',
                'phone' => 'required|unique:App\Models\User,phone,NULL,id,deleted_at,NULL',
                'address' => 'required',
                'citizen_identification' => 'required|unique:App\Models\User,citizen_identification,NULL,id,deleted_at,NULL',
                'email' => 'required|unique:App\Models\User,email,NULL,id,deleted_at,NULL',
                'role_id' => 'required',
                'department_id' => 'required',
                'avatar'   => 'mimes:jpg,jpeg,png,gif',
            ],
            [
                'fullname.required' => 'Họ tên không được trống',
                'username.required' => 'Tên đăng nhập không được trống',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'password.required' => 'Mật khẩu không được trống',
                'birthday.required' => 'Ngày sinh không được trống',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.required' => 'Số điện thoại không được trống',
                'address.required' => 'Địa chỉ không được trống',
                'citizen_identification.required' => 'CMND/CCCD không được trống',
                'citizen_identification.unique' => 'CMND/CCCD đã tồn tại',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại',
                'role_id.required' => 'Chưa chọn chức vụ',
                'avatar.mimes'     => 'Hình ảnh không hợp lệ',
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
                'code'                      => $request->code,
                'fullname'                  => $request->fullname,
                'username'                  => $request->username,
                'password'                  => Hash::make($request->password),
                'birthday'                  => $request->birthday,
                'phone'                     => preg_replace('/\s+/', '', $request->phone),
                'address'                   => $request->address,
                'citizen_identification'    => $request->citizen_identification,
                'email'                     => $request->email,
                'role_id'                   => $request->role_id,
                'department_id'             => $request->department_id
            ]
        );
        if($user)
        {
            $role = Role::find($request->role_id);
            $user->assignRole($role->name);
        }
        if ($request->hasfile('avatar')) {
            $folder         = public_path('/upload/avatars');
            $time           = time() . rand(1, 200);
            $image          = $request->file('avatar');
            $nameImage      = "{$time}.{$image->extension()}";
            $image->move($folder, $nameImage);
            $user->avatar  = "upload/avatars/{$nameImage}";
            $user->save();
        }
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::all();
        $this->breadcrumb['page'] = 'Cập nhật';
        $user = User::find($id);
        $department = Department::all();
        $data = [
            'user'      => $user,
            'roles' => $role,
            'departments'   => $department,
        ];
        $this->title = 'Cập nhật nhân viên';
        return $this->openView("modules.{$this->module}.update", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required',
                'username' => "required|unique:App\Models\User,username,{$request->id},id,deleted_at,NULL",
                'email' => "required|unique:App\Models\User,email,{$request->id},id,deleted_at,NULL",
                'phone' => "required|unique:App\Models\User,phone,{$request->id},id,deleted_at,NULL",
                'citizen_identification' => "required|unique:App\Models\User,citizen_identification,{$request->id},id,deleted_at,NULL",
                'address' => 'required',
                'role_id' => 'required',
                'department_id' => 'required',
            ],
            [
                'fullname.required' => 'Họ tên không được trống',
                'username.required' => 'Tên đăng nhập không được trống',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.required' => 'Số điện thoại không được trống',
                'citizen_identification.unique' => 'CMND/CCCD đã tồn tại',
                'citizen_identification.required' => 'CMND/CCCD không được trống',
                'address.required' => 'Địa chỉ không được trống',
                'role_id.required' => 'Chưa chọn chức vụ',
                'department_id.required' => 'Chưa chọn phòng ban',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find($request->id);
        if (!empty($user)) {
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->birthday = $request->birthday;
            $user->citizen_identification = $request->citizen_identification;
            $user->email = $request->email;
            $user->phone = preg_replace('/\s+/', '', $request->phone);
            $user->address = $request->address;
            $user->role_id = $request->role_id;
            $user->department_id = $request->department_id;

            if ($request->hasfile('avatar')) {
                $folder         = public_path('/upload/avatars');
                $time           = time() . rand(1, 200);
                $image          = $request->file('avatar');
                $nameImage      = "{$time}.{$image->extension()}";
                $image->move($folder, $nameImage);
                $user->avatar  = "upload/avatars/{$nameImage}";
            }

            $user->save();
        }
        $listRole = explode(",", $request->role_id);
        $delete_roles = Role::whereNotIn('id',$listRole)->get();
        foreach($delete_roles as $delete_role)
        {
            $user->removeRole($delete_role->name);
        }

        foreach($listRole as $id)
        {
            $role = Role::find($id);
            $user->assignRole($role->name);
        }
        $route = "{$this->module}.list";
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Cập nhật thành công',
                'redirect' => route($route)
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            User::destroy($request->id);
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
    public function checkRole()
    {
        $super_Admin = Auth::user()->hasRole('Super Admin');
        $permisionDelete = Auth::user()->hasPermissionTo('Xoá người dùng');
        if($super_Admin || $permisionDelete)
        {
            return true;
        }
        return false;
    }

    public function changePass(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'new_password'      => 'required|min:6|max:191',
                'enter_new_pass'    => 'required|max:191',
            ],
            [
                'new_password.required' => 'Chưa nhập mật khẩu mới',
                'new_password.min'      => 'Mật khẩu mới từ 6 đến 191 kí tự',
                'new_password.max'      => 'Mật khẩu mới từ 6 đến 191 kí tự',
                'enter_new_pass.required' => 'Chưa nhập lại mật khẩu mới',
                'enter_new_pass.max'    => 'Mật khẩu nhập lại không quá 191 kí tự',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'warning',
                'message'   => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find($request->id);
        if ($user == null) {
            return response()->json([
                'status'    => 'warning',
                'message'   => 'Không tìm thấy nhân viên này',
            ], 200);
        }
        if ($request->new_password != $request->enter_new_pass) {
            return response()->json([
                'status'    => 'warning',
                'message'   => 'Mật khẩu không trùng khớp! Hãy nhập lại',
            ], 200);
        }
        if (strlen($request->new_password) < 6) {
            return response()->json([
                'status'    => 'warning',
                'message'   => 'Nhập mật khẩu mới ít nhất 6 kí tự',
            ], 200);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        $route = "{$this->module}.list";
        return response()->json(
            [
                'status'    => 'success',
                'message'   => 'Cập nhật thành công',
                'redirect'  => route($route)
            ],);
    }
}
