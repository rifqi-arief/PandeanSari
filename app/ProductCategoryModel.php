<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_category';    
}