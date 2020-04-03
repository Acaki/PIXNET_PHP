<?php

namespace Q4\tests;

use Q2\Forwarders\Tiger;

class TigerTest extends FreightForwarderTest
{
    public function testTiger()
    {
        $this->executeTests(Tiger::class);
    }
}
