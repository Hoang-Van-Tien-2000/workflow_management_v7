<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    // use SoftDeletes;
    public function user_permision()
    {
        return $this->hasMany(User_permision::class,'permission_id','id');
    }
}
