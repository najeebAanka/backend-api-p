<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Brand extends Model
{
    protected $table = 'brands';
    use Translatable;
    protected $translatable = ['title'];
}
