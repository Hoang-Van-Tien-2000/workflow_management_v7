<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Jobs\SendEmailJob;


class CustomerController extends Controller
{
    public function __construct()
    {
        $this->module = 'customer';
        $this->breadcrumb = [
            'object'    => 'Khách hàng',
            'page'      => ''
        ];
        $this->title = 'Khách hàng';
    }

    public function index()
    {

        $this->breadcrumb['page'] = 'Danh sách khách hàng';
        $maKh = Customer::distinct()->get('code');
        $sdt = Customer::distinct()->get('phone');
        $email = Customer::distinct()->get('email');
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'maKh'          => $maKh,
            'sdt'           => $sdt,
            'email'         => $email,
            'title'         => $this->title,
        ];
        return view("modules.{$this->module}.list",$data);
    }
    public function create()
    {
        $this->breadcrumb['page'] = 'Thêm mới';
        $this->title = 'Thêm mới khách hàng';
        $count = Customer::all()->count()+1;
        $makh = "KH".$count;
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'makh'        => $makh, 
        ];
        return $this->openView("modules.{$this->module}.create", $data);
    }
    public function store(Request $request){
        Customer::create([
           'code'   =>  $request->code,
           'name'   =>  $request->name,
           'phone'  =>  $request->phone,
           'email'  =>  $request->email,
           'address' =>  $request->address,
           'status' => 'active'
        ]);
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

    public function destroy(Request $request)
    {
        try {
            Customer::destroy($request->id);
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

    public function edit($id)
    {
        $customer = Customer::find($id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $this->title = 'Cập nhật khách hàng';
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'customer'      => $customer,
        ];
        return $this->openView("modules.{$this->module}.update", $data);
    }
    
    public function update(Request $request)
    {
        $update = Customer::where('code',$request->code)
        ->update([
            'name' =>  $request->name,
            'phone' =>  $request->phone,
            'email' =>  $request->email,
            'address' =>  $request->address,
            'status' => 'active'
         ]);
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
    public function loadAjaxListCustomer(Request $request)
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
        // dd($filter);
        // Total records
        $totalRecords  = Customer::count(); //Phân trang
        $totalRecordswithFilter = Customer::select(['customers.*'])->QueryData($filter)->distinct()->count();
        $customers = Customer::select(['customers.*'])->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" =>  $totalRecordswithFilter,
            "aaData"               => $customers,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
    public function sendemail(Request $request){
        $customer = Customer::find($request->customerId); //Lấy email khách hàng
        $job = (new SendEmailJob($customer->email, $request->content, $request->title));
        $this->dispatch($job);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Gửi thành công',
            ],
            200
        );
    }
}
