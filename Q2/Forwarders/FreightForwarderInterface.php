<?php

namespace Q2\Forwarders;

interface FreightForwarderInterface
{
    public function getBasicFee();
    public function getWeightFee();
}
