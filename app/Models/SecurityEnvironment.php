<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class SecurityEnvironment extends Model
{
    use Translatable;

    public $timestamps = false;
    protected $translatable = ['title'];
    protected $table = 'security_environments';
}
