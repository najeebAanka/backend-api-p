<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Status extends Model
{

    use Translatable;

    protected $translatable = ['name'];

    protected $table = 'statuses';
}
