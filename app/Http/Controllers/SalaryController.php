<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Contract;
use App\Models\Department;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->module = 'salary';
        $this->breadcrumb = [
            'object'    => 'Lương',
            'page'      => ''
        ];
        $this->title = 'Lương';
    }
    
    public function index()
    {
        $salary = Salary::all();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'salary' => $salary,
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function create()
    {
        $this->breadcrumb['page'] = 'Thêm mới';
        $this->title = 'Thêm mới';
        return $this->openView("modules.{$this->module}.create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name_create' => 'required|unique:App\Models\Salary,name',
                'salary_payable' => 'required',
            ],
            [
                'name_create.required' => 'Tên lương không được bỏ trống',
                'name_create.unique'    => 'Tên lương đã tồn tại',
                'salary_payable.required' => 'Lương cơ bản không được bỏ trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newContract = Salary::create([
            'name' => $request->name_create,
            'salary_payable' =>$request->salary_payable,
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

    public function show(Request $request)
    {
        $contract = Contract::where("user_id",$request->id)->first();
        $salary = Salary::find($contract->salary_id);
        return response()->json($salary);
    }

    public function edit($id)
    {
        $salary = Salary::find($id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $data = [
            'users'         => $user,
            'salary'        => $salary
        ];
        $this->title = 'Cập nhật';
        return $this->openView("modules.{$this->module}.update", $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name_update' => 'required|unique:App\Models\Salary,name,' . $request->id,
                'salary_payable' => 'required',
            ],
            [
                'name_update.required' => 'Tên lương không được bỏ trống',
                'name_update.unique' => 'Tên lương đã tồn tại',
                'salary_payable.required' => 'Lương cơ bản không được bỏ trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $update = Salary::find($request->id);
        $update->name = $request->name_update;
        $update-> salary_payable = $request->salary_payable;
        $update->save();
        if (!empty($update)) {
            $route = "{$this->module}.list";
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

    public function destroy(Request $request)
    {
        try {
            Salary::destroy($request->id);
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
    public function loadAjaxListSalary(Request $request)
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
        $totalRecords  = Salary::count();
        $totalRecordswithFilter = Salary::QueryData($filter)->distinct()->count();
        $salary = Salary::select(['salaries.*'])
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $salary,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
    
}
