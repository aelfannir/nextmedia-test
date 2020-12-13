<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryPivot extends Model
{
    protected $table = "product_categories";

    protected static function booted()
    {
        static::creating(function (){
            dd("creating..");
        });
    }
}
