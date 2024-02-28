<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Year;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YearControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_years()
    {
        $company = Company::factory()->create();
        Year::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getYears', $postData);
        $response->assertStatus(200);
    }

    public function test_get_year()
    {
        $company = Company::factory()->create();
        $year = Year::factory()->create();
        $response = $this->post('/mec/getYear/' . $year->id);
        $response->assertStatus(200);
    }

    public function test_register_year()
    {
        $company = Company::factory()->create();
        $postData = [
            'number' => Year::where('company_id', $company->id)->max('number') + 1,
            'name' => 'Año de Prueba',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerYear', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('years', $postData);
    }

    public function test_update_year()
    {
        $company = Company::factory()->create();
        $year = Year::factory()->create();
        $postData = [
            'name' => 'Año Actualizada',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateYear/' . $year->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('years', $postData);
    }

    public function test_delete_year()
    {
        $company = Company::factory()->create();
        $year = Year::factory()->create();
        $response = $this->delete('/mec/deleteYear/' . $year->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('years', $year);
    }
}
