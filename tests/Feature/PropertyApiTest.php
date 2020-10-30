<?php

namespace Tests\Feature;

use Accordous\Property;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyApiTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/v1/properties';

    public function testItShouldCreateANewPropertyInDatabase()
    {
        $property = factory(Property::class)->create()->toArray();

        $this->assertDatabaseHas('properties', $property);
    }

    public function testItShoulCreateANewProperty()
    {
        $property = factory(Property::class)->make()->toArray();

        $this->json('POST', $this->url, $property, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($property);
    }

    public function testItShouldNotCreateANewPropertyWithSameEmail()
    {
        $propertyEmail = factory(Property::class)->create([
            'email' => 'user@email.com'
        ])->toArray();

        $property = factory(Property::class)->make([
            'email' => $propertyEmail['email']
        ])->toArray();

        $this->json('POST', $this->url, $property, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => [
                        "The email has already been taken."
                    ]
                ]
            ]);
    }

    public function testItShouldShowAProperty()
    {
        $property = factory(Property::class)->make()->toArray();

        $response = $this->json('POST', $this->url, $property, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($property);

        $responseArray = json_decode($response->getContent());

        $this->json('GET', $this->url . '/' . $responseArray->id, [],['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson($property);
    }

}
