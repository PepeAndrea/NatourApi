<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterUserTest extends TestCase
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
        $response = $this->json("post","api/register",[]);
        $response->assertStatus(422);
    }

    public function test_request_empty_name()
    {
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("name",$response["errors"]);
    }

    public function test_request_not_empty_name()
    {
        $this->dummyRequest["name"] = "test name";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayNotHasKey("name",$response["errors"]);
    }

    public function test_request_empty_email()
    {
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_valid_email()
    {
        $this->dummyRequest["email"] = "test@test.it";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayNotHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_string()
    {
        $this->dummyRequest["email"] = "test email";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_at()
    {
        $this->dummyRequest["email"] = "testemail.it";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_extension()
    {
        $this->dummyRequest["email"] = "teste@mail";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayNotHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_first_part()
    {
        $this->dummyRequest["email"] = "@mail.it";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_not_valid_email_no_domain()
    {
        $this->dummyRequest["email"] = "test@";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

    public function test_request_empty_password()
    {
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("password",$response["errors"]);
    }

    public function test_request_password_without_confirmation()
    {
        $this->dummyRequest["password"] = "abc";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("password",$response["errors"]);
    }

    public function test_request_not_minimum_length_password()
    {
        $this->dummyRequest["password"] = "abc";
        $this->dummyRequest["password_confirmation"] = "abc";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayHasKey("password",$response["errors"]);
    }

    public function test_request_valid_password()
    {
        $this->dummyRequest["password"] = "testpassword";
        $this->dummyRequest["password_confirmation"] = "testpassword";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayNotHasKey("password",$response["errors"]);
    }

    public function test_valid_request()
    {
        $this->dummyRequest["name"] = "test";
        $this->dummyRequest["email"] = "email@email.it";
        $this->dummyRequest["password"] = "password";
        $this->dummyRequest["password_confirmation"] = "password";
        $response = $this->json("post","api/register",$this->dummyRequest);
        $this->assertArrayNotHasKey("errors",$response);
        $response->assertStatus(200);
    }

    public function test_request_duplicated_email()
    {
        $user = [
            'name' => "test",
            'email' => "test@email.it",
            'password' => "password",
            'password_confirmation' => "password",
        ];

        $response = $this->json("post","api/register",$user);
        $response->assertStatus(200);
        $response = $this->json("post","api/register",$user);
        $response->assertStatus(422);
        $this->assertArrayHasKey("email",$response["errors"]);
    }

}
