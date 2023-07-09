<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use App\Models\PaySalary;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\Config;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalaryUserExport;
use App\Exports\ExportSalaryOfDepartment;
class PaySalarieController extends Controller
{
    public function __construct()
    {
        $this->module = 'pay_salaries';
        $this->breadcrumb = [
            'object'    => 'Bảng lương',
            'page'      => ''
        ];
        $this->title = 'Bảng lương';
    }

    public function index()
    {
        
        $dates = PaySalary::selectRaw("substring(month,1,7)")->distinct()->get();
        $departments = Department::all();
        $Contract = Contract::all();
        $idUser =  $Contract->pluck('user_id')->unique()->sort();
        $user = User::whereIn('users.id',$idUser)->leftJoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','!=','Super Admin')
        ->select('users.*')->get();
     
            foreach($user as $us)
            {
                $Contract = Contract::where('user_id',$us->id)->orderBy('id','desc')->first();
                $work_date_in_month = (integer)Config::first()->work_date_in_month;
                $checkSalaryPayable = (float)$Contract->salary / $work_date_in_month;
                $monthNow = Carbon::now()->format('Y-m');
                $checkTimeSheets = Timesheet::where('user_id',$us->id)->where('checkin','LIKE',"%$monthNow%")->where('checkout','!=',null)->where('status',1)->get();
                $working_day = 0;
                foreach($checkTimeSheets as $checkTimeSheet)
                {
                    if(Carbon::parse($checkTimeSheet->checkin)->diffInHours(Carbon::parse($checkTimeSheet->checkout)) > 4)
                    {
                        $working_day += 1;
                    }
                    else
                    {
                        $working_day += 0.5;
                    }
                }
                        $checkPaySalary = PaySalary::where('month',"LIKE", "%$monthNow%")
                                ->where('user_id',$us->id,)->first();
                            if(empty($checkPaySalary))
                            {
                                $newPaySalary = PaySalary::create([
                                    'contract_id'   =>  $Contract->id,
                                    'user_id'       =>  $us->id,
                                    'working_day'   =>  $working_day,
                                    'salary'        =>  $working_day*(float)$checkSalaryPayable,
                                    'allowance'     =>  0,
                                    'total'         =>   $working_day*(float)$checkSalaryPayable,
                                    'advance'       =>  0,
                                    'actual_salary' =>   $working_day*(float)$checkSalaryPayable,
                                    'month'         =>  Carbon::now()->format('Y-m-d H:i:s'),
                                    'status'        =>  0,
                                ]);
                            }else{
                                $checkPaySalary->contract_id = $Contract->id;
                                $checkPaySalary->working_day = $working_day;
                                $checkPaySalary-> salary = $working_day*(float)$checkSalaryPayable;
                                $checkPaySalary-> total = $working_day*(float)$checkSalaryPayable + $checkPaySalary->allowance;
                                $checkPaySalary-> actual_salary = $working_day*(float)$checkSalaryPayable + $checkPaySalary->allowance - $checkPaySalary->advance
                                + $checkPaySalary->sum_bonus - $checkPaySalary->sum_discipline;
                                $checkPaySalary->month  = Carbon::now()->format('Y-m-d H:i:s');
                                $checkPaySalary->save();
                            }
            }
        $paySalary = PaySalary::all();
        $datePaySalary = PaySalary::where('id','>',0)->selectRaw("substring(month,1,7)")->distinct()->get();
        $role = Role::all();

        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'paySalary' => $paySalary,
            'users'      => $user,
            'roles'    => $role,
            'monthPaySalarys' => $datePaySalary,
            'dates' => $dates,
            'departments' => $departments
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $salary = Salary::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'users'         => $user,
            'salarys'    =>$salary,
        ];
        $this->title = 'Thêm mới';
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
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'working_day' => 'required',
                'salary' => 'required',
                'allowance' => 'required',
                'user_id' =>  'required',
                'total' => 'required',
                'advance' => 'required',
                'actual_salary' => 'required',
                'status' => 'required',
            ],
            [
                'working_day.required' => 'Bạn chưa nhập số ngày công',
                'salary.required' => 'Bạn chưa nhập lương',
                'allowance.required' => 'Bạn chưa nhập trợ cấp',
                'user_id.required' => 'Bạn chưa chọn nhân viên',
                'total.required' =>'Bạn chưa có tổng lương',
                'advance.required' =>'Bạn chưa nhập ứng lương',
                'actual_salary.required' =>'Bạn chưa nhập lương thực tế',
                'status.required' =>'Bạn chưa chọn trạng thái',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $monthNow = substr(Carbon::now()->format('Y-m-d H:i:s'),4,7);
        $checkPaySalary = PaySalary::where('user_id',$request->user_id)->where('month','LIKE',"%$monthNow%")->count();
        if($checkPaySalary>0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Nhân viên này đã được tính lương tại tháng hiện tại!',
            ], 200);
        }
        $Contract = Contract::where('user_id',$request->user_id)->first();
