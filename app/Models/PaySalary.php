<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaySalary extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pay_salaries';
    protected $fillable = [
        'id',
        'user_id',
        'contract_id',
        'working_day',
        'salary',
        'allowance',
        'total',
        'advance',
        'actual_salary',
        'month',
        'status'
    ];
    protected $casts = [
        'month' => 'datetime:d/m/Y - H:i:s',
    ];

    public function scopeQueryData($query, $req)
    {      
        // dd($req);
      

        if (!empty($req['month'])) {
            $arr_user = json_decode($req['month']);
            if (is_array($arr_user) && !empty($arr_user)) {
              
                foreach($arr_user as $key=>$arr)
                {
                    if($key == 0)
                    {
                        $query->where('month','LIKE', "%$arr%"); 
                    }else{
                        $query->orwhere('month','LIKE', "%$arr%"); 
                    }
                    $key++;
                }
            } 
        };
        if(empty($req['month'])||$req['month']=="[]")
        {
            $monthNow =substr(Carbon::now()->format('Y-m-d H:i:s'),1,7);
            $query->where('month','LIKE',"%$monthNow%")->get();
        }
        
        if (!empty($req['user_id'])) {
            $arr_fullname = json_decode($req['user_id']);
            if (is_array($arr_fullname) && !empty($arr_fullname)) {
               $query->whereIn('pay_salaries.user_id', $arr_fullname); 
            } 
        };
        if (!empty($req['department_id'])) {
            $department = json_decode($req['department_id']);
            if (is_array($department) && !empty($department)) {
                $query->leftJoin('users','users.id','=','pay_salaries.user_id')
                ->whereIn('users.department_id',$department);

            } 
        };
        return $query;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function salarys()
    {
        return $this->belongsTo(Salary::class,'salary_id','id');
    }

    public function getstatusAttribute($value) 
    {
        if($value == 0){
                return $this->status = 'Chưa xác nhận';
        }else{
                return $this->status = 'Đã xác nhận';
        }
    }

    // public function getmonthAttribute($value) 
    // {
    //     // dd( Carbon::parse($value)->format('m-Y'));
    //     return $this->updated_at = Carbon::parse($value)->format('m-Y');
    // }
}
