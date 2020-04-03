<?php

namespace Q2\Forwarders;

class Dog extends FreightForwarder
{
    const REALM_FEE = [
        'us' => [
            'basic_fee' => 0,
            'weight_fee' => 60
        ]
    ];
}
