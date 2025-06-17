<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class DokterType {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ObjectType([
                'name' => 'Dokter',
                'fields' => [
                    'id_dokter' => Type::int(),
                    'nama_dokter' => Type::string(),
                    'spesialisasi' => Type::string(),
                    'biaya_kosultas' => Type::int()
                ]
            ]);
        }
        return self::$instance;
    }
}
