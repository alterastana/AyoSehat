<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('location: login.php');
    exit();
}

include "service/database.php";
$db = Database::getConnection();

$username = $_SESSION['username'];

// Ambil id_pasien berdasarkan username
$sql_id = "SELECT id_pasien FROM pasien WHERE username = ?";
$stmt_id = $db->prepare($sql_id);
$stmt_id->bind_param("s", $username);
$stmt_id->execute();
$result_id = $stmt_id->get_result();
$user_data = $result_id->fetch_assoc();
$stmt_id->close();

$id_pasien = $user_data['id_pasien'];

// Ambil data appointment dan payment untuk notifikasi
$sql = "
SELECT 
    a.waktu, a.status AS status_appointment,
    p.status_bayar, p.metode_bayar
FROM 
    appointment a
LEFT JOIN 
    payment p ON a.appointment_id = p.appointment_id
WHERE 
    a.id_pasien = ?
ORDER BY 
    a.waktu DESC
";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id_pasien);
$stmt->execute();
$result = $stmt->get_result();

$notifikasi = [];
while ($row = $result->fetch_assoc()) {
    $waktu = date("d M Y H:i", strtotime($row['waktu']));
    $statusApp = $row['status_appointment'] ? "✅ Dikonfirmasi" : "⏳ Belum dikonfirmasi";
    $statusBayar = isset($row['status_bayar']) 
        ? ($row['status_bayar'] ? "💰 Sudah bayar" : "❌ Belum bayar") 
        : "⛔ Belum ada pembayaran";

    $notifikasi[] = "<strong>$waktu</strong>: $statusApp, $statusBayar.";
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - AyoSehat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html" ?>

    <main class="flex-1 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-2xl font-bold text-secondary-800 mb-4">Notifikasi</h2>
                <?php if (count($notifikasi) > 0): ?>
                    <ul class="list-disc list-inside space-y-2 text-secondary-700">
                        <?php foreach ($notifikasi as $n): ?>
                            <li><?= $n ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-secondary-500">Tidak ada notifikasi saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include "layout/footer.html" ?>
</body>
</html>
