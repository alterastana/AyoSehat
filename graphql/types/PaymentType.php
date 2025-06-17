<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PaymentType {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Payment',
                'fields' => [
                    'id_payment' => Type::int(),
                    'appointment_id' => Type::int(),
                    'nominal_bayar' => Type::float(),
                    'metode_bayar' => Type::int(),
                    'status_bayar' => Type::int(),
                    'tanggal_bayar' => Type::string()
                ]
            ]);
        }
        return self::$instance;
    }
}
