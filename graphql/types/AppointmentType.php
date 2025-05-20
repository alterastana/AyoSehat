<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AppointmentType {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Appointment',
                'fields' => [
                    'appointment_id' => Type::int(),
                    'id_pasien' => Type::int(),
                    'id_dokter' => Type::int(),
                    'waktu' => Type::string(),
                    'status' => Type::int(),
                    'tanggal_pesan' => Type::string()
                ]
            ]);
        }
        return self::$instance;
    }
}
