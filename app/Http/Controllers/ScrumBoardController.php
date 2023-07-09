<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Assign;
use App\Models\Comment;
use App\Models\CommentImage;
use App\Models\Level;
use App\Models\Priority;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TaskDetail;
use App\Models\User;
use App\Models\UserWork;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScrumBoardController extends Controller
{
    public function __construct()
    {
        $this->module = 'scrumboard';
        $this->breadcrumb = [
            'object'    => 'ScrumBoard',
            'page'      => '',
        ];
        $this->title = 'ScrumBoard';
    }

    public function list(Request $request, $id) {
        $this->breadcrumb['page'] = 'Danh sách';
        $scrum  = Level::where("work_id", $id)->get();
        $data   = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'scrum'         => $scrum,
            'id'            => $id,
        ];
        return $this->openView("modules.{$this->module}.list", $data);
    }
    public function trash($id)
    {
        $this->breadcrumb['page'] = 'Thùng rác';
        $data   = [
            'breadcrumb'    => $this->breadcrumb,
            'module'        => $this->module,
            'id'            => $id,
        ];
        return $this->openView("modules.{$this->module}.trash", $data);
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
    public function loadAjaxListTaskTrash(Request $request)
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
        if (!empty($filter['status'])) {
            $arr = json_decode($filter['status']);
        };
        $taskDelete = [];
        $scrum  = Level::withTrashed()->where("work_id", $request->id)->get();
        $i=0;
        foreach($scrum as $key => $value){
            foreach($value->listTaskTrash as $item){
                if(!empty($item->deleted_at)){
                    $taskDelete[$i++] = $item;
                }
            }
        }
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => 0,
            "iTotalDisplayRecords" => 0,
            "aaData"               => $taskDelete,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
    public function store(Request $request)
    {
        $TaskLevel      = Task::where("level_id", $request->level_id)->count();
        $Task           = new Task();
        $Task->level_id = $request->level_id;
        $Task->priority_id = 0;
        $Task->user_id  = Auth::user()->id;
        $Task->title    = $request->title;
        $Task->content  = $request->content;
        $Task->index    = $TaskLevel;
        $Task->timeStart  = Carbon::now();
        $Task->timeOut  = null;
        $Task->type     = "new";
        $Task->status   = 0;
        $Task->save();

        $taskDetail             = new TaskDetail();
        $taskDetail->description = $request->content;
        $taskDetail->task_id    = $Task->id;
        $taskDetail->status     = '1';
        $taskDetail->save();

        $levelMessage = Level::find($request->level_id);
        $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->task_id = $Task->id;
            $message = Auth::user()->fullname." đã tạo công việc ". $Task->title. " trong danh sách " . $levelMessage->name;
            $comment->content = $message;
            $comment->status  = 2;
            $comment->save();
        $level = Level::where("work_id",$levelMessage->work_id)->withCount("listTask")->get();
        $levelcomplete = Level::where("work_id",$levelMessage->work_id)
                                    ->withCount(["listTask" =>function ($query){
                                        $query->where('tasks.status',1);
                                    }])->get();
        $total = 0;
        $totalComplete = 0;
        foreach($level as $task){
            $total += $task->list_task_count;
        }
        foreach($levelcomplete as $task){
            $totalComplete += $task->list_task_count;
        }
        $status =(int)($totalComplete/$total*100);
        $work = Work::find($levelMessage->work_id);
        $work->progress = $status;
        if($status == 100){
            $work->status    = "Done";
        }else{
            $work->status    = "Doing";
        }
        $work->save();

        if ($Task) {
            return response()->json(
                [
                    'status'    => 'success',
                    'message'   => 'Thêm công việc thành công',
                    'task_id'   => $Task->id,
                    'task'   => $Task,
                ], );
        }
        return response()->json(
            [
                'status'    => 'error',
                'message'   => 'Đã xảy ra lỗi',
            ], );
    }
public function restore(Request $request)
{
    try {
        $task1 = Task::withTrashed()->find($request->id)->restore();
        $task = Task::find($request->id);
        $level = Level::withTrashed()->find($task->level_id)->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã khôi phục',
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy yêu cầu',
        ], 200);
    }
}
public function restores(Request $request)
{
    // dd($request->all());
    try {
        $task1 = Task::withTrashed()->whereIn('id',$request->id)->restore();
        $task = Task::whereIn('id',$request->id)->get();
        foreach($task as $value){
            $level = Level::withTrashed()->find($value->level_id)->restore();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Đã khôi phục',
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy yêu cầu',
        ], 200);
    }
}
    public function forceDelete(Request $request)
    {
        try {
            $task1 = Task::withTrashed()->where('id',$request->id)->first()->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy yêu cầu',
            ], 200);
        }
    }
    public function store_list(Request $request)
    {
        $checkindex     = Level::where('work_id', $request->work_id)->count();
        $level          = new Level();
        $level->work_id = $request->work_id;
        $level->name    = $request->listTitle;
        $level->index   = isset($checkindex) ? $checkindex + 1 : 0;
        $level->status  = 1;
        $level->save();
        if ($level) {
            return response()->json(
                [
                    'status'    => 'success',
                    'message'   => 'Thêm danh sách thành công',
                    'level_id'  => $level->id,
                ], );
        }
        return response()->json(
            [
                'status'    => 'error',
                'message'   => 'Đã xảy ra lỗi',
            ], );
    }

    public function edit_list(Request $request)
    {
        $level       = Level::find($request->level_id);
        $level->name = $request->name;
        $level->save();
        if ($level) {
            return response()->json(
                [
                    'status'    => 'success',
                    'message'   => 'Chỉnh sửa danh sách thành công',
                ], );
        }
        return response()->json(
            [
                'status'    => 'error',
                'message'   => 'Đã xảy ra lỗi',
            ], );
    }

    public function clear_all(Request $request)
    {
        $removeAssign = Task::where("level_id", $request->level_id)->get();
        foreach($removeAssign as $assign){
            $assign = Assign::where("task_id",$assign->id)->delete();
        }
        $task = Task::where("level_id", $request->level_id)->delete();
        $checklevel = Level::find($request->level_id);
        $level = Level::where("work_id",$checklevel->work_id)->withCount("listTask")->get();
        $levelcomplete = Level::where("work_id",$checklevel->work_id)
                                    ->withCount(["listTask" =>function ($query){
                                        $query->where('tasks.status',1);
                                    }])->get();
        $total = 0;
        $totalComplete = 0;
        foreach($level as $task){
            $total += $task->list_task_count;
        }
        foreach($levelcomplete as $task){
            $totalComplete += $task->list_task_count;
        }
        if($total==0){
            $status = 0;
        }else{
            $status =(int)($totalComplete/$total*100);
        }
        $work = Work::find($checklevel->work_id);
        $work->progress = $status;
        if($status == 100){
            $work->status    = "Done";
        }else{
            $work->status    = "Doing";
        }
        $work->save();
        if ($task) {
            return response()->json(
                [
                    'status'    => 'success',
                    'message'   => 'Xóa thành công',
                ], );
        }
        return response()->json(
            [
                'status'    => 'error',
                'message'   => 'Đã xảy ra lỗi',
            ], );
    }

    public function move(Request $request)
    {
        $reload  = Task::where('level_id', $request->level_old)->where('id',$request->task_id)->first();        
        if(empty($reload) || $reload->index != $request->index_old)
        {
            return response()->json(
                [
                    'status'    => 'error',
                    'message'   => 'Đã sảy ra lỗi',
                ], );
        }
        if ($request->level_new != $request->level_old) {
            $stopTask   = Task::where('level_id', $request->level_new)
                                ->where('index', '>=', $request->index_value)->orderBy("index","asc")->get();
            $index      = $request->index_value;
            foreach ($stopTask as $value) {
                $index++;
                $update         = Task::find($value->id);
                $update->index  = $index;
                $update->save();
            }
            // dd($request->index_value);
            $Task           = Task::find($request->task_id);
            $Task->level_id = $request->level_new;
            $Task->user_id  = Auth::user()->id;
            $Task->index    = $request->index_value;
            $Task->save();

            $updateTask = Task::where('level_id', $request->level_old)
                                ->where('index', '>', $request->index_old)->orderBy("index","asc")->get();
            $index2 = $request->index_old - 1;
            foreach ($updateTask as $value) {
                $index2++;
                $update         = Task::find($value->id);
                $update->index  = $index2;
                $update->save();
            }
            $levelMessage       = Level::find($request->level_new);
            $comment            = new Comment();
            $comment->user_id   = Auth::user()->id;
            $comment->task_id   = $request->task_id;
            $message            = Auth::user()->fullname." đã di chuyển công việc ". $Task->title. " đến danh sách " . $levelMessage->name;
            $comment->content   = $message;
            $comment->status    = 2;
            $comment->save();
            $mail = Auth::user()->fullname." đã di chuyển công việc ". $Task->title. " của bạn đến danh sách " . $levelMessage->name;
            $mail1 = "Bạn đã di chuyển công việc ". $Task->title. " đến danh sách " . $levelMessage->name;
            foreach ($Task->assign as $value) {
                $user = User::find($value->user_id);
                if($value->user_id != Auth::user()->id){
                    $job = (new SendEmailJob($user->email, $mail, "Công việc của bạn"));
                    $this->dispatch($job);
                }else{
                    $job = (new SendEmailJob($user->email, $mail1, "Công việc của bạn"));
                    $this->dispatch($job);
                }
            }
            
            if ($Task) {
                return response()->json(
                    [
                        'status'    => 'success',
                        'message'   => 'Đã thay đổi',
                    ], );
            }
        } else {
            if($request->index_old < $request->index_value){
                $tasks = Task::where('level_id', $request->level_new)
                                ->where('index', '>', $request->index_old)->where('index','<=',$request->index_value)->orderBy("index","asc")->get();
                foreach($tasks as $task){
                    $task->index = $task->index - 1;
                    $task->save();
                }
                $Task = Task::find($request->task_id);
                $Task->index = $request->index_value;
                $Task->save(); 
            }else{
                $tasks = Task::where('level_id', $request->level_new)
                                ->where('index', '>=', $request->index_value)->where('index','<',$request->index_old)->orderBy("index","asc")->get();
                foreach($tasks as $task){
                    $task->index = $task->index + 1;
                    $task->save();
                }
                $Task = Task::find($request->task_id);
                $Task->index = $request->index_value;
                $Task->save(); 
            }
            if ($Task) {
                return response()->json(
                    [
                        'status'    => 'success',
                        'message'   => 'Đã thay đổi',
                    ], );
            }
        }
        return response()->json(
            [
                'status'    => 'error',
                'message'   => 'Đã sảy ra lỗi',
            ], );
    }

    public function destroy(Request $request)
    {
        try {
            $task       = Task::find($request->id);
            $checklevel = Level::find($task->level_id);
            $updateTask = Task::where('level_id', $task->level_id)
                                ->where('index', '>', $task->index)->get();
            $index2     = $task->index-1;
            $assign = Assign::where("task_id",$request->id)->delete();
            foreach ($updateTask as $value) {
                $index2++;
                $update         = Task::find($value->id);
                $update->index  = $index2;
                $update->save();
            }
            Task::destroy($request->id);
            $assign         = Assign::where('task_id',$request->id)->delete();
            $level          = Level::where("work_id",$checklevel->work_id)->withCount("listTask")->get();
            $levelcomplete  = Level::where("work_id",$checklevel->work_id)
                                        ->withCount(["listTask" =>function ($query){
                                            $query->where('tasks.status',1);
                                        }])->get();
            $total          = 0;
            $totalComplete  = 0;
            foreach($level as $task){
                $total += $task->list_task_count;
            }
            foreach($levelcomplete as $task){
                $totalComplete += $task->list_task_count;
            }
            if($total==0){
                $status = 0;
            }else{
                $status =(int)($totalComplete/$total*100);
            }            
            $work = Work::find($checklevel->work_id);
            $work->progress = $status;
            if($status == 100){
                $work->status    = "Done";
            }else{
                $work->status    = "Doing";
            }
            $work->save();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Xóa công việc thành công',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Đã xảy ra lỗi',
            ]);
        }
    }

    public function destroy_list(Request $request)
    {
        try {
            $removeAssign   = Task::where("level_id", $request->level_id)->get();
            $checklevel     = Level::find($request->level_id);
            $task           = Task::where("level_id", $request->level_id)->delete();
            $level          = Level::destroy($request->level_id);
            foreach($removeAssign as $assign){
                $assign     = Assign::where("task_id",$assign->id)->delete();
            }
            $level          = Level::where("work_id",$checklevel->work_id)->withCount("listTask")->get();
            $levelcomplete  = Level::where("work_id",$checklevel->work_id)
                                        ->withCount(["listTask" =>function ($query){
                                            $query->where('tasks.status',1);
                                        }])->get();
            $total = 0;
            $totalComplete = 0;
            foreach($level as $task){
                $total += $task->list_task_count;
            }
            foreach($levelcomplete as $task){
                $totalComplete += $task->list_task_count;
            }
            if($total == 0){
                $status = 0;
            }else{
                $status =(int)($totalComplete/$total*100);
            }
            $work = Work::find($checklevel->work_id);
            $work->progress = $status;
            if($status == 100){
                $work->status    = "Done";
            }else{
                $work->status    = "Doing";
            }
            $work->save();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Xóa danh sách thành công',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Đã xảy ra lỗi',
            ]);
        }
    }

    public function detailTask(Request $request)
    {
        $task_id = $request->task_id;
        $work_id = $request->work_id;
        $task    = Task::where('id',$task_id)
                        ->with(['detail'])
                        ->with('level')
                        ->with('priority')
                        ->with(['attachment' =>function($query){
                            $query->orderBy('created_at','desc');
                        }])
                        ->with(['assign'=> function($query){
                            $query->with('user');
                            }])
                        ->first();
        $comment    = Comment::where('task_id', $task_id)
                            ->with('user')
                            ->with('file')
                            ->orderBy('created_at','desc')->get();
        $Priority   = Priority::all();
        $assign     = Assign::where('task_id',$task_id)->get();
        $userInTask = [];
        $i = 0;
        foreach($assign as $user){
            $userInTask[$i] = $user->user_id;
            $i++;
        }
        $userWork = UserWork::where('work_id',$work_id)
                                ->whereNotIn('user_id', $userInTask)->with('user')->get();
            return response()->json([
            'status'    => 'success',
            'message'   => 'Chi tiết công việc',
            'task'      => $task,
            'comment'   => $comment,
            'userWork'  => $userWork,
            'Priority'  => $Priority
        ]);
    }

    public function updateDeriptionTask(Request $request)
    {
        $taskDetail= TaskDetail::where('task_id',$request->task_id)->first();
        $taskDetail->description= $request->description;
        $taskDetail->save();
        $comment            = new Comment();
        $comment->user_id   = Auth::user()->id;
        $comment->task_id   = $request->task_id;
        $message            = Auth::user()->fullname." đã cập nhật chi tiết". $request->description;
        $comment->content   = $message;
        $comment->status    = 2;
        $comment->save();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Thay đổi thành công',
        ]);
    }

    public function updateNameTask(Request $request)
    {
        $checkTask      = Task::find($request->task_id);
        $task           = Task::find($request->task_id);
        $task->title    = $request->name;
        $task->save();
        $comment        = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->task_id = $task->id;
        $message          = Auth::user()->fullname." đã thay đổi tên công việc ". $checkTask->title. " thành " . $task->title;
        $comment->content = $message;
        $comment->status  = 2;
        $comment->save();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Thay đổi thành công',
            'task'      => $task,
        ]);    
    }
    public function comment(Request $request)
    {
        $comment            = new Comment();
        $comment->user_id   = Auth::user()->id;
        $comment->task_id   = $request->task_id;
        $comment->content   = $request->messages_input;
        $comment->status    = 1;
        $comment->save();
        $commentUser = Comment::where('id',$comment->id)->with('user')->first();
        return response()->json([
            'status'    => 'success',
            'message'   => 'success',
            'comment'   => $commentUser,
        ]);  
    }

    public function deleteComment(Request $request)
    {
        Comment::destroy($request->id);
        return response()->json([
            'status'    => 'success',
            'message'   => 'Xóa bình luận thành công',
        ]);  
    }

    public function editComment(Request $request)
    {
        $comment            = Comment::find($request->comment_id);
        $comment->content   = $request->content;
        $comment->save();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Thay đổi thành công',
        ]);  
    }

    public function assign(Request $request)
    {
        $user = explode(',', $request->user);
        $users = [];
        $comments = [];
        $i=0;
        foreach($user as $value){
            $user               = User::find($value);
            $task               = Task::find($request->task_id);
            $checkAssign        = Assign::where('task_id',$request->task_id)
                                            ->where('user_id',$value)->first();
            $assign             = new Assign();
            if(empty($checkAssign)){
                $assign->user_id    = $value;
                $assign->task_id    = $request->task_id;
                $assign->status     = 1;
                $assign->save();
            }
            $comment            = new Comment();
            $comment->user_id   = Auth::user()->id;
            $comment->task_id   = $request->task_id;
            $message            = Auth::user()->fullname." đã thêm {$user->fullname} vào task {$task->title} ";
            $comment->content   = $message;
            $comment->status    = 2;
            $comment->save();
            $users[$i]['user'] = $user;
            $users[$i]['assign'] = $assign;
            $comments[$i] = $comment;
            $i++;
        }
            $assign     = Assign::where('task_id',$request->task_id)->get();
            $userInTask = [];
            $i = 0;
            foreach($assign as $user){
                $userInTask[$i] = $user->user_id;
                $i++;
            }
            $userWork = UserWork::where('work_id',$request->work_id)
                                ->whereNotIn('user_id', $userInTask)->with('user')->get();        
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
            'users' => $users,
            'comments'  => $comments,
            'userWork'  => $userWork,

        ]); 
    }
    public function changePriority(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->priority_id = $request->priority;
        $task->save();
        $Priority = Priority::find($request->priority);
        $allPriority = Priority::all();
        $color = "";
        if(!empty($Priority)){
            $color = $Priority->code;
        }else{
            $color = 0;
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thay đổi thành công',
            'color'   => $color,
            'id'      => $request->priority,
            'allPriority'   => $allPriority
        ]); 
    }
    public function uploadFile(Request $request)
    {
        $arr_task_attra = [];
        $arr_comment    = [];
        $arr_commentAttra   = [];

        $i = 0;
        foreach($request->upload as $image){
            $folder     = public_path('/assets/images/task');
            $time       = time() . rand(1, 200);
            $nameImage  = "{$time}{$image->getClientOriginalName()}";
            $image->move($folder,$nameImage );
            $extension = $image->getClientOriginalExtension();
            $task_attra = new TaskAttachment();
            $task_attra->task_id = $request->task_id;
            $task_attra->user_id = Auth::user()->id;
            $task_attra->url = $nameImage;
            $type = "";
            if($extension == "jpg" || $extension == "JPG" || $extension == "jpeg" || $extension == "JPEG" || $extension == "png" || $extension == "PNG")
                $type = "image";
            else{
                $type = "file";
            }
            $task_attra->type = $type;
            $task_attra->name = $image->getClientOriginalName();
            $task_attra->status = 1;
            $task_attra->save();
            $Task = Task::find($request->task_id);
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->task_id = $request->task_id;
            $message = Auth::user()->fullname." đã thêm tệp ".$image->getClientOriginalName()." trong ". $Task->title;
            $comment->content = $message;
            $comment->status  = 2;
            $comment->save();
            $commentAttra = new CommentImage();
            $commentAttra->comment_id = $comment->id;
            $commentAttra->url = $nameImage;
            $commentAttra->type = $type;
            $commentAttra->name = $image->getClientOriginalName();
            $commentAttra->status = 1;
            $commentAttra->save();
            $arr_task_attra[$i] = $task_attra;
            $arr_comment[$i]["comment"]    = $comment;
            $arr_comment[$i]["attra"]  = $commentAttra;
    
            $i++;
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
            'arr_task_attra'      => $arr_task_attra,
            'arr_comment'      => $arr_comment,
        ]);
    }
    public function deleteFile(Request $request)
    {
        $check_imgae = TaskAttachment::find($request->id);
        $task_attra = TaskAttachment::where("id",$request->id)->delete();
        
        $CommentImage = CommentImage::where("url",$check_imgae->url)->first();
        $comment = Comment::where("id",$CommentImage->comment_id)->delete();
        $CommentImage->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Xóa tệp thành công',
            'id'        =>$CommentImage->comment_id
        ]);
    }
    public function saveDeadline(Request $request)
    {
        $task = Task::find($request->task_id);
        $timeStart = Carbon::create($request->timeStart)->toDateTimeString();
        $timeOut = Carbon::create($request->timeOut)->toDateTimeString();
        // dd($timeOut);
        $task->timeStart =  $timeStart; 
        $task->timeOut = $timeOut;
        // dd($task->timeOut);
        $task->save();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Cập nhật thành công',
        ]);
    }
    public function changeStatusTask(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->status = !$task->status;
        $task->complete_at = Carbon::now();
        $task->save();
        $checklevel = Level::find($task->level_id);
        $level = Level::where("work_id",$checklevel->work_id)->withCount("listTask")->get();
        $levelcomplete = Level::where("work_id",$checklevel->work_id)
                                    ->withCount(["listTask" =>function ($query){
                                        $query->where('tasks.status',1);
                                    }])->get();
        $total = 0;
        $totalComplete = 0;
        foreach($level as $task){
            $total += $task->list_task_count;
        }
        foreach($levelcomplete as $task){
            $totalComplete += $task->list_task_count;
        }
        $status =(int)($totalComplete/$total*100);
        $work = Work::find($checklevel->work_id);
        $work->progress = $status;
        if($status == 100){
            $work->status    = "Done";
        }else{
            $work->status    = "Doing";
        }
        $work->save();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Cập nhật hoàn thành thành công',
        ]);
    }
    public function deleteAssign(Request $request)
    {
        $remove = Assign::where('user_id',$request->user_id)
                            ->where('task_id',$request->task_id)->first();
        Assign::where('user_id',$request->user_id)
                            ->where('task_id',$request->task_id)->delete();
        $user = User::find($request->user_id);
        $task = Task::find($request->task_id);
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->task_id = $request->task_id;
        $message = Auth::user()->fullname." xóa ". $user->fullname. " tham gia trong công việc " . $task->title;
        $comment->content = $message;
        $comment->status  = 2;
        $comment->save();
        $assign     = Assign::where('task_id',$request->task_id)->get();
            $userInTask = [];
            $i = 0;
            foreach($assign as $user){
                $userInTask[$i] = $user->user_id;
                $i++;
            }
            $userWork = UserWork::where('work_id',$request->work_id)
                                ->whereNotIn('user_id', $userInTask)->with('user')->get(); 
        return response()->json([
            'status'    => 'success',
            'message'   => 'Xoá thành viên tham gia thành công',
            'assign'    => $remove,
            'comment'   =>  $comment,
            'userWork'  => $userWork

        ]);
    }
}
