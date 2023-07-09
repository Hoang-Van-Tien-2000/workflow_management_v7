<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
class ConfigController extends Controller
{
    public function __construct()
    {
        $this->module = 'config';
        $this->breadcrumb = [
            'object'    => 'Cấu hình',
            'page'      => ''
        ];
        $this->title = 'Cấu hình';
    }

    public function edit()
    {
        $config = Config::find(1);
        $this->breadcrumb['page'] = 'Cập nhật';
        $this->title = 'Cập nhật cấu hình';
        $data = [
            'config'         => $config
        ];
        return $this->openView("modules.{$this->module}.update", $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'work_date_in_month'                => 'required',
            ],
            [
                'work_date_in_month.required'       => 'Chưa nhập số ngày đi làm một tháng',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $config = Config::find(1);
        if (!empty($config)) {
            $config->work_date_in_month     = $request->work_date_in_month;
            $config->in_hour                = $request->in_hour;
            $config->out_hour               = $request->out_hour;
            $config->save();
            $route = "{$this->module}.edit";
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Cập nhật thành công',
                    'redirect' => route($route)
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
