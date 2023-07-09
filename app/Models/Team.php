<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'name', 'type', 'status'];
    public function Details()
    {
        return $this->hasMany(Team_details::class,'team_id','id');
    }

}
