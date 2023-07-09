<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdvanceAllowance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\PaySalary;

class AdvanceAllowanceController extends Controller
{
    public function __construct()
    {
        $this->module = 'advance_allowance';
        $this->breadcrumb = [
            'object'    => 'Tạm ứng và phụ cấp',
            'page'      => ''
        ];
        $this->title = 'Tạm ứng và phụ cấp';
    }

    public function index()
    {
      $checkRole = Auth::user()->hasRole('Super Admin');
      if($checkRole)
      {
            $departments = AdvanceAllowance::all();
           
      }else{
            $departments = AdvanceAllowance::where('user_id',Auth::user()->id)->get();
      }
      $user = User::where('username','!=','superadmin')->get();
      $this->breadcrumb['page'] = 'Danh sách';
      $data = [
          'departments' => $departments,
          'users' =>$user
      ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' =>'required'
            ],
            [
                'user_id.required' => 'Bạn chưa chọn tên nhân viên',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newAdvanceAllowance = AdvanceAllowance::create([
            'user_id'   => $request->user_id,
            'advance'   => $request->advance,
            'allowance' => $request->allowance,
            'month'     => Carbon::now()->format('d-m-Y H:m:s')

        ]);
        if($newAdvanceAllowance)
        {
            $monthNow       = Carbon::now()->format('m-Y');
            $sumAdvance     = AdvanceAllowance::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->sum('advance');
            $sumAllowance   = AdvanceAllowance::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->sum('allowance');  
            $monthNow       = Carbon::now()->format('Y-m');
            $updatePaySalary = PaySalary::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->first();
            if($updatePaySalary != null)
            {
                $updatePaySalary->allowance = $sumAllowance;
                $updatePaySalary->advance   = $sumAdvance;
                $updatePaySalary->save();   
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
        ], 200);
    }

    public function update(Request $request)
    {
        $AdvanceAllowance = AdvanceAllowance::find($request->id);
        if (!empty($AdvanceAllowance)) {
           $AdvanceAllowance->user_id   = $request->user_id_update;
           $AdvanceAllowance->advance   = $request->advance;
           $AdvanceAllowance->allowance = $request->allowance;
           $AdvanceAllowance->month     = Carbon::now()->format('d-m-Y H:m:s');
           $AdvanceAllowance->save();
           if($AdvanceAllowance)
           {
               $monthNow = Carbon::now()->format('m-Y');
               $monthAdvanceAllowance = Carbon::parse($AdvanceAllowance->month)->format('m-Y');
                if($monthNow != $monthAdvanceAllowance)
                {
                    return response()->json([
                        'status'    => 'warning',
                        'message'   => 'Không thể cập nhật tạm ứng, trợ cấp tháng trước',
                    ], 200);
                }
               $sumAdvance      = AdvanceAllowance::where('user_id',$AdvanceAllowance->user_id)->where('month',"LIKE", "%$monthNow%")->sum('advance');
               $sumAllowance    = AdvanceAllowance::where('user_id',$AdvanceAllowance->user_id)->where('month',"LIKE", "%$monthNow%")->sum('allowance');
               $monthNow        = Carbon::now()->format('Y-m');
               $updatePaySalary = PaySalary::where('user_id',$AdvanceAllowance->user_id)->where('month',"LIKE", "%$monthNow%")->first();
               if($updatePaySalary != null)
               {
                    $updatePaySalary->allowance     = $sumAllowance;
                    $updatePaySalary->advance       = $sumAdvance;
                    $updatePaySalary->save();
               }
           }
            return response()->json([
                'status'  => 'success',
                'message' => 'Cập nhật thành công',
            ], 200);
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
            $AdvanceAllowance   = AdvanceAllowance::find($request->id);
            $monthNow           = Carbon::now()->format('m-Y');
            $monthAdvanceAllowance = Carbon::parse($AdvanceAllowance->month)->format('m-Y');
            if($monthNow != $monthAdvanceAllowance)
            {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Không thể xóa tạm ứng, trợ cấp tháng trước',
                ], 200);
            }
            AdvanceAllowance::destroy($request->id);
            $sumAdvance     = AdvanceAllowance::where('user_id',$AdvanceAllowance->user_id)->where('month',"LIKE", "%$monthNow%")->sum('advance');
            $sumAllowance   = AdvanceAllowance::where('user_id',$AdvanceAllowance->user_id)->where('month',"LIKE", "%$monthNow%")->sum('allowance');
            $monthNow       = Carbon::now()->format('Y-m');
            $updatePaySalary = PaySalary::where('user_id',$AdvanceAllowance->user_id)->where('month',"LIKE", "%$monthNow%")->first();
            if($updatePaySalary != null)
            {
                $updatePaySalary->allowance = $sumAllowance;
                $updatePaySalary->advance   = $sumAdvance;
                $updatePaySalary->save();
            }
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

    public function loadAjaxListAdvanceAllowance(Request $request)
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
        $checkRole = Auth::user()->hasRole('Super Admin');
        if($checkRole)
        {
              $AdvanceAllowance = AdvanceAllowance::where('id','>',0);
             
        }else{
              $AdvanceAllowance = AdvanceAllowance::where('user_id',Auth::user()->id);
        }
        $AdvanceAllowance       = AdvanceAllowance::where('advance_allowances.id','>',0);
        $totalRecords           = $AdvanceAllowance->count();
        $totalRecordswithFilter = $AdvanceAllowance->queryData($filter)->distinct()->count();
        $AdvanceAllowance       =$AdvanceAllowance->select(['advance_allowances.*','users.fullname' ])
            ->leftJoin('users','users.id','=','advance_allowances.user_id')
            ->with('user')  
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $AdvanceAllowance,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}
