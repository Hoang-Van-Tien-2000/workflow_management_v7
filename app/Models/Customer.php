<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'address',
        'status',
    ];
    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['code'])) {
            $arr_makh = json_decode($req['code']);
            if (is_array($arr_makh) && !empty($arr_makh)) {
               $query->whereIn('code', $arr_makh); 
            }
        };
        if (!empty($req['phone'])) {
            $arr_phone = json_decode($req['phone']);
            if (is_array($arr_phone) && !empty($arr_phone)) {
               $query->whereIn('phone', $arr_phone); 
            }
        };
        if (!empty($req['email'])) {
            $arr_email = json_decode($req['email']);
            if (is_array($arr_email) && !empty($arr_email)) {
               $query->whereIn('email', $arr_email); 
            }
        };
        return $query;
    }
}
