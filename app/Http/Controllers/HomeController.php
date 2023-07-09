<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AnnualLeave;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->module = 'dashboard';
        $this->breadcrumb = [
            'object'    => 'DashBoard',
            'page'      => ''
        ];
        $this->title = 'DashBoard';
    }
   
    public function index()
    {
        $this->breadcrumb['page'] = 'Home page';
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.list');
        }

        return back()->with([
            'error' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
        ]);
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

    public function loadAjaxListUser(Request $request)
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
        $totalRecords  = User::count();
        $totalRecordswithFilter = User::distinct()->count();
        $user = User::select(['users.*'])
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
            ->with(['role'])
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $user,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
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
        $totalRecords  = AnnualLeave::where('status',1)->count();
        $totalRecordswithFilter = AnnualLeave::where('status',1)->distinct()->count();
        $annual_leave = AnnualLeave::where('status',1)->select(['annual_leaves.*'])
            ->leftjoin('users', 'users.id', '=', 'annual_leaves.user_id')
            ->with(['user'])
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
}
