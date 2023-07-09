<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bonus;
use Illuminate\Support\Facades\Validator;
use App\Models\PaySalary;
use Carbon\Carbon;

class BonusController extends Controller
{
    public function __construct()
    {
        $this->module = 'bonus';
        $this->breadcrumb = [
            'object'    => 'Khen thưởng',
            'page'      => ''
        ];
        $this->title = 'Khen thưởng';
    }
    
    public function index()
    {
        $users = User::all();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'users' => $users,
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function create()
    {
        $users = User::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $this->title = 'Thêm mới khen thưởng';
        $data = [
            'users'         => $users,
            'module'        => $this->module,
            'breadcrumb'    => $this->breadcrumb,
            'title'         => $this->title,    
        ];
        return view("modules.{$this->module}.create", $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id'       => 'required',
                'salary_bonus'  => 'required',
                'content'       => 'required',
            ],
            [
                'user_id.required'      => 'Chưa chọn nhân viên',
                'salary_bonus.required' => 'Tiền thưởng không được trống',
                'content.required'      => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newBonus = Bonus::create([
            'user_id'       => $request->user_id,
            'salary_bonus'  => $request->salary_bonus,
            'content'       => $request->content
        ]);
        if($newBonus)
        {
            $monthNow = Carbon::now()->format('Y-m');
            $updatePaySalary = PaySalary::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->first();
            if($updatePaySalary!=null)
            {
                $sumBonus = Bonus::where('user_id',$request->user_id)->where('created_at',"LIKE", "%$monthNow%")->sum('salary_bonus');
                $updatePaySalary->sum_bonus = $sumBonus;
                $updatePaySalary->save();
            }
        }
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

    public function edit(Request $request)
    {
        $users = User::all();
        $bonus = Bonus::find($request->id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $this->title = 'Cập nhật khen thưởng';
        $data = [
            'users'         => $users,
            'bonus'         => $bonus,
        ];
        return $this->openView("modules.{$this->module}.update", $data);
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id'       => 'required',
                'salary_bonus'  => 'required',
                'content'       => 'required',
            ],
            [
                'user_id.required'      => 'Chưa chọn nhân viên',
                'salary_bonus.required' => 'Tiền thưởng không được trống',
                'content.required'      => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $bonus = Bonus::find($request->id);
        if (!empty($bonus)) {
            $bonus->user_id         = $request->user_id;
            $bonus->salary_bonus    = $request->salary_bonus;
            $bonus->content         = $request->content;
            $bonus->save();

            if($bonus)
            {
                $monthNow   = Carbon::now()->format('Y-m');
                $monthBonus = Carbon::parse($bonus->created_at)->format('Y-m');
                if($monthNow != $monthBonus)
                {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Không thể cập nhật tiền thưởng tháng trước',
                    ], 200);
                }
                $updatePaySalary = PaySalary::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->first();
                if($updatePaySalary!=null)
                {
                    $sumBonus = Bonus::where('user_id',$request->user_id)->where('created_at',"LIKE", "%$monthNow%")->sum('salary_bonus');
                    $updatePaySalary->sum_bonus = $sumBonus;
                    $updatePaySalary->save();
                }
            }

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
                'status'  => 'error',
                'message' => 'Cập nhật thất bại',
            ], 200);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $bonus      = Bonus::find($request->id);
            $monthNow   = Carbon::now()->format('Y-m');
            $monthBonus = Carbon::parse($bonus->created_at)->format('Y-m');
            if($monthNow != $monthBonus)
            {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Không thể xóa tiền thưởng tháng trước',
                ], 200);
            }
            Bonus::destroy($request->id);
            $updatePaySalary = PaySalary::where('user_id',$bonus->user_id)->where('month',"LIKE", "%$monthNow%")->first();
            if($updatePaySalary!=null)
            {
                $sumBonus = Bonus::where('user_id',$bonus->user_id)->where('created_at',"LIKE", "%$monthNow%")->sum('salary_bonus');
                $updatePaySalary->sum_bonus = $sumBonus;
                $updatePaySalary->save();
            }
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
    public function loadAjaxListBonus (Request $request)
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
        $totalRecords  = Bonus::count();
        $totalRecordswithFilter = Bonus::queryData($filter)->distinct()->count();
        $bonus = Bonus::select(['bonuses.*'])
            ->with('user')
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $bonus,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}
