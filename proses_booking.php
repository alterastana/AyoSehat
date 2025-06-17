<?php
session_start();
require 'service/database.php';

// Validasi login
if (!isset($_SESSION['is_login']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Validasi input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dokter = $_POST['id_dokter'] ?? '';
    $waktu = $_POST['waktu'] ?? '';
    $user_id = $_SESSION['user_id'];

    if (empty($id_dokter) || empty($waktu)) {
        die("Data tidak lengkap.");
    }

    $conn = Database::getConnection();

    // Simpan booking
    $stmt = $conn->prepare("INSERT INTO booking (id_pasien, id_dokter, waktu, status) VALUES (?, ?, ?, 'menunggu konfirmasi')");
    $stmt->bind_param("iis", $user_id, $id_dokter, $waktu);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        header("Location: booking_detail.php?id=" . $booking_id);
        exit;
    } else {
        die("Gagal menyimpan booking: " . $stmt->error);
    }
} else {
    header("Location: booking.php");
    exit;
}
