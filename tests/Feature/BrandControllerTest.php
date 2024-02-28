<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_brands()
    {
        $company = Company::factory()->create();
        Brand::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getBrands', $postData);
        $response->assertStatus(200);
    }

    public function test_get_brand()
    {
        $company = Company::factory()->create();
        $brand = Brand::factory()->create();
        $response = $this->post('/mec/getBrand/' . $brand->id);
        $response->assertStatus(200);
    }

    public function test_register_brand()
    {
        $company = Company::factory()->create();
        $postData = [
            'number' => Brand::where('company_id', $company->id)->max('number') + 1,
            'name' => 'Marca de Prueba',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerBrand', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('brands', $postData);
    }

    public function test_update_brand()
    {
        $company = Company::factory()->create();
        $brand = Brand::factory()->create();
        $postData = [
            'name' => 'Marca Actualizada',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateBrand/' . $brand->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('brands', $postData);
    }

    public function test_delete_brand()
    {
        $company = Company::factory()->create();
        $brand = Brand::factory()->create();
        $response = $this->delete('/mec/deleteBrand/' . $brand->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('brands', $brand);
    }
}
