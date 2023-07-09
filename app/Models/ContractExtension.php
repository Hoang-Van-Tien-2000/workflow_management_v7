<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractExtension extends Model
{
    use HasFactory;
    // use SoftDeletes;
    // protected $fillable = [
    //     'contract_id',
    //     'renewal_date_start',
    //     'renewal_date_finish',
    //     'salary_factor',
    // ];

    // public function contract()
    // {
    //     return $this->belongsTo(Contract::class);
    // }

    // public function user()
    // {   
    //     //id -> index 1 => bảng Insurance lk bảng Contract : Contract.id
    //     //id -> index 2 => bảng Customer lk bảng Contract : Customer.id
    //     return $this->hasOneThrough('App\Models\User', 'App\Models\Contract', 'id', 'id', 'contract_id', 'user_id');
    // }

    public function scopeQueryData($query, $req)
    {      
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
}
