<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class leave extends Authenticatable
{
    use Notifiable,HasApiTokens;
    
    public $table = 'leave';
    protected $fillable = [
        'user_id', 'approve_by_role_id','reason_leave','date_of_leave','holiday_of_leave','leave_category_id','leave_start','leave_end','is_accept','is_accept_by_user_id','status_confirm_date'
    ];
}
