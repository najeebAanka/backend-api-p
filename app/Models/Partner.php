<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Partner extends Model
{
    protected $table = 'partners';
    use Translatable;

    protected $translatable = ['title', 'description'];
}
