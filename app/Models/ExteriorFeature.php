<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ExteriorFeature extends Model
{
    use Translatable;
    protected $translatable = ['title'];
    protected $table = 'exterior_features';
}
