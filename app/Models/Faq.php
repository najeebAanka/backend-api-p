<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Faq extends Model
{

    use Translatable;

    protected $translatable = ['question','answer'];

    protected $table = 'faqs';
}
