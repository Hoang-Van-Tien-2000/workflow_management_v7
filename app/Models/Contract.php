<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'contracts';
    protected $fillable = [
        'code',
        'user_id',
        'signing_date',
        'start_date',
        'finish_date',
        'content',
        'salary',
        'contract_id',
    ];

    protected $appends = ['count_renewal'];

    protected $casts = [
        'start_date' => 'datetime:d/m/Y',
        'finish_date' => 'datetime:d/m/Y',
        'signing_date' => 'datetime:d/m/Y',
    ];
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }

    public function contractExtension()
    {
        return $this->hasMany('App\Models\ContractExtension');
    }

    public function getCountRenewalAttribute()
    {
        $count = $this->contractExtension()->count();
        return $count;
    }

    public function role()
    {   
        return $this->hasOneThrough('App\Models\Role', 'App\Models\User', 'id', 'id', 'user_id', 'role_id');
    }

    public function department()
    {   
        return $this->hasOneThrough('App\Models\Department', 'App\Models\User', 'id', 'id', 'user_id', 'department_id');
    }
}
