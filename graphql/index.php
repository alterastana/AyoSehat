<?php

require_once __DIR__ . '/../vendor/autoload.php';  // Autoload composer
require_once __DIR__ . '/../service/database.php'; // Tambahkan ini!
require_once __DIR__ . '/schema.php';              // Skema GraphQL utama

use GraphQL\GraphQL;
use GraphQL\Error\DebugFlag;
use GraphQL\Error\FormattedError;

// Set header agar GraphQL menerima dan mengembalikan JSON
header('Content-Type: application/json');

// Ambil input dari request (POST JSON)
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

// Validasi input
$query = isset($input['query']) ? $input['query'] : null;
$variableValues = isset($input['variables']) ? $input['variables'] : null;
$operationName = isset($input['operationName']) ? $input['operationName'] : null;

try {
    // Buat context berisi koneksi database
    $context = [
        'db' => \Database::getConnection()
    ];

    // Jalankan query
    $result = GraphQL::executeQuery(
        $schema,
        $query,
        null,
        $context, // <-- kirim context ke resolver
        $variableValues,
        $operationName
    );

    $output = $result->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE);
} catch (\Exception $e) {
    http_response_code(500);
    $output = [
        'errors' => [
            FormattedError::createFromException($e)
        ]
    ];
}

// Tampilkan hasilnya sebagai JSON
echo json_encode($output);