<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discipline extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'salary_fine',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['user_id'])) {
            $arr_user = json_decode($req['user_id']);
            if (is_array($arr_user) && !empty($arr_user)) {
               $query->whereIn('user_id', $arr_user); 
            } 
        };
        return $query;
    }
}
