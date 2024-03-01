<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\AuthController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Mockery;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testLoginWithValidCredentials()
    {
        $controller = new AuthController();
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
            'password' => bcrypt('password123'),
        ]);

        $request = new Request([
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response = $controller->login($request->all());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLoginWithInvalidCredentials()
    {
        $controller = new AuthController();
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
            'password' => bcrypt('password123'),
        ]);
        $request = new Request([
            'email' => 'invalid@example.com',
            'password' => 'wrong_password'
        ]);

        $response = $controller->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }
}
