<?php

namespace App\services;

use App\Repositories\ProductRepository;
use Illuminate\Http\File;
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
            if($image instanceof File){
                Storage::putFile('public/products', $image);
                Arr::set($data,'image',$image->hashName());
            }
        }else{
            Arr::forget($data, 'image');
        }

        $product = parent::save($data);

        // Attaching categories
        if(Arr::has($data, 'categories_ids') && is_array($ids = Arr::get($data,'categories_ids'))){
            // belongsTo 0..2
            $product->categories()->attach(array_slice($ids,1,2));
        }

        return $product;
    }

    public function update(array $data, $id)
    {
        //TODO belongsTo 0..2
        return parent::update($data, $id);
    }

}
