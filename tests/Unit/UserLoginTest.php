<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use DatabaseTransactions;

    private $dummyRequest = [
        'name' => "",
        'email' => "",
        'password' => "",
        'password_confirmation' => "",
    ];
    
    public function test_empty_request()
    {
        $response = $this->json("post","api/login",[]);
        $response->assertStatus(422);
    }

    public function test_request_empty_email()
    {
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_valid_email()
    {
        $this->dummyRequest["email"] = "test@test.it";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayNotHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_string()
    {
        $this->dummyRequest["email"] = "test email";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_at()
    {
        $this->dummyRequest["email"] = "testemail.it";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_extension()
    {
        $this->dummyRequest["email"] = "teste@mail";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayNotHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_first_part()
    {
        $this->dummyRequest["email"] = "@mail.it";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_domain()
    {
        $this->dummyRequest["email"] = "test@";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_empty_password()
    {
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayHasKey("password",$response["errors"]);
    }

    public function test_request_not_empty_password()
    {
        $this->dummyRequest["password"] = "testpassword";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayNotHasKey("password",$response["errors"]);
    }

    public function test_request_not_registered_user()
    {
        $this->dummyRequest["email"] = "email@email.it";
        $this->dummyRequest["password"] = "password";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayNotHasKey("errors",$response);
        $response->assertStatus(401);
    }

    public function test_request_registered_user()
    {
        User::create([
            'name' => "testname",
            'email' => "user@email.it",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->dummyRequest["email"] = "user@email.it";
        $this->dummyRequest["password"] = "password";
        $response = $this->json("post","api/login",$this->dummyRequest);
        $this->assertArrayNotHasKey("errors",$response);
        $response->assertStatus(200);
    }
}
