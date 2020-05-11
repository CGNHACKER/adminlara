<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Activity extends Authenticatable
{
    use Notifiable,HasApiTokens;
    
    public $table = 'activity';
    protected $fillable = [
        'activity_code', 'user_id','is_active'
    ];
}
