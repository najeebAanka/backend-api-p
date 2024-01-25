<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as LModel;
use TCG\Voyager\Traits\Translatable;

class Model extends LModel
{
    protected $table = 'models';
    use Translatable;

    protected $translatable = ['title'];
}
