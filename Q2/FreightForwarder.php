<?php

namespace Q2;

require_once 'FreightForwarderInterface.php';
abstract class FreightForwarder implements FreightForwarderInterface
{
    private $basicFee;
    private $weightFee;

    public function __construct($realm)
    {
        if (!isset(static::REALM_FEE[$realm])) {
            throw new \InvalidArgumentException("The freight forwarder does not provide service in {$realm}");
        }
        $this->basicFee = static::REALM_FEE[$realm]['basic_fee'];
        $this->weightFee = static::REALM_FEE[$realm]['weight_fee'];
    }

    public function getBasicFee()
    {
        return $this->basicFee;
    }

    public function getWeightFee()
    {
        return $this->weightFee;
    }
}