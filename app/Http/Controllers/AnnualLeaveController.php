<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\AnnualLeave;
use Illuminate\Support\Facades\Validator;

class AnnualLeaveController extends Controller
{
    public function __construct()
    {
        $this->module = 'annual_leave';
        $this->breadcrumb = [
            'object'    => 'Nghĩ phép',
            'page'      => ''
        ];
        $this->title = 'Nghĩ phép';
    }   

    public function index()
    {
        $user           = User::all();
        $annual_leaves  = AnnualLeave::where('status',1)->get();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'users'        => $user,
            'annual_leave' => $annual_leaves
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function waitingListForApproval()
    {
        $user           = User::all();
        $annual_leaves  = AnnualLeave::where('status',0)->get();
        $this->breadcrumb['page'] = 'Danh sách chờ duyệt';
        $this->title    = 'Duyệt nghĩ phép';
        $data = [
            'users'        => $user,
            'annual_leave' => $annual_leaves
        ];
        return $this->openView("modules.{$this->module}.waiting", $data);
    }

    public function create()
    {
        $user = User::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $this->title = 'Thêm mới nghĩ phép';
        $data = [
            'users' => $user,
        ];
        return $this->openView("modules.{$this->module}.create", $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'start_date'    => 'required',
                'finish_date'   => 'required',
                'user_id'       => 'required',
                'reason'        => 'required',
            ],
            [
                'start_date.required'   => 'Ngày nghĩ từ nghĩ không được trống',
                'finish_date.required'  => 'Ngày nghĩ đến nghĩ không được trống',
                'user_id.required'      => 'Nhân viên không được trống',
                'reason.required'       => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        AnnualLeave::create(
            [
                'start_date'    => $request->start_date,
                'finish_date'   => $request->finish_date,
                'user_id'       => $request->user_id,
                'total_day'     => Carbon::parse($request->finish_date)->diffInDays(Carbon::parse($request->start_date)) + 1,
                'status'        => 0,
                'reason'        => $request->reason,
            ]
        );
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
        $annual_leave = AnnualLeave::find($id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $this->title = 'Cập nhật nghĩ phép';
        $data = [
            'users'         => $user,
            'annual_leave'  => $annual_leave
        ];
        return $this->openView("modules.{$this->module}.update", $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'start_date'    => 'required',
                'finish_date'   => 'required',
                'user_id'       => 'required',
                'reason'        => 'required',
            ],
            [
                'start_date.required'   => 'Ngày nghĩ từ nghĩ không được trống',
                'finish_date.required'  => 'Ngày nghĩ đến nghĩ không được trống',
                'user_id.required'      => 'Nhân viên không được trống',
                'reason.required'       => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $annual_leave = AnnualLeave::find($request->id);
        if (!empty($annual_leave)) {
            $annual_leave->start_date   = $request->start_date;
            $annual_leave->finish_date  = $request->finish_date;
            $annual_leave->user_id      = $request->user_id;
            $annual_leave->total_day    = Carbon::parse($request->finish_date)->diffInDays(Carbon::parse($request->start_date)) + 1;
            $annual_leave->reason       = $request->reason;
            $annual_leave->save();
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
    }

    public function updateReason(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reason_not_approving' => 'required',
            ],
            [
                'reason_not_approving.required'    => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'warning',
                'message'   => $validator->messages()->first(),
            ], 200);
        }
        $annual_leave = AnnualLeave::find($request->id);
        if (!empty($annual_leave)) {
            $annual_leave->status = 2;
            $annual_leave->reason_not_approving = $request->reason_not_approving;
            $annual_leave->save();
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
    }

    public function destroy(Request $request)
    {
        try {
            AnnualLeave::destroy($request->id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Đã xoá dữ liệu',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
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

    public function loadAjaxListAnnualLeave(Request $request)
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
        $totalRecords  = AnnualLeave::count();
        $totalRecordswithFilter = AnnualLeave::queryData($filter)->distinct()->count();
        $annual_leave = AnnualLeave::select(['annual_leaves.*'])
            ->leftjoin('users', 'users.id', '=', 'annual_leaves.user_id')
            ->with(['user'])
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $annual_leave,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }

    public function loadAjaxWaitingListForApproval(Request $request)
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
        $totalRecords  = AnnualLeave::where('status',0)->count();
        $totalRecordswithFilter = AnnualLeave::where('status',0)->queryData($filter)->distinct()->count();
        $annual_leave = AnnualLeave::where('status',0)->select(['annual_leaves.*'])
            ->leftjoin('users', 'users.id', '=', 'annual_leaves.user_id')
            ->with(['user'])
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $annual_leave,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
    public function approveLeaveApplication($id)
    {
        $annual_leave = AnnualLeave::find($id);
        if (!empty($annual_leave)) {
            $annual_leave->status = 1;
            $annual_leave->save();
        }
        return back()->with('status','Duyệt đơn thành công');
    }
}
