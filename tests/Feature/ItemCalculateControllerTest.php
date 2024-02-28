<?php

namespace Tests\Feature;

use App\Models\Calculate;
use App\Models\Company;
use App\Models\ItemCalculate;
use Database\Factories\ItemCalculateFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemCalculateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_items()
    {
        $company = Company::factory()->create();
        $calculate = Calculate::factory()->create();
        $response = $this->get('/calculate/getListItemsCalculate/' . $calculate->id);
        $response->assertStatus(200);
    }


    public function test_register_item()
    {
        $company = Company::factory()->create();
        $calculate = Calculate::factory()->create();
        $postData = [
            'amount_item' => 4,
            'description_item' => 'description_item',
            'brand_item' => 'brand_item',
            'price_item' => 5.22,
            'calculate_id' => $calculate->id
        ];
        $response = $this->post('/calculate/registerItemCalculate', $postData);
        $response->assertStatus(200);
    }

    public function test_delete_item()
    {
        $company = Company::factory()->create();
        $calculate = Calculate::factory()->create();
        $item = ItemCalculate::Factory()->create();
        $response = $this->delete('/calculate/deleteItemCalculate/' . $item->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('', $brand);
    }
}
