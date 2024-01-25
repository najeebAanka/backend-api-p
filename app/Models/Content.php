<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Content extends Model
{
    protected $table = 'contents';

    use Translatable;
    public $timestamps=false;

    protected $translatable = ['title', 'description'];

}
