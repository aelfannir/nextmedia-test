<?php

namespace App\services;

use App\Repositories\ProductRepository;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService extends Service
{
    /**
     * @var array
     */
    public $save_validation_rules = [
        'name' => ['required','max:255'],
        'description'=> ['required','max:255'],
        'price'=> ['required','numeric','gt:0'],
//        'image' => ['image']
    ];

    /**
     * @var array
     */
    protected $update_validation_rules = [
        'name' => ['max:255'],
        'description'=> ['max:255'],
        'price'=> ['numeric','gt:0'],
    ];

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }

    /** Save model.
     *
     * @param array $data
     * @return Collection
     */
    public function save(array $data)
    {
        $image = Arr::get($data, 'image');

        if($image){
            if($image instanceof File || $image instanceof UploadedFile){
                Storage::putFile('public/products', $image);
                Arr::set($data,'image',$image->hashName());
            }
        }else{
            Arr::forget($data, 'image');
        }

        $product = parent::save($data);

        // Attaching categories
        $ids = Arr::get($data, 'categories_ids');

        if($ids){
            if(is_string($ids)) $ids = json_decode($ids);
            // belongsTo 0..2
            $product->categories()->attach(array_slice($ids,0,2));
        }

        return $product;
    }

    /** Save model.
     *
     * @param array $data
     * @param $id
     * @return Collection
     */
    public function update(array $data, $id)
    {
        /* FIXME duplication */
        $image = Arr::get($data, 'image');

        if($image){
            if($image instanceof File || $image instanceof UploadedFile){
                Storage::putFile('public/products', $image);
                Arr::set($data,'image',$image->hashName());
            }
        }else{
            Arr::forget($data, 'image');
        }
        /* END duplication*/

        $product = parent::update($data, $id);

        $ids = Arr::get($data, 'categories_ids');

        if($ids){
            if(is_string($ids)) $ids = json_decode($ids);

            // belongsTo 0..2
            $product->categories()->sync(array_slice($ids,0,2));
        }

        return $product;

    }

}
