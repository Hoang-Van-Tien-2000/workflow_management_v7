<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discipline;
use Illuminate\Support\Facades\Validator;
use App\Models\PaySalary;
use Carbon\Carbon;
class DisciplineController extends Controller
{
    public function __construct()
    {
        $this->module = 'discipline';
        $this->breadcrumb = [
            'object'    => 'Xử phat',
            'page'      => ''
        ];
        $this->title = 'Xử phat';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'users' => $users
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
        $users = User::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $this->title = 'Thêm mới xử phạt';
        $data = [
            'users'         => $users,
            'module'        => $this->module,
            'breadcrumb'    => $this->breadcrumb,
            'title'         => $this->title
        ];
        return view("modules.{$this->module}.create", $data);
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
                'user_id'       => 'required',
                'salary_fine'   => 'required',
                'content'       => 'required',
            ],
            [
                'user_id.required'      => 'Chưa chọn nhân viên',
                'salary_fine.required'  => 'Tiền phạt không được trống',
                'content.required'      => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newDiscipline = Discipline::create([
            'user_id'       => $request->user_id,
            'salary_fine'   => $request->salary_fine,
            'content'       => $request->content
        ]);
        if($newDiscipline)
        {
            $monthNow = Carbon::now()->format('Y-m');
            $updatePaySalary = PaySalary::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->first();
            if($updatePaySalary!=null)
            {
                $sum_discipline = Discipline::where('user_id',$request->user_id)->where('created_at',"LIKE", "%$monthNow%")->sum('salary_fine');
                $updatePaySalary->sum_discipline = $sum_discipline;
                $updatePaySalary->save();
            }
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $users = User::all();
        $discipline = Discipline::find($request->id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $this->title = 'Cập nhật xử phạt';
        $data = [
            'users'         => $users,
            'discipline'    => $discipline
        ];
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
                'user_id'       => 'required',
                'salary_fine'   => 'required',
                'content'       => 'required',
            ],
            [
                'user_id.required'      => 'Chưa chọn nhân viên',
                'salary_fine.required'  => 'Tiền thưởng không được trống',
                'content.required'      => 'Lý do không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $discipline = Discipline::find($request->id);
        if (!empty($discipline)) {
            $discipline->user_id         = $request->user_id;
            $discipline->salary_fine     = $request->salary_fine;
            $discipline->content         = $request->content;
            $discipline->save();
            if($discipline)
            {
                $monthNow = Carbon::now()->format('Y-m');
                $monthDiscipline = Carbon::parse($discipline->created_at)->format('Y-m');
                if($monthNow != $monthDiscipline)
                {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Không thể cập nhật tiền phạt tháng trước',
                    ], 200);
                }
                $updatePaySalary = PaySalary::where('user_id',$request->user_id)->where('month',"LIKE", "%$monthNow%")->first();
                if($updatePaySalary!=null)
                {
                    $sum_discipline = Discipline::where('user_id',$request->user_id)->where('created_at',"LIKE", "%$monthNow%")->sum('salary_fine');
                    $updatePaySalary->sum_discipline = $sum_discipline;
                    $updatePaySalary->save();
                }
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
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thất bại',
            ], 200);
        }
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
            $discipline = Discipline::find($request->id);
            $monthNow = Carbon::now()->format('Y-m');
            $monthDiscipline = Carbon::parse($discipline->created_at)->format('Y-m');
            if($monthNow != $monthDiscipline)
            {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Không thể xóa tiền phạt tháng trước',
                ], 200);
            }
            Discipline::destroy($request->id);
            $updatePaySalary = PaySalary::where('user_id',$discipline->user_id)->where('month',"LIKE", "%$monthNow%")->first();
            if($updatePaySalary!=null)
            {
                $sum_discipline = Discipline::where('user_id',$discipline->user_id)->where('created_at',"LIKE", "%$monthNow%")->sum('salary_fine');
                $updatePaySalary->sum_discipline = $sum_discipline;
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
    public function loadAjaxListDiscipline(Request $request)
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
        $totalRecords  = Discipline::count();
        $totalRecordswithFilter = Discipline::queryData($filter)->distinct()->count();
        $discipline = Discipline::select(['disciplines.*'])
            ->with('user')
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $discipline,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}

