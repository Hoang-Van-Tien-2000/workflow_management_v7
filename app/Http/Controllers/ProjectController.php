<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\UserWork;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->module = 'project';
        $this->breadcrumb = [
            'object' => 'Nội dung',
            'page' => '',
        ];
        $this->title = 'Dự án';
    }

    public function index()
    {
        $this->breadcrumb['page'] = 'Danh sách';
        $projectAll = User::find(Auth::user()->id);
        $data = [
            'title'         => $this->title,
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'projectAll'    => $projectAll,
        ];
        return view("modules.{$this->module}.list", $data);
    }

    public function create()
    {
        $this->breadcrumb['page'] = 'Thêm mới';
        $this->title = 'Thêm mới dự án';
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'title'         => $this->title,
        ];
        return view("modules.{$this->module}.create", $data);
    }

    public function store(Request $request)
    {
        $project            = new Work();
        $project->user_id   = Auth::user()->id;
        $project->name      = $request->name;
        $project->status    = "Doing";
        $project->type      = '';
        $project->progress  = 0;
        $project->priority  = $request->priority;
        $project->size      = $request->size;
        $project->starting  = $request->startdate;
        $project->ending    = $request->enddate;
        $project->rate      = '';
        $project->detail    = $request->detail;
        $project->save();
        $userWork           = new UserWork();
        $userWork->user_id  = Auth::user()->id;
        $userWork->work_id  = $project->id;
        $userWork->status   ="1";
        $userWork->save();

        if (!empty($project)) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Thêm thành công',
                'redirect'  => route('project.list'),
            ]);
        }
        return response()->json([
            'status'    => 'error',
            'message'   => 'Thêm không thành công',
        ]);
    }

    public function update(Request $request)
    {    
        $project            = Work::find($request->id);
        $project->user_id   = Auth::user()->id;
        $project->name      = $request->name;
        $project->type      = '';
        $project->priority  = $request->priority;
        $project->size      = $request->size;
        $project->starting  = $request->startdate;
        $project->ending    = $request->enddate;
        $project->rate      = '';
        $project->detail    = $request->detail;
        $project->save();
        if (!empty($project)) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Cập nhật thành công',
                'redirect'  => route('project.list'),
            ]);
        }
        return response()->json([
            'status'    => 'error',
            'message'   => 'Cập nhật không thành công',
        ]);    
    }

    public function edit($id){
        $work = Work::find($id);
        $this->breadcrumb['page'] = 'Chỉnh sửa';
        $this->title = "Chỉnh sửa dự án";
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'title'         => $this->title,
            'module'        => $this->module,
            'work'          => $work
        ];
        return view("modules.{$this->module}.edit", $data);
    }

    public function setting($id)
    {
        $this->breadcrumb['page'] = 'Cài đặt';
        $this->title = 'Cài đặt dự án';
        $work = Work::find($id);
        $data = [
            'breadcrumb'    => $this->breadcrumb,
            'title'         => $this->title,
            'module'        => $this->module,
            'work_id'       => $id,
            'work'          => $work
        ];
        return view("modules.{$this->module}.setting", $data);
    }

    public function loadAjaxUser(Request $request)
    {
        $userWork = UserWork::where('work_id',$request->work_id)->get('user_id');
        $dataUser=[];
        foreach($userWork as $value){
            $dataUser[]=$value->user_id;
        }
        $userInWork = User::whereNotIn('id',$dataUser)->get();
        $data = [];
        $i = 0;
        foreach($userInWork as $user){
            $data[$i] = "{$user->fullname} ({$user->code})";
            $i++;
        }
        return response()->json([
            'status'    => 'success',
            'data'      => $data,
        ]);
    }

    public function assign(Request $request)
    {
        $thanhCong = [];
        $userCode = explode(",",$request->value);
        $thanhCong_i=0;
        foreach($userCode as $value){
            $codeText = explode("(",$value);
            $code = substr($codeText[1],0, -1);
            $user = User::where('code', $code)->first();
            if(!empty($user)){
                $checkWork = UserWork::where('user_id',$user->id)
                                        ->where('work_id',$request->work_id)
                                        ->first();
                if(empty($checkWork)){
                    $userWork = new UserWork();
                    $userWork->user_id = $user->id;
                    $userWork->work_id = $request->work_id;
                    $userWork->status = 1;
                    $userWork->save(); 
                    $thanhCong[$thanhCong_i]=$value;
                    $thanhCong_i++;
                }
            }
        }
        $message_thanhcong = json_encode($thanhCong).' Thêm thành công.';
        if ($thanhCong_i) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Thên thành viên thành công' ,
                'redirect'  => route('project.list'),
            ]);
        }
        return response()->json([
            'status'    => 'warring',
            'message'   => 'Không có tài khoản nào được thêm' ,
        ]);

    }

    public function removeUser(Request $request)
    {
        $userWork = UserWork::where('user_id',$request->user_id)
                                ->where('work_id',$request->work_id)->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Xoá tài khoản trong dự án thành công',
        ]);
    }

    public function userInWork(Request $request)
    {
        $work = Work::find($request->work_id);
        $userWork = UserWork::where('user_id','!=', $work->user_id)
                                ->where('work_id',$request->work_id)->get();
        $data = [];
        $i = 0;
        foreach($userWork as $users){
            $user = User::find($users->user_id);
            $data[$i] = $user;
            $i++; 
        }
        return response()->json([
            'status'    => 'success',
            'data'      => $data ,
        ]);

    }

    public function outProject(Request $request)
    {
        $userWork = UserWork::where('user_id', Auth::user()->id)
                                ->where('work_id',$request->work_id)
                                ->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Rời dự án thành công',
            'redirect'  => route('project.list'),

        ]);
    }

    public function deleteProject(Request $request)
    {
        $userWork = UserWork::where('work_id', $request->work_id)->delete();
        $work = Work::destroy($request->work_id);
        return response()->json([
            'status'    => 'success',
            'message'   => 'Xóa dự án thành công',
            'redirect'  => route('project.list'),
        ]);
    }

    public function autoComplete(Request $request)
    {
        $datas      = array();
        $listInfo   = explode(" ", $request->terms);
        $project_name = Work::select('name')
            ->Where(function ($query) use ($listInfo) {
                                        foreach ($listInfo as $Info) {
                                            $query->orwhere('name', 'like', '%' . $Info . '%');
                                        }
                                    })->get();
        if (!empty($project_name)) {
            foreach ($project_name as $project) {
                $datas[] = $project->name;
            }
        }
        return response()->json($datas);
    }

    public function search(Request $request)
    {
        $searchterm = $request->search;
        $data = [];
        if (!empty($searchterm)) {
            $messages = (new Search())
                ->registerModel(Work::class, function (ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                        ->where('user_id',Auth::user()->id)
                        ->addSearchableAttribute('name');
                })
                ->perform($searchterm);
            foreach ($messages as $message) {
                $data[] = $message->searchable;
            }
            $work = [];
            foreach($data as $value){
                $work[] = Work::where("id",$value->id)->with("User")->withCount("level")->withCount("dsUser")->with("dsUser")->first();
            }
        } else {
            $user = UserWork::where("user_id",Auth::user()->id)->get();
            $work = [];
            foreach($user as $value){
                $work[] = Work::where("id",$value->work_id)->with("User")->withCount("level")->withCount("dsUser")->with("dsUser")->first();
            }
        }
        return response()->json($work);
    }
}
