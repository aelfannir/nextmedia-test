<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateProductWithInvalidArgumentsTest()
    {
        $data = [
            'name'=>null, //required arg
            'description'=>'description name',
            'price'=>100.99
        ];
        $response = $this->post(route('products.store'),$data);

        $response->isServerError();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testValidArguments()
    {
        $data = [
            'name'=>'product name',
            'description'=>'description name',
            'price'=>100.99
        ];
        $response = $this->post(route('products.store'),$data);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
