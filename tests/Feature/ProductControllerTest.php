<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_products()
    {
        $company = Company::factory()->create();
        Product::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getProducts', $postData);
        $response->assertStatus(200);
    }

    public function test_get_product()
    {
        $company = Company::factory()->create();
        $product = Product::factory()->create();
        $response = $this->post('/mec/getProduct/' . $product->id);
        $response->assertStatus(200);
    }

    public function test_register_product()
    {
        $company = Company::factory()->create();
        $postData = [
            'name' => 'name',
            'ticket' => 'ticket',
            'price_buy' => 4.52,
            'price_sell' => 5.63,
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerProduct', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('products', $postData);
    }

    public function test_update_product()
    {
        $company = Company::factory()->create();
        $product = Product::factory()->create();
        $postData = [
            'name' => 'name',
            'ticket' => 'ticket',
            'price_buy' => 4.52,
            'price_sell' => 5.63,
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateProduct/' . $product->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $postData);
    }

    public function test_delete_product()
    {
        $company = Company::factory()->create();
        $product = Product::factory()->create();
        $response = $this->delete('/mec/deleteProduct/' . $product->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('products', $product);
    }
}
