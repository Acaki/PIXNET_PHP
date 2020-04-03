<?php

namespace Q2;

use Q2\Forwarders\FreightForwarderInterface;

class ShippingFeeAdapter implements ShippingFeeCalculatorInterface
{
    private FreightForwarderInterface $freightForwarder;

    public function __construct(FreightForwarderInterface $freightForwarder)
    {
        $this->freightForwarder = $freightForwarder;
    }

    public function getShippingFee($weight)
    {
        return $this->freightForwarder->getBasicFee() + $this->freightForwarder->getWeightFee() * $weight;
    }
}
