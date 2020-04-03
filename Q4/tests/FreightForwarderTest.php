<?php

namespace Q4\tests;

use PHPUnit\Framework\TestCase;

abstract class FreightForwarderTest extends TestCase
{
    protected function executeTests(string $freightForwarderName)
    {
        $realmFee = $freightForwarderName::REALM_FEE;
        foreach ($realmFee as $realm => $fee) {
            $freightForwarder = new $freightForwarderName($realm);
            $this->assertEquals($fee['basic_fee'], $freightForwarder->getBasicFee());
            $this->assertEquals($fee['weight_fee'], $freightForwarder->getWeightFee());
        }
    }
}
