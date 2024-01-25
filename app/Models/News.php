<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class News extends Model
{
    protected $table = 'news';
    use Translatable;

    protected $translatable = ['title', 'content_short', 'content'];
}
