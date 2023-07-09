<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Timesheet extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'timesheets';
    protected $fillable = [
        'user_id',
        'date',
        'checkin',
        'checkout',
        'content',
        'salary_factor',
    ];

    protected $casts = [
        'checkin' => 'datetime:d/m/Y - H:i:s',
        'checkout' => 'datetime:d/m/Y - H:i:s',
    ];
    public function scopeQueryData($query, $req)
    {      
        if(empty($req['checkin'])||$req['checkin']=="[]")
        {
            $arr_user[0] = substr(Carbon::now()->format('Y-m-d H:i:s'),0,7);      
        }else{
            $arr_user = json_decode($req['checkin']);
        }
        if(empty($req['checkout'])||$req['checkout']=="[]")
        {
            if(empty($req['checkin'])||$req['checkin']=="[]")
            {
                $day = Carbon::now()->format('d');
                $arr_day = [
                    "$day"
                ];
            }else{
            $arr_day = [
                "1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"
            ];
        }
        }else{
            $arr_day = json_decode($req['checkout']);
        }
        $ngay = [];
        foreach($arr_user as $key=>$arr)
        {
            foreach($arr_day as $day)
                {
                    
                    $ngay[] = "$arr-$day";
                }
        }
        $query->whereIn('date', $ngay); 

        if (!empty($req['user_id'])) {
            $arr_fullname = json_decode($req['user_id']);
            if (is_array($arr_fullname) && !empty($arr_fullname)) {
               $query->whereIn('timesheets.user_id', $arr_fullname); 
            } 
        };

        return $query;
            // if (!empty($req['checkout'])) {

                // $arr_day = json_decode($req['checkout']);
                // if (is_array($arr_day) && !empty($arr_day)) {
             
            // }
            // }else
            //  {
            //     foreach($arr_user as $key=>$arr)
            //     {
            //         if($key == 0 )
            //         {
            //             $query->where('date','LIKE', "%$arr%"); 
            //         }else{
            //             $query->orwhere('date','LIKE', "%$arr%"); 
            //         }
            //         $key++;
            //     }
            // } 
        // };
        if(empty($req['checkin'])||$req['checkin']=="[]")
        {
            // $arr_user = substr(Carbon::now()->format('Y-m-d H:i:s'),0,7);
            // if (!empty($req['checkout'])) {

            //     $arr_day = json_decode($req['checkout']);
            //     if (is_array($arr_day) && !empty($arr_day)) {
            //     $ngay = [];
               
            //         foreach($arr_day as $day)
            //             {
                            
            //                 $ngay[] = "$arr_user-$day";
            //             }
            //                             // dd($ngay);
            //     $query->whereIn('date', $ngay); 
            // }

            // }else
            //  {
            //     $query->where('date','LIKE', "%$arr_user%");   
            // } 
            // $monthNow =substr(Carbon::now()->format('Y-m-d H:i:s'),0,7);

            // if (!empty($req['checkout'])) {

            //         $arr_day = json_decode($req['checkout']);
            //         if (is_array($arr_day) && !empty($arr_day)) {
            //         $ngay = [];
            //             foreach($arr_day as $key=>$day)
            //                 {
            //                     if($key<9)
            //                     {
            //                         $ngay[] = "$monthNow-0$day";
            //                     }else{
            //                         $ngay[] = "$monthNow-$day";
            //                     }
            //                     $key++;
            //                 }
            //         dd($ngay);
            //         $query->whereIn('date', $ngay); 
            //         }

            // }else
            // {
            //     $query->where('date','LIKE',"%$monthNow%");
            // }

           
        }
        
        // if (!empty($req['checkout'])) {
        //     $arr_user = json_decode($req['checkout']);

        //     if (is_array($arr_user) && !empty($arr_user)) {
        //        $end = count($arr_user)-1;
        //         foreach($arr_user as $key=>$arr)
        //         {
        //             if($key == 0)
        //             {
        //                 $query->whereDay('checkin', $arr); 
        //             }else{
        //                 $query->orwhereDay('checkin',$arr); 
        //             }
        //             $key++;
        //         }
        //     } 
        // };

       
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
}
