<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_services()
    {
        $company = Company::factory()->create();
        Service::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getServices', $postData);
        $response->assertStatus(200);
    }

    public function test_get_service()
    {
        $company = Company::factory()->create();
        $service = Service::factory()->create();
        $response = $this->post('/mec/getService/' . $service->id);
        $response->assertStatus(200);
    }

    public function test_register_service()
    {
        $company = Company::factory()->create();
        $postData = [
            'name' => 'name',
            'ticket' => 'ticket',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerService', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('services', $postData);
    }

    public function test_update_service()
    {
        $company = Company::factory()->create();
        $service = Service::factory()->create();
        $postData = [
            'name' => 'name',
            'ticket' => 'ticket',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateService/' . $service->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('services', $postData);
    }

    public function test_delete_service()
    {
        $company = Company::factory()->create();
        $service = Service::factory()->create();
        $response = $this->delete('/mec/deleteService/' . $service->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('services', $service);
    }
}
