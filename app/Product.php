<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','description','price','image'];
    protected $with = ['categories'];

    /* Relationships */
    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories');
    }

}
