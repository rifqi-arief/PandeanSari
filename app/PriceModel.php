<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceModel extends Model
{
    use SoftDeletes;

    protected $table = 'price';    
}