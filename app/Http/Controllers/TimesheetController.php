<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TimeSheetExport;
use App\Exports\ExportTimesheetOfDepartment;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->module = 'Timesheet';
        $this->breadcrumb = [
            'object'    => 'Chấm công',
            'page'      => ''
        ];
        $this->title = 'Chấm công';
    }

    public function index(Request $request)
    {
// dd($request->all());
        $departments = Department::all();
        $dateTimesheets = Timesheet::where('checkout','!=',null)->where('status',1)->selectRaw("substring(checkin,1,7)")->distinct()->get();
        if(!empty($request->user_id) || !empty($request->month))
        {
            $Timesheets = Null;
            $Timesheets = Timesheet::where('checkout','!=',null)->where('status',1)
                                    ->leftJoin('users','users.id','=','timesheets.user_id');

            $arr_user = json_decode($request->user_id);
            $arr_month = json_decode($request->month);
            $arr_department = json_decode($request->department_id);
            
            if(!empty($arr_user))
            {
                $users = User::whereIn('users.id', $arr_user);
            }
            else
            {
                $users = User::where('users.id', '>', 0);
            }
            if(!empty($arr_department))
            {
                $users = $users->whereIn('users.department_id',$arr_department);
            }
            $users = $users->leftJoin('roles','roles.id','=','users.role_id')
            ->where('roles.name','!=','Super Admin')
            ->select('users.*','roles.name as nameRole')->get();

            if (!empty($arr_month)) {
                $month = substr($arr_month,5,7);
                $year = substr($arr_month,0,4);
                $monthNow = $arr_month;
                $endate = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
                $Timesheets->whereMonth('checkin','=',$month)->whereYear('checkin','=',$year);         
            } 
            else
            {
                $monthNow = Carbon::now()->format('Y-m');
                $endate =(int) Carbon::now()->endOfMonth()->format('d');
            }

            if (is_array($arr_user) && !empty($arr_user)) {
               $Timesheets->whereIn('timesheets.user_id', $arr_user); 
            } 

            $Timesheets = $Timesheets->get();
            $loadPage = view("modules.Timesheet.loadtable",compact('departments','endate','users','dateTimesheets','Timesheets','monthNow'))->render();
            // dd($loadPage);
            return response()->json([
                'data' => $loadPage
            ]);
        }
        else
        {
            $endate =(int) Carbon::now()->endOfMonth()->format('d');
            $monthNow = Carbon::now()->format('Y-m');
            $Timesheet = Timesheet::where('checkout','!=',null)->where('status',1)->get();
            $user = User::where('users.id','>',0)->leftJoin('roles','roles.id','=','users.role_id')
                ->where('roles.name','!=','Super Admin')
                ->select('users.*','roles.name as nameRole')
                ->get();
        }

        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'Timesheets' => $Timesheet,
            'users'      => $user,
            'endate'    => $endate,
            'monthNow'    => $monthNow,
            'dateTimesheets' => $dateTimesheets ,
            'departments' => $departments
            // 'monthNow'       => $monthNow

        ];
        // if($request->user_id != [])
        // {
            // dd($user); 
        // }
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function search(Request $request)
    {
        $user = User::where('users.id','>',0);
        if($request->user_id != null)
        {
            $user = $user->whereIn('users.id',json_decode( $request->user_id));
        }
        $user = $user->leftJoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','!=','Super Admin')
        ->select('users.*','roles.name as nameRole')
        ->get();

        $Timesheet = Timesheet::where('checkout','!=',null)->where('status',1)->get();
        $dateTimesheet = Timesheet::where('checkout','!=',null)->where('status',1)->selectRaw("substring(checkin,1,7)")->distinct()->get();

      $endate =(int) Carbon::now()->endOfMonth()->format('d');
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'Timesheets' => $Timesheet,
            'users'      => $user,
            'endate'    => $endate,
            'dateTimesheets' => $dateTimesheet ,
            // 'monthNow'       => $monthNow

        ];
        // if($request->user_id != [])
        // {
        //     dd($user); 
        // }
        return $this->openView("modules.{$this->module}.search", $data);
    }
    public function listTimesheet()
    {
        $user = User::where('users.id','>',0)
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','!=','Super Admin')
        ->select('users.*','roles.name as nameRole')
        ->get();
        $dateTimesheet = Timesheet::where('checkout','!=',null)->selectRaw("substring(checkin,1,7)")->distinct()->get();

        $monthNow = Carbon::now()->format('Y-m');
        $Timesheet = Timesheet::where('checkout','!=',null)
        ->where('checkin','LIKE',"%$monthNow%")->get();
        $this->title="Duyệt chấm công";
        $data = [
            'Timesheets' => $Timesheet,
            'users'      => $user,
            'dateTimesheets' => $dateTimesheet ,
        ];
        // dd($data);
        return $this->openView("modules.{$this->module}.list_acceptance", $data);
    }
