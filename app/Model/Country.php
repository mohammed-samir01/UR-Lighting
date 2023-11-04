<?php

namespace App\Model;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
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

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }

}
