<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class leavecategory extends Authenticatable
{
    use Notifiable,HasApiTokens;

    public $table = 'leave_category';

    protected $fillable = [
        'id','name_th', 'name_en', 'leave_unit','is_active'
    ];
}
