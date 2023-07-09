<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Level extends Model
{
    use HasFactory,SoftDeletes;
    public function listTask()
    {
        return $this->hasMany(Task::class,'level_id','id')->orderBy('index');
    }
    public function listTaskTrash()
    {
        return $this->hasMany(Task::class,'level_id','id')->orderBy('index')->withTrashed();
    }
}
