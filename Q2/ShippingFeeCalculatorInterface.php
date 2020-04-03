<?php

namespace Q2;

interface ShippingFeeCalculatorInterface
{
    public function getShippingFee($weight);
}
