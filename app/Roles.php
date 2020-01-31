<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class roles extends Authenticatable
{
    use Notifiable,HasApiTokens;

    protected $fillable = [
        'role_name_th', 'role_name_en', 'role_slug','is_active'
    ];

}
