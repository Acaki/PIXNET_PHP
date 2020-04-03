<?php

namespace Q2\Forwarders;

class Cat extends FreightForwarder
{
    const REALM_FEE = [
        'us' => [
            'basic_fee' => 100,
            'weight_fee' => 10
        ]
    ];
}
