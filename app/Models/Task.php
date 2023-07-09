<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use DateTimeInterface;

class Task extends Model
{
    use HasFactory,SoftDeletes;
    // protected $casts = [
    //     'timeOut' => 'datetime:d/m/Y H:i:s',
    // ];

    public function detail()
    {
        return $this->belongsTo(TaskDetail::class,'id','task_id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class,'level_id','id');
    }
    public function assign()
    {
        return $this->hasMany(Assign::class,'task_id','id');
    }
    public function work()
    {
        return $this->hasOneThrough(Work::class, Level::class, 'id', 'id', 'level_id', 'work_id');
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y H:i:s');
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    public function attachment()
    {
        return $this->hasMany(TaskAttachment::class);
    }
}
