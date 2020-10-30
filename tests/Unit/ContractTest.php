<?php

namespace Tests\Unit;

use Accordous\Contract;
use Accordous\Property;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractTest extends TestCase
{
    public function testItShouldCreateContractWithAProperty()
    {
        $property = factory(Property::class)->create([
            'id' => 1
        ]);

        $contract = factory(Contract::class)->create([
            'property_id' => $property['id']
        ]);

        $this->assertInstanceOf(Contract::class, $contract);
    }
}
