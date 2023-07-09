<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\User;
use App\Models\Customer;
use App\Models\UserWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;

class ThongKecontroller extends Controller
{
    //Thống kê Cong viec
    public function __construct()
    {
        $this->title = 'Công việc';
    }
    public function indexCongViec()
    {
        $module = 'statistic.task';
        $breadcrumb['object'] = 'Thống kê công việc';
        $breadcrumb['page'] = 'Thống kê công việc';
        $code     = User::all();
        $name     = User::distinct()->get("fullname");
        $data       = [
                        'breadcrumb'    => $breadcrumb,
                        'module'        => $module,
                        'code'          => $code,
                        'name'          => $name,
                        'title'         => $this->title,
                    ];
        return view("modules.{$module}.list", $data);
    }
    
    public function detail(Request $request, $sdt)
    {
        $module = 'statistic.task';
        $user = User::where("phone",$sdt)->first();
        $breadcrumb['object'] = "";
        $breadcrumb['page'] = 'Công viêc: '.  $user->fullname;
        $this->title = 'Cập nhật công việc';
        $nameProject     = UserWork::where('user_id',$user->id)->get();
        $nameTask  = Assign::where("user_id",$user->id)->get();
        $data       = [
                        'breadcrumb'    => $breadcrumb,
                        'module'        => $module,
                        'sdt'        => $sdt,
                        'nameProject'     => $nameProject,
                        'nameTask'      => $nameTask,
                        'title'         =>$this->title,
                    ];
        return view("modules.{$module}.detail", $data);
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

    public function loadAjaxstatisticTask(Request $request)
    {
        $draw               = $request->get('draw');
        $start              = $request->get("start");
        $rowperpage         = $request->get("length"); // Rows display per page
        $columnIndex_arr    = $request->get('order');
        $columnName_arr     = $request->get('columns');
        $order_arr          = $request->get('order');
        $search_arr         = $request->get('search');
        $columnIndex        = $columnIndex_arr[0]['column']; // Column index
        $columnName         = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder    = $order_arr[0]['dir']; // asc or desc
        $searchValue        = trim($search_arr['value']); // Search value
        $filter['search']   = $searchValue;
        $filter             = $this->customFilterAjax($filter, $columnName_arr);
        $totalRecords       = User::all();
        $timeFormat1        = '';
        $timeFormat2        = '';
        $filterTime         = isset($filter['hoanthanh_count']) ? $filter['hoanthanh_count'] : '';
        if (empty($filterTime)) {
            $timeFormat2 = Carbon::now()->format('Y-m-d');
            $timeFormat1 = Carbon::now()->subMonth(3)->addDay()->format('Y-m-d');
            $filterTime = "{$timeFormat1}.{$timeFormat2}";
        } 
        
        $totalRecordswithFilter = 1;
            $UserOfTask = User::select(['users.*'])            
            ->QueryData($filter)  
            ->withCount(["hoanthanh" => function($query) use($filterTime) {
            $query->where('tasks.status',1)->where('complete_at','<',DB::raw('timeOut'))->orWhere([['timeOut',NULL],['tasks.status','=',1]]);
        }])
        ->withCount(["trehan" => function($query) use($filterTime){
            $now = Carbon::now()->toDateTimeString();
            $query->where('complete_at','>',DB::raw('timeOut'))->orWhere('timeOut','<',$now);
        }])
        ->withCount(["danglam" => function($query) use($filterTime){
            $now = Carbon::now()->toDateTimeString();
            $query->where('tasks.status','=',0)->where([['complete_at','<',DB::raw('timeOut')],['timeOut','>',$now]])->orWhere([['timeOut',NULL],['tasks.status','=',0]]);
        }])->get();
        $response = [
            "draw"                  => intval($draw),
            "iTotalRecords"         => $totalRecords,
            "iTotalDisplayRecords"  => $totalRecordswithFilter,
            "aaData"                => $UserOfTask,
            "filter"                => $filter,
        ];
        return response()->json($response);
        }

        public function loadAjaxDetailstatisticTask(Request $request)
    {
        $draw               = $request->get('draw');
        $start              = $request->get("start");
        $rowperpage         = $request->get("length"); // Rows display per page
        $columnIndex_arr    = $request->get('order');
        $columnName_arr     = $request->get('columns');
        $order_arr          = $request->get('order');
        $search_arr         = $request->get('search');
        $columnIndex        = $columnIndex_arr[0]['column']; // Column index
        $columnName         = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder    = $order_arr[0]['dir']; // asc or desc
        $searchValue        = trim($search_arr['value']); // Search value
        $filter['search']   = $searchValue;
        $filter             = $this->customFilterAjax($filter, $columnName_arr);
        $totalRecords       = User::all();
        $timeFormat1        = '';
        $timeFormat2        = '';
        $filterTime         = isset($filter['hoanthanh_count']) ? $filter['hoanthanh_count'] : '';
        if (empty($filterTime)) {
            $timeFormat2 = Carbon::now()->format('Y-m-d');
            $timeFormat1 = Carbon::now()->subMonth(3)->addDay()->format('Y-m-d');
            $filterTime = "{$timeFormat1}.{$timeFormat2}";
        } 
        $arr = [];
        if (!empty($filter['task.title'])) {
            $arr['task'] = json_decode($filter['task.title']);   
        };
        if (!empty($filter['task.work.name'])) {
            $arr['work'] = json_decode($filter['task.work.name']);
        };
        $totalRecordswithFilter = 1;
        $user = User::where("phone", $request->sdt)->first();
        $task = Assign::where("user_id",$user->id)->with(["task" =>function($query) use($arr){
            if(!empty($arr['task'])){
                $query->whereIn('title',$arr['task']);
            }
            $query->with(["work" => function($query1) use($arr){
                if(!empty($arr['work'])){
                    $query1->whereIn('works.name',$arr['work']);
                }
            }]);
            
        }])
        ->whereHas("task" , function($query) use($arr){
            if(!empty($arr['task'])){
                $query->whereIn('title',$arr['task']);
            }
            $query->whereHas("work" , function($query1) use($arr){
                if(!empty($arr['work'])){
                    $query1->whereIn('works.name',$arr['work']);
                }
            });
            
        })->get();
        // dd($task);
        // $UserOfTask = User::with("listTask")->first();   
        $response = [
            "draw"                  => intval($draw),
            "iTotalRecords"         => $totalRecords,
            "iTotalDisplayRecords"  => $totalRecordswithFilter,
            "aaData"                => $task,
            "filter"                => $filter,
        ];
        return response()->json($response);
        }
        //Thống kê Khách hàng
        public function indexKhachHang()
        {
            $module = 'statistic.customer';
            $breadcrumb['object'] = 'Thống kê khách hàng';
            $this->title = 'Thống kê khách hàng';
            $breadcrumb['page'] = 'Danh sách';
            $now        = Carbon::now()->format('m/d/Y');
            $before     = Carbon::now()->subMonth(3)->addDay()->format('m/d/Y');
            $value      = $before . ' - ' . $now;
            $data       = [
                            'breadcrumb'    => $breadcrumb,
                            'module'        => $module,
                            'value'         => $value,
                            'title'         => $this->title,
                        ];
            return view("modules.{$module}.list", $data);
        }

        public function loadAjaxstatisticCustomer(Request $request){
            $time   = explode(' - ', $request->time); // chia ra 2 mãng
            $start      = (new DateTime(Carbon::parse($time[0])->format('Y-m-d')))->modify('first day of this month');
            $end        = (new DateTime(Carbon::parse($time[1])->format('Y-m-d')))->modify('first day of next month');
            $interval   = DateInterval::createFromDateString('1 month');
            $period     = new DatePeriod($start, $interval, $end);
            foreach ($period as $key => $value) {
                $date[] = $value->format('Y-m-d');
            }
            foreach ($period as $key => $value) {
                $dateList[] = $value->format('m/Y'); //Định dạng tháng năm
            }
            
            $customer = [];
            for ($i = 0; $i < count($date); $i++) {
                if ($i < count($date) - 1) {
                    $customer[$i] = Customer::whereDate('created_at','>=',$date[$i])
                                                    ->whereDate('created_at','<=',$date[$i + 1])->count();
                    } else {
                    $customer[$i] = Customer::whereDate('created_at','>=',$date[$i])
                                                                ->whereDate('created_at','<=',Carbon::parse($time[1])->format('Y-m-d'))->count();
                                                            }
                                                        }
            return response()->json([
                'status'    => 'success',
                'customer'   => $customer,
                'datelist'      => $dateList,
            ]);
        }
}
