<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable  

{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'fullname',
        'username',
        'password',
        'birthday',
        'citizen_identification',
        'email',
        'phone',
        'address',
        'role_id',
        'avatar',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function guardName(){
        return "web";
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }
    public function scopeQueryData($query, $req)
    {    
        if (!empty($req['code'])) {
            $arr_code = json_decode($req['code']);
            if (is_array($arr_code) && !empty($arr_code)) {
               $query->whereIn('code', $arr_code); 
            } 
        };  
        if (!empty($req['fullname'])) {
            $arr_fullname = json_decode($req['fullname']);
            if (is_array($arr_fullname) && !empty($arr_fullname)) {
               $query->whereIn('fullname', $arr_fullname); 
            } 
        };

        if (!empty($req['phone'])) {
            $arr_phone = json_decode($req['phone']);
            if (is_array($arr_phone) && !empty($arr_phone)) {
               $query->whereIn('phone', $arr_phone); 
            } 
        };

        if (!empty($req['role_id'])) {
            $arr_role = json_decode($req['role_id']);
            if (is_array($arr_role) && !empty($arr_role)) {
               $query->whereIn('role_id', $arr_role); 
            } 
        };
        return $query;
    }
    public function listTask()
    {
        return $this->belongsToMany(Task::class,"assigns","user_id","task_id","id","id")->withPivot("assigns.updated_at");
    }
    public function hoanthanh()
    {
        return $this->belongsToMany(Task::class,"assigns","user_id","task_id","id","id");
    }
    public function trehan()
    {
        return $this->belongsToMany(Task::class,"assigns","user_id","task_id","id","id");
    }
    public function danglam()
    {
        return $this->belongsToMany(Task::class,"assigns","user_id","task_id","id","id");
    }
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'otp', 'api_token', 'expired_time','expired_time_otp','last_login','provider'
    // ];
    public function Works()
    {
        return $this->belongsToMany(Work::class,"user_works","user_id", "work_id","id","id");
    }
}
