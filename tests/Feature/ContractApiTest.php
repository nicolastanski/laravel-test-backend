<?php

namespace Tests\Feature;

use Accordous\Contract;
use Accordous\Property;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractApiTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/v1/contracts';

    public function testItShouldCreateANewContract()
    {
        $property = factory(Property::class)->create([
            'email' => 'user@email.com'
        ])->toArray();

        $contract = factory(Contract::class)->make([
            'property_id' => $property['id']
        ])->toArray();

        $this->json('POST', $this->url, $contract, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($contract);
    }
}
