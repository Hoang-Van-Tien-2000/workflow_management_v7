<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnualLeave extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'start_date',
        'finish_date',
        'user_id',
        'total_day',
        'reason',
        'reason_not_approving',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime:d/m/Y',
        'finish_date' => 'datetime:d/m/Y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['user_id'])) {
            $arr_user_id = json_decode($req['user_id']);
            if (is_array($arr_user_id) && !empty($arr_user_id)) {
               $query->whereIn('user_id', $arr_user_id); 
            } 
        };

        return $query;
    }

}
