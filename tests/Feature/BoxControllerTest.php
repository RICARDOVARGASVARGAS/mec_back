<?php

namespace Tests\Feature;

use App\Models\Box;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoxControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_boxes()
    {
        $company = Company::factory()->create();
        Box::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getBoxes', $postData);
        $response->assertStatus(200);
    }

    public function test_get_box()
    {
        $company = Company::factory()->create();
        $box = Box::factory()->create();
        $response = $this->post('/mec/getBox/' . $box->id);
        $response->assertStatus(200);
    }

    public function test_get_detail_box()
    {
        $company = Company::factory()->create();
        $box = Box::factory()->create();
        $response = $this->get('/mec/getDetailBox/' . $box->id);
        $response->assertStatus(200);
    }

    public function test_register_box()
    {
        $company = Company::factory()->create();
        $postData = [
            'number' => Box::where('company_id', $company->id)->max('number') + 1,
            'name' => 'Caja de Prueba',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerBox', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('boxes', $postData);
    }

    public function test_update_box()
    {
        $company = Company::factory()->create();
        $box = Box::factory()->create();
        $postData = [
            'name' => 'Caja Actualizada',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateBox/' . $box->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('boxes', $postData);
    }

    public function test_delete_box()
    {
        $company = Company::factory()->create();
        $box = Box::factory()->create();
        $response = $this->delete('/mec/deleteBox/' . $box->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('boxes', $box);
    }
}
