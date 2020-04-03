<?php

namespace Q2\Forwarders;

class Falcon extends FreightForwarder
{
    const REALM_FEE = [
        'ch' => [
            'basic_fee' => 200,
            'weight_fee' => 20
        ],
        'tw' => [
            'basic_fee' => 150,
            'weight_fee' => 30
        ]
    ];
}
