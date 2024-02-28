<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_clients()
    {
        $company = Company::factory()->create();
        Client::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getClients', $postData);
        $response->assertStatus(200);
    }

    public function test_get_client()
    {
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $response = $this->post('/mec/getClient/' . $client->id);
        $response->assertStatus(200);
    }

    public function test_register_client()
    {
        $company = Company::factory()->create();
        $postData = [
            'document' => '117544585',
            'name' => 'name',
            'surname' => 'surname',
            'last_name' => 'last_name',
            'phone' => 'phone',
            'email' => 'email@gmail.com',
            'address' => 'address',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerClient', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', [
            'document' => '117544585',
            'name' => 'name',
            'surname' => 'surname',
            'last_name' => 'last_name',
            'phone' => 'phone',
            'email' => 'email@gmail.com',
            'address' => 'address',
        ]);
    }

    public function test_update_client()
    {
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $postData = [
            'document' => '117544585',
            'name' => 'name',
            'surname' => 'surname',
            'last_name' => 'last_name',
            'phone' => 'phone',
            'email' => 'email@gmail.com',
            'address' => 'address',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateClient/' . $client->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', [
            'document' => '117544585',
            'name' => 'name',
            'surname' => 'surname',
            'last_name' => 'last_name',
            'phone' => 'phone',
            'email' => 'email@gmail.com',
            'address' => 'address',
        ]);
    }

    public function test_delete_client()
    {
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $response = $this->delete('/mec/deleteClient/' . $client->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('clients', $client);
    }
}
