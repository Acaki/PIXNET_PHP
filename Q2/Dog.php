<?php

namespace Q2;

require_once 'FreightForwarder.php';
class Dog extends FreightForwarder
{
    const REALM_FEE = [
        'us' => [
            'basic_fee' => 0,
            'weight_fee' => 60
        ]
    ];
}