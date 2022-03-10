<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class AuthUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_not_logged_user()
    {
        $response = $this->json("GET","/api/user");

        $response->assertStatus(401);
    }

    public function test_logged_user()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("GET","/api/user");

        $response->assertStatus(200);
    }
}
