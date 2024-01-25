<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Job extends Model
{
    protected $table = 'jobs';

    use Translatable;

    protected $translatable = ['title', 'position', 'description'];

}
