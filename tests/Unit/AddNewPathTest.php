<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AddNewPathTest extends TestCase
{
    use DatabaseTransactions;

    private $dummyRequest = [
        //Path data
        'title' => "",
        'description' => "",
        'location' => "",
        'difficulty' => "",
        'disability' => "",
        'length' => "",
        'duration' => "",
        //Coordinates data
        'coordinates' => [],
        //Interest Point Data
        'interest_points' => []
    ];
    

    public function test_not_authenticated_request()
    {
        $response = $this->json("post","api/path");
        $response->assertStatus(401);
    }

    public function test_authenticated_request_without_payload()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $response->assertStatus(422);
    }

    public function test_authenticated_request_empty_title()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("title",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_title()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["title"] = "test title";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("title",$response["errors"]);
    }

    public function test_authenticated_request_empty_description()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("description",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_description()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["description"] = "test description";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("description",$response["errors"]);
    }

    public function test_authenticated_request_empty_location()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("location",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_location()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["location"] = "test location";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("location",$response["errors"]);
    }

    public function test_authenticated_request_empty_difficulty()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("difficulty",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_difficulty()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["difficulty"] = "test difficulty";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("difficulty",$response["errors"]);
    }

    public function test_authenticated_request_empty_disability()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("disability",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_disability_with_string()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["disability"] = "test disability";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("disability",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_disability_with_boolean()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["disability"] = true;
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("disability",$response["errors"]);
    }

    public function test_authenticated_request_empty_length()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("length",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_length_with_string()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["length"] = "test length";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("length",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_length_with_numeric()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["length"] = 2000;
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("length",$response["errors"]);
    }

    public function test_authenticated_request_empty_duration()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("duration",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_duration_with_string()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["duration"] = "test duration";
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("duration",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_duration_with_numeric()
    {
        Sanctum::actingAs( User::factory()->create());
        $this->dummyRequest["length"] = 2000;
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("length",$response["errors"]);
    }

    public function test_authenticated_request_empty_coordinates_array()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("coordinates",$response["errors"]);
    }

    public function test_authenticated_request_coordinates_empty_latitude_not_empty_longitude()
    {
        $this->dummyRequest["coordinates"][0]["longitude"] = 20.93004;
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("coordinates.0.latitude",$response["errors"]);
    }

    public function test_authenticated_request_coordinates_empty_longitude_not_empty_latitude()
    {
        $this->dummyRequest["coordinates"][0]["latitude"] = 20.93004;
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("coordinates.0.longitude",$response["errors"]);
    }

    public function test_authenticated_request_coordinates_not_empty_longitude_not_empty_latitude()
    {
        $this->dummyRequest["coordinates"][0]["latitude"] = 20.93004;
        $this->dummyRequest["coordinates"][0]["longitude"] = 20.93004;
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("coordinates.0.longitude",$response["errors"]);
        $this->assertArrayNotHasKey("coordinates.0.latitude",$response["errors"]);
    }

    public function test_authenticated_request_empty_interest_points_array()
    {
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("interest_points",$response["errors"]);
    }

    public function test_authenticated_request_empty_interest_point_title()
    {
        $this->dummyRequest["interest_points"][0]["title"] = "";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("interest_points.0.title",$response["errors"]);
    }

    public function test_authenticated_request_not_empty_interest_point_title()
    {
        $this->dummyRequest["interest_points"][0]["title"] = "test title";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("interest_points.0.title",$response["errors"]);
    }

    public function test_authenticated_request_empty_interest_point_description()
    {
        $this->dummyRequest["interest_points"][0]["description"] = "";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("interest_points.0.description",$response["errors"]);
    }
    
    public function test_authenticated_request_not_empty_interest_point_description()
    {
        $this->dummyRequest["interest_points"][0]["description"] = "test description";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("interest_points.0.description",$response["errors"]);
    }

    public function test_authenticated_request_empty_interest_point_category()
    {
        $this->dummyRequest["interest_points"][0]["category"] = "";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("interest_points.0.category",$response["errors"]);
    }
    
    public function test_authenticated_request_not_empty_interest_point_category()
    {
        $this->dummyRequest["interest_points"][0]["category"] = "test category";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("interest_points.0.category",$response["errors"]);
    }

    public function test_authenticated_request_empty_interest_point_latitude()
    {
        $this->dummyRequest["interest_points"][0]["latitude"] = "";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("interest_points.0.latitude",$response["errors"]);
    }
    
    public function test_authenticated_request_not_empty_interest_point_latitude()
    {
        $this->dummyRequest["interest_points"][0]["latitude"] = 20.000;
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("interest_points.0.latitude",$response["errors"]);
    }

    public function test_authenticated_request_empty_interest_point_longitude()
    {
        $this->dummyRequest["interest_points"][0]["longitude"] = "";
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayHasKey("interest_points.0.longitude",$response["errors"]);
    }
    
    public function test_authenticated_request_not_empty_interest_point_longitude()
    {
        $this->dummyRequest["interest_points"][0]["longitude"] = 20.000;
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$this->dummyRequest);
        $this->assertArrayNotHasKey("interest_points.0.longitude",$response["errors"]);
    }

    public function test_authenticated_complete_request()
    {
        $request = [
            //Path data
            'title' => "test",
            'description' => "test",
            'location' => "test",
            'difficulty' => "test",
            'disability' => false,
            'length' => 200,
            'duration' => 200,
            //Coordinates data
            'coordinates' => [
                [
                    'longitude' => 20.0004,
                    'latitude' => 20.0000,
                ]
            ],
            //Interest Point Data
            'interest_points' => [
                [
                    'title' => "test",
                    'description' => "test",
                    'category' => "test",
                    'longitude' => 20.0004,
                    'latitude' => 20.0000,
                ]
            ]
        ];
        Sanctum::actingAs( User::factory()->create());
        $response = $this->json("post","api/path",$request);
        $this->assertArrayNotHasKey("errors",$response);
        $response->assertStatus(200);
    }
}
