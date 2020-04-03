<?php

namespace Q4\tests;

use Q2\Forwarders\Falcon;

class FalconTest extends FreightForwarderTest
{
    public function testFalcon()
    {
        $this->executeTests(Falcon::class);
    }
}
