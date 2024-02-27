<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_company()
    {
        $company = Company::factory()->create();
        $response = $this->get('/company/getCompany/' . $company->id);
        $response->assertStatus(200);
    }

    public function test_register_company()
    {
        $postData = [
            'name_company' => 'Mecánica de prueba',
            'names' => 'Nombres de prueba',
            'surnames' => 'Apellidos de prueba',
            'phone' => '912547885',
            'email' => 'mecanica@gmail.com',
        ];

        $response = $this->post('/company/registerCompany', $postData);
        // dd($response);
        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', [
            'name' => 'Mecánica de prueba',
        ]);
    }

    public function test_update_company()
    {
        $company = Company::factory()->create();
        $postData = [
            'name' => 'Mecánica de prueba',
            'phone' => '99998855',
            'address' => 'dirección de prueba',
            'account_one' => 'cuenta bancaria 1 de prueba',
            'account_two' => 'cuenta bancaria 2 de prueba',
            'account_three' => 'cuenta bancaria 3 de prueba',
        ];

        $response = $this->put('/company/updateCompany/' . $company->id, $postData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', $postData);
    }
}
