<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceAllowance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'advance',
        'allowance',
        'month'
    ];

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['user_id'])) {
            $arr_name = json_decode($req['user_id']);
            if (is_array($arr_name) && !empty($arr_name)) {
               $query->whereIn('user_id', $arr_name); 
            } 
        };

        return $query;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
