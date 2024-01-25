<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Review extends Model
{
    protected $table = 'reviews';
    use Translatable;

    protected $translatable = ['name', 'content'];
}
