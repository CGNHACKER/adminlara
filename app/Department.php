<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class department extends Authenticatable
{
    use Notifiable,HasApiTokens;
    
    public $table = 'department';
    protected $fillable = [
        'name_th', 'name_en','is_active'
    ];
}
