<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\AppService;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ProductAppService
 * @package App\Services\Product
 */
class ProductService extends AppService
{

    /**
     * @var string
     */
    public $uploadPath = 'public/products';

    /**
     * @var array
     */
    public $saveRules = [
        'name' => ['required','max:255'],
        'description'=> ['required','max:255'],
        'price'=> ['required','numeric','gt:0'],
        'categoriesIds'=> ["array","min:0","max:2"],
//        'image' => ['image']
    ];

    /**
     * @var array
     */
    protected $updateRules = [
        'name' => ['max:255'],
        'description'=> ['max:255'],
        'price'=> ['numeric','gt:0'],
        'categoriesIds'=> ["array","min:0","max:2"],
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

    /**
     * @param File $image
     * @param Product|Model $product
     * @return string
     * @throws FileNotFoundException
     * @throws \Throwable
     */
    private function uploadImage(File $image, $product): ?string
    {
        $path = "$this->uploadPath/$product->id";

        try {
            $name = time().'-'.uniqid().'.'.$image->guessExtension();

            Storage::putFileAs($path, $image, $name);
        } catch (Exception $e) {
            throw new FileNotFoundException();
        }


        $oldImage = $product->image;
        $product->image = $name;
        $product->save();

        //remove old image
        if ($oldImage & Storage::exists("$path/$oldImage")) {
            Storage::delete("$path/$oldImage");
        }

        return $name;
    }

    /** Save product
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function save(array $attributes = []): Model
    {
        DB::beginTransaction();

        $product = parent::save(
            Arr::except($attributes, ['image'])
        );

        // Attach categories
        try {
            $product->categories()->attach(
                Arr::get($attributes, 'categoriesIds', [])
            );
        } catch (Exception $e) {
            DB::rollBack();

            throw new FileNotFoundException();
        }

        //upload & Save Image
        $image = Arr::get($attributes, 'image');
        if ($image) {
            try {
                $this->uploadImage($image, $product);
            } catch (Exception $e) {
                DB::rollBack();

                throw new FileNotFoundException();
            }
        }

        DB::commit();

        return $product->fresh();
    }

    /**
     * @param array $attributes
     * @param $id
     * @return Model
     * @throws \Throwable
     */
    public function update(array $attributes, $id): Model
    {
        DB::beginTransaction();

        $product = parent::update(
            Arr::except($attributes, ['image']),
            $id
        );

        // Sync categories
        try {
            $product->categories()->sync(
                Arr::get($attributes, 'categoriesIds', [])
            );
        } catch (Exception $e) {
            DB::rollBack();

            throw new FileNotFoundException();
        }

        //upload & Save Image
        $image = Arr::get($attributes, 'image');
        if ($image) {
            try {
                $this->uploadImage($image, $product);
            } catch (Exception $e) {
                DB::rollBack();

                throw new FileNotFoundException();
            }
        }

        DB::commit();

        return $product->fresh();
    }

}
