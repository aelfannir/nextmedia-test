<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


    /* Relationships */
    public function parent() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function children() {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_categories');
    }

    /* Closures */
    protected static function booted()
    {
        static::creating(function ($project) {
            dd($project->categories);
        });
    }

}
