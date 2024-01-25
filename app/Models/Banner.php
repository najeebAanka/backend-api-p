<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Banner extends Model
{
    protected $table = 'banners';
    use Translatable;

    protected $translatable = ['title', 'sub_title', 'sub_sub_title'];
}
