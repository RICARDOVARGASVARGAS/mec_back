<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Example;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_examples()
    {
        $company = Company::factory()->create();
        Example::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getExamples', $postData);
        $response->assertStatus(200);
    }

    public function test_get_example()
    {
        $company = Company::factory()->create();
        $example = Example::factory()->create();
        $response = $this->post('/mec/getExample/' . $example->id);
        $response->assertStatus(200);
    }

    public function test_register_example()
    {
        $company = Company::factory()->create();
        $postData = [
            'number' => Example::where('company_id', $company->id)->max('number') + 1,
            'name' => 'Modelo de Prueba',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerExample', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('examples', $postData);
    }

    public function test_update_example()
    {
        $company = Company::factory()->create();
        $example = Example::factory()->create();
        $postData = [
            'name' => 'Modelo Actualizada',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateExample/' . $example->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('examples', $postData);
    }

    public function test_delete_example()
    {
        $company = Company::factory()->create();
        $example = Example::factory()->create();
        $response = $this->delete('/mec/deleteExample/' . $example->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('examples', $example);
    }
}
