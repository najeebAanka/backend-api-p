<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Team extends Model
{
    protected $table = 'team';

    use Translatable;

    protected $translatable = ['title', 'description'];

}
