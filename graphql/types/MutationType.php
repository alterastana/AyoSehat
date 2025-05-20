<?php


namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Types\PasienType;

// Tidak perlu require PasienType.php jika sudah autoload Composer
require_once __DIR__ . '/../../service/database.php';

class MutationType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'registerPasien' => [
                    'type' => PasienType::getInstance(),
                    'args' => [
                        'username' => Type::nonNull(Type::string()),
                        'password' => Type::nonNull(Type::string()),
                        'nama_pasien' => Type::nonNull(Type::string()),
                        'email' => Type::nonNull(Type::string()),
                        'no_telepon' => Type::nonNull(Type::int())
                    ],
                    'resolve' => function ($root, $args, $context) {
                        $conn = $context['db'];
                        $query = "INSERT INTO pasien (username, password, nama_pasien, email, no_telepon)
                                  VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ssssi", $args['username'], $args['password'], $args['nama_pasien'], $args['email'], $args['no_telepon']);
                        $stmt->execute();

                        return [
                            'id_pasien' => $conn->insert_id,
                            'username' => $args['username'],
                            'password' => $args['password'],
                            'nama_pasien' => $args['nama_pasien'],
                            'email' => $args['email'],
                            'no_telepon' => $args['no_telepon']
                        ];
                    }
                ]
            ]
        ]);
    }
}