<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','description','price','image'];

    /* Relationships */
    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories');
    }

    /* Closures */
    protected static function booted()
    {
        Pivot::saving(function($pivot) {
            dd("aaaa");
        });
        static::creating(function ($project) {
//            $this->categories->
//            dd($project->categories()->count());
            //todo: belongs to 0..2 categories
        });
    }




}