// Cập nhật lại giờ checkin check out
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'              => "required|unique:App\Models\Department,name,{$request->id},id,deleted_at,NULL",
                'user_id_update'    =>'required'
            ],
            [
                'name.unique'               => 'Tên phòng ban đã tồn tại',
                'name.required'             => 'Tên phòng ban không được trống',
                'user_id_update.required'   => 'Tên bạn chưa chọn trưởng phòng cho phòng ban này!',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $department = Department::find($request->id);
        if (!empty($department)) {
            $department->name = $request->name;
            $department->user_id = $request->user_id_update;
            $department->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thất bại',
            ], 200);
        }
    }

    public function loadAjaxListTimesheetAcctance(Request $request)
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
        $totalRecords  = Timesheet::where('checkout','!=',null)
        ->leftJoin('users','users.id','=','timesheets.user_id')
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','!=','Super Admin')
        ->QueryData($filter)->count();
        
        $totalRecordswithFilter = Timesheet::where('checkout','!=',null)
        ->leftJoin('users','users.id','=','timesheets.user_id')
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','!=','Super Admin')
         ->QueryData($filter)->distinct()->count();
        
         $PaySalary = Timesheet::where('checkout','!=',null)->select(['timesheets.*'])

        ->with(['user'])
        ->leftJoin('users','users.id','=','timesheets.user_id')
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','!=','Super Admin')
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        // dd($filter);
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $PaySalary,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
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

    public function loadAjaxListTimesheet(Request $request)
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
        $totalRecords  = Timesheet::where('checkout','!=',null)->where('status',1)->count();
        $totalRecordswithFilter = Timesheet::where('checkout','!=',null)->where('status',1)->queryData($filter)->distinct()->count();
        $PaySalary = Timesheet::where('checkout','!=',null)->where('status',1)->select(['timesheets.*'])
        ->with(['user'])
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $PaySalary,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }

    public function checkIn(){
        $user = Timesheet::where('user_id', Auth::user()->id)->orderBy('checkin', 'desc')->first();
        $checkin = Timesheet::where('user_id',Auth::user()->id)
        ->where('date',Carbon::now()->format('Y-m-d'))->first();
        if(empty($user)){
            $response = [
                "status" => "checkin",
            ];
            return response()->json($response);
        }
        if(empty($user->checkout) && $user->date < Carbon::now()->format('Y-m-d')){
            $response = [
                "status" => "checkout",
            ];
            return response()->json($response);
        }
        if(empty($checkin)){    
            $response = [
                "status" => "checkin",
            ];
            return response()->json($response);
        }
        
        $response = [
            "status" => "success",
        ];
        return response()->json($response);
    }
    public function authCheckin(){
        $checkin = new Timesheet();
        $checkin->user_id = Auth::user()->id;
        $checkin->date = Carbon::now();
        $checkin->checkin = Carbon::now(); //Lấy thời gian checkin
        $checkin->status = 0;
        $checkin->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Checkin Thành công',
            ],
            200
        );
    }

    public function checkOut(){
        $user = Timesheet::where('user_id', Auth::user()->id)->orderBy('checkin', 'desc')->first();
        if(!empty($user)){
            $user->checkout = Carbon::now();
            $user->save();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Checkout thành công',
                ],
                200
            );
        } 
        return response()->json(
            [
                'status' => 'error',
                'message' => 'Checkout thất bại',
            ],
            200
        );
    }
    public function checkoutAt(){
        $checkout = Timesheet::where('user_id',Auth::user()->id)
        ->where('date',Carbon::now()->format('Y-m-d'))->first(); //Kiểm tra xem user có tồn tại không
        if($checkout->checkout != null && !empty($checkout)){
            $response = [
                "status" => "success",
            ];
            return response()->json($response);
        } 
        $response = [
            "status" => "error",
        ];
        return response()->json($response);
    }

    public function exportTimesheet($id, $time)
    {
        $user = User::find($id);
        return Excel::download(new TimeSheetExport($id, $time), "bang_cham_cong_".$user->fullname."_"."$time.xlsx");
    } 

    public function exportTimesheetOfDepartment(Request $request)
    {
        return Excel::download(new ExportTimesheetOfDepartment($request->phong_ban, $request->thang), "bang_cham_cong_theo_phong_ban.xlsx");
    } 
    
    public function approve($id)
    {
        $Timesheet = Timesheet::find($id);
        $Timesheet->status = 1;
        $Timesheet->save();
        $route = "{$this->module}.list_timesheet";
        return redirect()->route($route);   
    }

    public function cancelApproval($id)
    {
        $Timesheet = Timesheet::find($id);
        $Timesheet->status = 2;
        $Timesheet->save();
        $route = "{$this->module}.list_timesheet";
        return redirect()->route($route);   
    }

    public function checkoutOld(){
        $user = Timesheet::where('user_id', Auth::user()->id)->orderBy('checkin', 'desc')->first();
        if(empty($user->checkout) && $user->date < Carbon::now()->format('Y-m-d')){
            return false;
        }
        return true;
    }
}
