<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('location: login.php');
    exit();
}

include "service/database.php";
$db = Database::getConnection();

$username = $_SESSION['username'];

// Ambil informasi pasien
$sql_pasien = "SELECT id_pasien, nama_pasien FROM pasien WHERE username = ?";
$stmt = $db->prepare($sql_pasien);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$pasien = $result->fetch_assoc();
$stmt->close();

$appointment = null;
if ($pasien) {
    $sql = "SELECT a.*, d.nama_dokter, d.spesialis 
            FROM appointment a 
            JOIN dokter d ON a.id_dokter = d.id_dokter 
            WHERE a.id_pasien = ? 
            ORDER BY a.appointment_id DESC LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $pasien['id_pasien']);
    $stmt->execute();
    $appointment = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

function getStatusText($status) {
    switch ($status) {
        case 0: return "Menunggu Konfirmasi";
        case 1: return "Disetujui";
        case 2: return "Ditolak";
        default: return "Tidak Diketahui";
    }
}

function getStatusColor($status) {
    switch ($status) {
        case 0: return "bg-yellow-400";
        case 1: return "bg-green-500";
        case 2: return "bg-red-500";
        default: return "bg-gray-400";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Booking - AyoSehat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="max-w-2xl mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Detail Booking Terakhir</h1>

        <?php if ($appointment): ?>
            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <div>
                    <strong>Nama Dokter:</strong> <?= htmlspecialchars($appointment['nama_dokter']) ?>
                </div>
                <div>
                    <strong>Spesialis:</strong> <?= htmlspecialchars($appointment['spesialis']) ?>
                </div>
                <div>
                    <strong>Jadwal:</strong> <?= date("d M Y, H:i", strtotime($appointment['waktu'])) ?>
                </div>
                <div>
                    <strong>Status:</strong>
                    <span class="inline-block px-3 py-1 text-white rounded <?= getStatusColor($appointment['status']) ?>">
                        <?= getStatusText($appointment['status']) ?>
                    </span>
                </div>

                <?php if ($appointment['status'] == 1): ?>
                    <form action="pembayaran.php" method="get">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                <?php elseif ($appointment['status'] == 0): ?>
                    <p class="text-yellow-600">Silakan tunggu konfirmasi dari pihak klinik.</p>
                <?php elseif ($appointment['status'] == 2): ?>
                    <p class="text-red-600">Mohon maaf, booking Anda ditolak. Silakan coba lagi.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">Belum ada data booking.</p>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <a href="dashboard.php" class="text-blue-600 hover:underline">← Kembali ke Dashboard</a>
        </div>
    </div>

</body>
</html>
