<?php
include "service/database.php";

if (isset($_GET['id_dokter']) && isset($_GET['tanggal'])) {
    $id_dokter = intval($_GET['id_dokter']);
    $tanggal = $_GET['tanggal'];

    // Ubah nama hari dari bahasa Inggris ke Indonesia
    $hariInggris = date('l', strtotime($tanggal)); // Monday, Tuesday, ...
    $hariIndonesiaMap = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu'
    ];
    $hari = $hariIndonesiaMap[$hariInggris] ?? '';

    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT jam_mulai, jam_selesai FROM jadwal_praktik WHERE id_dokter = ? AND hari = ?");
    $stmt->bind_param("is", $id_dokter, $hari);
    $stmt->execute();
    $result = $stmt->get_result();

    $jamList = [];

    while ($row = $result->fetch_assoc()) {
        $start = strtotime($row['jam_mulai']);
        $end   = strtotime($row['jam_selesai']);

        // Tambahkan slot 30 menit sekali
        for ($t = $start; $t < $end; $t += 1800) {
            $jamList[] = date("H:i", $t);
        }
    }

    // Keluarkan dalam bentuk JSON
    header('Content-Type: application/json');
    echo json_encode($jamList);
    exit();
}

// Jika tidak valid
http_response_code(400);
echo json_encode(["error" => "Parameter tidak lengkap."]);
