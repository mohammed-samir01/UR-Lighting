<?php

namespace App\Model;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Model;
use App;

class City extends Model
{
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
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
