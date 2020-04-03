<?php

namespace Q4\tests;

use Q2\Forwarders\FreightForwarderInterface;
use Q2\ShippingFeeAdapter;
use PHPUnit\Framework\TestCase;

class ShippingFeeAdapterTest extends TestCase
{
    /**
     * @dataProvider feeProvider
     * @param $basicFee
     * @param $weightFee
     * @param $weight
     * @param $totalFee
     */
    public function testGetShippingFee($basicFee, $weightFee, $weight, $totalFee)
    {
        $stub = $this->createStub(FreightForwarderInterface::class);
        $stub->method('getBasicFee')->willReturn($basicFee);
        $stub->method('getWeightFee')->willReturn($weightFee);
        $adapter = new ShippingFeeAdapter($stub);
        $this->assertEquals($totalFee, $adapter->getShippingFee($weight));
    }

    public function feeProvider()
    {
        return [
            [0, 100, 25, 2500],
            [100, 0, 25, 100],
            [0, 0, 25, 0],
            [0, 100, 0, 0],
            [100, 100, 0, 100],
        ];
    }
}
