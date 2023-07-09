<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->module = 'profile';
        $this->breadcrumb = [
            'object'    => 'ScrumBoard',
            'page'      => ''
        ];
        $this->title = 'Profile';
    }
   
    public function list()
    {
        $user = User::find(auth()->user()->id);
        $this->breadcrumb['page'] = 'Profile page';
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'user'          => $user
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function UpdateAvt(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'avatar' => 'mimes:jpg,jpeg,png,gif',
            ],
            [
                'avatar.mimes' => 'Hình ảnh không hợp lệ',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find($request->id);
        if (!empty($user)) {
            if ($request->hasfile('avatar')) {
                $folder = public_path('/upload/avatars');
                $time = time() . rand(1, 200);
                $image = $request->file('avatar');
                $nameImage = "{$time}.{$image->extension()}";
                $image->move($folder, $nameImage);

                $user->avatar = "upload/avatars/{$nameImage}";
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Cập nhật hình ảnh thành công',
                    'redirect' => route("profile.list")
                ], 200);
            }
        }
        else
        {
            return response()->json([
                'status' => 'warning',
                'message' => 'Chưa chọn hình ảnh mới',
            ], 200);
        }
    }

    public function update(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required',
                'email' => "required|unique:App\Models\User,email,{$id},id,deleted_at,NULL",
                'phone' => "required|unique:App\Models\User,phone,{$id},id,deleted_at,NULL",
                'citizen_identification' => "required|unique:App\Models\User,citizen_identification,{$id},id,deleted_at,NULL",
                'address' => 'required',
            ],
            [
                'fullname.required' => 'Họ tên không được trống',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.required' => 'Số điện thoại không được trống',
                'address.required' => 'Địa chỉ không được trống',
                'citizen_identification.unique' => 'CMND/CCCD đã tồn tại',
                'citizen_identification.required' => 'CMND/CCCD không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find(auth()->user()->id);
        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy nhân viên này',
            ], 200);
        }
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phone = preg_replace('/\s+/', '', $request->phone);
        $user->address = $request->address;
        $user->birthday = $request->birthday;
        $user->citizen_identification = $request->citizen_identification;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công',
            'redirect' => route('profile.list')
        ], 200);
    }

    public function updatePass(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|max:191',
                'new_password' => 'required|min:6|max:191',
                'enter_new_pass' => 'required|max:191',
            ],
            [
                'password.required' => 'Chưa nhập mật khẩu cũ',
                'password.max' => 'Nhập mật khẩu tối đa 191 kí tự',
                'new_password.required' => 'Chưa nhập mật khẩu mới',
                'new_password.max' => 'Nhập mật khẩu mới từ 6 đến 191 kí tự',
                'new_password.min' => 'Nhập mật khẩu mới từ 6 đến 191 kí tự',
                'enter_new_pass.required' => 'Chưa nhập lại mật khẩu mới',
                'new_password.max' => 'Nhập lại mật khẩu tối đa 191 kí tự',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find(auth()->user()->id);
        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy nhân viên này',
            ], 200);
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu sai! Hãy nhập lại',
            ], 200);
        } elseif ($request->new_password != $request->enter_new_pass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu không trùng khớp! Hãy nhập lại',
            ], 200);
        }
        if (strlen($request->new_password) < 6) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nhập mật khẩu mới ít nhất 6 kí tự',
            ], 200);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật mật khẩu thành công',
            'redirect' => route('profile.list')
        ], 200);
    }
}
