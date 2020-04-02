<?php


namespace Q2;


interface FreightForwarderInterface
{
    public function getBasicFee();

    public function getWeightFee();
}