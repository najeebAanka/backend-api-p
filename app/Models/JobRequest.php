<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Traits\Resizable;
use TCG\Voyager\Traits\Translatable;

class JobRequest extends Model
{
    protected $table = 'job_requests';

    protected $fillable = [
        'name' ,
        'email' ,
        'phone' ,
        'job_id' ,
        'cv',
    ];
}
