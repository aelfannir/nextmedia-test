<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /* Relationships */
    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories');
    }
}
