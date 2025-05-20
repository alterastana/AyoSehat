<?php
require_once __DIR__ . '/helper.php';

// Set header agar response berupa JSON
header('Content-Type: application/json');

// Ambil method dan data dari request
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && isset($_GET['id_pasien'])) {
    // Panggil getAppointments
    $result = AppointmentResolver::getAppointments(null, ['id_pasien' => $_GET['id_pasien']], null);
    echo json_encode($result);
} elseif ($method === 'POST') {
    // Ambil data dari body (JSON)
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['id_pasien'], $input['id_dokter'], $input['waktu'])) {
        $result = AppointmentResolver::createAppointment(
            null,
            [
                'id_pasien' => $input['id_pasien'],
                'id_dokter' => $input['id_dokter'],
                'waktu' => $input['waktu']
            ],
            null
        );
        echo json_encode(['insert_id' => $result]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}