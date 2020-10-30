<?php

namespace Tests\Unit;

use Accordous\Property;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTest extends TestCase
{
    public function testItShouldCreateAProperty()
    {
        $property = factory(Property::class)->create();

        $this->assertInstanceOf(Property::class, $property);
    }
}
