<?php

namespace App\Model;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = ['name','country_id','status'];
    protected $appends = ['name'];
    private $lang;

    public function __construct()
    {
        $this->lang = Helpers::app_lang();
    }

    public function getNameAttribute()
    {
        return $this->{'name_' . $this->lang};
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function cities(){
        return $this->hasMany(City::class);
    }
}
