<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{
    use HasFactory;
    protected $table = "user_works";
    public function Work()
    {
        return $this->belongsTo(Work::class,'work_id','id');
    }
    public function listUser()
    {
        return $this->hasMany(User::class,'id', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
