<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Types\PasienType;
use App\Types\DokterType;
use App\Types\AppointmentType;
use App\Types\PaymentType;



class QueryType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'dokters' => [
                    'type' => Type::listOf(DokterType::getInstance()),
                    'resolve' => function ($root, $args, $context) {
                        $conn = $context['db'];
                        $result = mysqli_query($conn, "SELECT * FROM dokter");
                        return mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                ],
                'pasien' => [
                    'type' => PasienType::getInstance(),
                    'args' => [
                        'id_pasien' => Type::nonNull(Type::int())
                    ],
                    'resolve' => function ($root, $args, $context) {
                        $conn = $context['db'];
                        $stmt = $conn->prepare("SELECT * FROM pasien WHERE id_pasien = ?");
                        $stmt->bind_param("i", $args['id_pasien']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        return $result->fetch_assoc();
                    }
                ]
            ]
        ]);
    }
}
