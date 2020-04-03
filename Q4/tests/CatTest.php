<?php

namespace Q4\tests;

use Q2\Forwarders\Cat;

class CatTest extends FreightForwarderTest
{
    public function testCat()
    {
        $this->executeTests(Cat::class);
    }
}
