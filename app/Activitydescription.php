<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Activitydescription extends Authenticatable
{
    use Notifiable,HasApiTokens;
    
    public $table = 'activity_description';
    protected $fillable = [
        'activity_id', 'activity_description'
    ];
}
