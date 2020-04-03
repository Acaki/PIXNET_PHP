<?php

namespace Q4\tests;

use Q2\Forwarders\Dog;

class DogTest extends FreightForwarderTest
{
    public function testDog()
    {
        $this->executeTests(Dog::class);
    }
}
