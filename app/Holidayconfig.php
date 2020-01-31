<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class holidayconfig extends Authenticatable
{
    public $table = 'holiday_config';

    protected $fillable = [
        'name_th', 'name_en','holiday_date','is_active'
    ];
}
