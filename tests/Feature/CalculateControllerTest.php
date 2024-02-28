<?php

namespace Tests\Feature;

use App\Models\Calculate;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_calculates()
    {
        $company = Company::factory()->create();
        Calculate::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/calculate/getCalculates', $postData);
        $response->assertStatus(200);
    }

    public function test_get_calculate()
    {
        $company = Company::factory()->create();
        $calculate = Calculate::factory()->create();
        $response = $this->post('/calculate/getCalculate/' . $calculate->id);
        $response->assertStatus(200);
    }

    public function test_register_calculate()
    {
        $company = Company::factory()->create();
        $postData = [
            'number' => Calculate::where('company_id', $company->id)->max('number') + 1,
            'property_calculate' => 'property_calculate',
            'driver_calculate' => 'driver_calculate',
            'ruc_calculate' => 'ruc_calculate',
            'dni_calculate' => 'dni_calculate',
            'phone_calculate' => 'phone_calculate',
            'cel_property_calculate' => 'cel_property_calculate',
            'cel_driver_calculate' => 'cel_driver_calculate',
            'address_calculate' => 'address_calculate',
            'plate_calculate' => 'plate_calculate',
            'engine_calculate' => 'engine_calculate',
            'chassis_calculate' => 'chassis_calculate',
            'brand_calculate' => 'brand_calculate',
            'model_calculate' => 'model_calculate',
            'year_car_calculate' => 'year_car_calculate',
            'color_calculate' => 'color_calculate',
            'km_calculate' => 'km_calculate',
            'observation_calculate' => 'observation_calculate',
            'company_id' => $company->id
        ];
        $response = $this->post('/calculate/registerCalculate', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('calculates', $postData);
    }

    public function test_update_calculate()
    {
        $company = Company::factory()->create();
        $calculate = Calculate::factory()->create();
        $postData = [
            'property_calculate' => 'property_calculate',
            'driver_calculate' => 'driver_calculate',
            'ruc_calculate' => 'ruc_calculate',
            'dni_calculate' => 'dni_calculate',
            'phone_calculate' => 'phone_calculate',
            'cel_property_calculate' => 'cel_property_calculate',
            'cel_driver_calculate' => 'cel_driver_calculate',
            'address_calculate' => 'address_calculate',
            'plate_calculate' => 'plate_calculate',
            'engine_calculate' => 'engine_calculate',
            'chassis_calculate' => 'chassis_calculate',
            'brand_calculate' => 'brand_calculate',
            'model_calculate' => 'model_calculate',
            'year_car_calculate' => 'year_car_calculate',
            'color_calculate' => 'color_calculate',
            'km_calculate' => 'km_calculate',
            'observation_calculate' => 'observation_calculate',
            'company_id' => $company->id
        ];
        $response = $this->post('/calculate/updateCalculate/' . $calculate->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('calculates', $postData);
    }

    public function test_delete_calculate()
    {
        $company = Company::factory()->create();
        $calculate = Calculate::factory()->create();
        $response = $this->delete('/calculate/deleteCalculate/' . $calculate->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('calculates', $calculate);
    }
}
