<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PasienType {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Pasien',
                'fields' => [
                    'id_pasien' => Type::int(),
                    'username' => Type::string(),
                    'password' => Type::string(),
                    'nama_pasien' => Type::string(),
                    'email' => Type::string(),
                    'no_telepon' => Type::int(),
                    'registered_time' => Type::string()
                ]
            ]);
        }
        return self::$instance;
    }
}
