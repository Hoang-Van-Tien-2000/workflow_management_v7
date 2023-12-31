<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->module = 'department';
        $this->breadcrumb = [
            'object'    => 'Phòng ban',
            'page'      => ''
        ];
        $this->title = 'Phòng ban';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $checkRole = Auth::user()->hasRole('Super Admin');
      if($checkRole)
      {
            $departments = Department::all();
           
      }else{
            $departments = Department::where('user_id',Auth::user()->id)->get();
      }
      $user = User::where('username','!=','superadmin')->get();

      $this->breadcrumb['page'] = 'Danh sách';
      $data = [
          'departments' => $departments,
          'users' =>$user
      ];
        // dd($data);
        return $this->openView("modules.{$this->module}.list", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
                'name'      => 'required|unique:App\Models\Department,name,NULL,id,deleted_at,NULL',
            ],
            [
                'name.unique' => 'Tên phòng ban đã tồn tại',
                'name.required' => 'Tên phòng ban không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newDepartment = Department::create([
            'name' => $request->name,
            'user_id'=> $request->user_id
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
        ], 200);
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
    public function edit($id)
    {
        //
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
                'name'              => "required|unique:App\Models\Department,name,{$request->id},id,deleted_at,NULL",
            ],
            [
                'name.unique'               => 'Tên phòng ban đã tồn tại',
                'name.required'             => 'Tên phòng ban không được trống',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Department::destroy($request->id);
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
    public function loadAjaxListDepartment(Request $request)
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
              $departments = Department::where('id','>',0);
             
        }else{
              $departments = Department::where('user_id',Auth::user()->id);
        }

        // Total records
        $totalRecords  = Department::count();
        $totalRecordswithFilter = Department::queryData($filter)->distinct()->count();
        $department = Department::select(['departments.*'])
            ->with('user')  
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
// dd($department);
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $department,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}
