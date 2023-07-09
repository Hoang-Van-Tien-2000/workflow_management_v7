<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use DateTimeInterface;

class Work extends Model implements Searchable
{
    use HasFactory,SoftDeletes;
    protected $table = "works";

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function dsUser()
    {
        return $this->belongsToMany(User::class,'user_works','work_id','user_id');
    }
    

    public function level()
    {
        return $this->hasMany(Level::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }
    public function getEndingAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
    public function getStartingAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('project.list');
        $null = null;

        return new SearchResult(
            $this,
            $this->name ?:$null,
            $url
        );
    }
}
