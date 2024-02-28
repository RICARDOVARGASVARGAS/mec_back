<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_colors()
    {
        $company = Company::factory()->create();
        Color::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getColors', $postData);
        $response->assertStatus(200);
    }

    public function test_get_color()
    {
        $company = Company::factory()->create();
        $color = Color::factory()->create();
        $response = $this->post('/mec/getColor/' . $color->id);
        $response->assertStatus(200);
    }

    public function test_register_color()
    {
        $company = Company::factory()->create();
        $postData = [
            'number' => Color::where('company_id', $company->id)->max('number') + 1,
            'name' => 'Color de Prueba',
            'hex' => '#ffffff',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerColor', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('colors', $postData);
    }

    public function test_update_color()
    {
        $company = Company::factory()->create();
        $color = Color::factory()->create();
        $postData = [
            'name' => 'Color Actualizada',
            'hex' => '#000000',
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateColor/' . $color->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('colors', $postData);
    }

    public function test_delete_color()
    {
        $company = Company::factory()->create();
        $color = Color::factory()->create();
        $response = $this->delete('/mec/deleteColor/' . $color->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('colors', $color);
    }
}