// dd(Carbon::now()->format('Y-m-d H:i:s'));
        $newPaySalary = PaySalary::create([
            'contract_id'     =>  $Contract->contract_id,
            'user_id'       =>  $request->user_id,
            'working_day'   =>  $request->working_day,
            'salary'        =>  $request->salary,
            'allowance'     =>  $request->allowance,
            'total'         =>  $request->total,
            'advance'       =>  $request->advance,
            'actual_salary' =>  $request->actual_salary,
            'month'         =>  Carbon::now()->format('Y-m-d H:i:s'),
            'status'        =>  $request->status,
        ]);
// dd( $newPaySalary);
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

  

    public function edit($id)
    {
        $PaySalary = PaySalary::find($id);
        // dd($PaySalary);
        $users = User::all();
        $salary_payable = PaySalary::where('pay_salaries.id',$id)->select(['contracts.salary as luongCoBan'])
        ->leftJoin('contracts','contracts.id','=','pay_salaries.contract_id')->get();
        // return ($PaySalary);
        $Contract = Contract::where('user_id',$PaySalary->user_id)->first();
        // $salary = Salary::find(  $Contract->salary_id);
        $data = [
            'users'         => $users,
            'PaySalary'  => $PaySalary,
            'salary_payable'    =>$salary_payable,
        ];
        // dd($data);
        $this->title = 'Cập nhật';
        return $this->openView("modules.{$this->module}.update", $data);
    }

 
    public function update(Request $request)
    {
        // dd( (int)$request->id);
        $validator = Validator::make(
            $request->all(),
            [
                'working_day' => 'required',
                'salary' => 'required',
                'allowance' => 'required',
                // 'user_id' => 'required',
                'total' => 'required',
                'advance' => 'required',
                'actual_salary' => 'required',
                'status' => 'required',
            ],
            [
                'working_day.required' => 'Bạn chưa nhập số ngày công',
                'salary.required' => 'Bạn chưa nhập lương',
                'allowance.required' => 'Bạn chưa nhập trợ cấp',
                'user_id.required' => 'Bạn chưa chọn nhân viên',
                'total.required' =>'Bạn chưa có tổng lương',
                'advance.required' =>'Bạn chưa nhập ứng lương',
                'actual_salary.required' =>'Bạn chưa nhập lương thực tế',
                'status.required' =>'Bạn chưa chọn trạng thái',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }

        // $Contract = Contract::where('user_id',$request->user_id)->first();
        $update = PaySalary::find((int)$request->id);
        // dd($update);
        
        // $update-> salary_id = $Contract->salary_id;
        $update->working_day = $request->working_day;
        $update-> salary = $request->salary;
        $update-> allowance = $request->allowance;
        $update-> total = $request->total;
        $update-> advance = $request->advance;
        $update-> actual_salary = $request->actual_salary + $update->sum_bonus - $update->sum_discipline;
        $update->month  = Carbon::now()->format('Y-m-d H:i:s');
        $update-> status = $request->status;
        $update->save();

        // dd($update);
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

   

    public function exportPaySalary($id)
    {   
        return Excel::download(new SalaryUserExport($id), 'pay_salary.xlsx');
    }

    public function exportPaySalaryOfDepartment(Request $request)
    {   
        return Excel::download(new ExportSalaryOfDepartment($request->phong_ban, $request->thang), "bang_luong_theo_phong_ban.xlsx");
    }

    public function destroy(Request $request)
    {
        try {
            PaySalary::destroy($request->id);
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
    public function loadAjaxListPaySalaries(Request $request)
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
        $totalRecords  = PaySalary::whereHas('user.role', function ($query) {
            $query->where('name', '!=', 'Super Admin');
        })
        ->QueryData($filter)->distinct()->count();
        $totalRecordswithFilter =PaySalary::whereHas('user.role', function ($query) {
            $query->where('name', '!=', 'Super Admin');
        })
        ->QueryData($filter)->distinct()->count();
        $PaySalary = PaySalary::select(['pay_salaries.*','contracts.salary as luongCoBan'])
        ->with(['user'])
        ->whereHas('user.role', function ($query) {
            $query->where('name', '!=', 'Super Admin');
        })
        ->with(['user.role'])
        ->with(['user.department'])
        // ->with(['salarys'])
        ->leftJoin('contracts','contracts.id','=','pay_salaries.contract_id')
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)
        ->get();
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
    
}
