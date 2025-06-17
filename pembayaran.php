<?php 
include "service/database.php";
session_start();

$db = Database::getConnection();

if (!isset($_SESSION["is_login"])) {
    header("location: login.php");
    exit();
}

$appointment = null;
$payment_success = false;

// Handle payment submission
if (isset($_POST['submit_payment'])) {
    $appointment_id = $_POST['appointment_id'];
    $metode_bayar = $_POST['metode_bayar'];
    $nominal_bayar = $_POST['nominal_bayar'];

    try {
        // Update appointment status
        $sql = "UPDATE appointment SET status = 1 WHERE appointment_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $stmt->close();

        // Insert payment
        $sql = "INSERT INTO payment (appointment_id, nominal_bayar, metode_bayar, status_bayar) 
                VALUES (?, ?, ?, 1)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("idi", $appointment_id, $nominal_bayar, $metode_bayar);
        $stmt->execute();
        $stmt->close();

        $payment_success = true;
    } catch (mysqli_sql_exception $e) {
        echo "<p class='text-red-600'>Error: " . $e->getMessage() . "</p>";
    }
}

// Fetch latest unpaid appointment
$sql = "SELECT a.*, d.nama_dokter, d.spesialisasi, d.biaya_konsultasi 
        FROM appointment a
        JOIN dokter d ON a.id_dokter = d.id_dokter
        WHERE a.id_pasien = ? AND a.status = 0
        ORDER BY a.tanggal_pesan DESC
        LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_pasien']);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $appointment = $result->fetch_assoc();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Konsultasi - AyoSehat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
      tailwind.config = {
        theme: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          extend: {
            colors: {
              primary: {
                500: '#14b8a6',
                600: '#0d9488',
                700: '#0f766e',
              },
              secondary: {
                100: '#f1f5f9',
                700: '#334155',
              }
            }
          }
        }
      }
    </script>
</head>
<body class="bg-secondary-100 font-sans min-h-screen flex flex-col">
    <?php include "layout/header.html"; ?>

    <main class="flex-1">
        <div class="max-w-4xl mx-auto px-6 py-12">
            <h1 class="text-3xl font-bold text-primary-700 mb-6">Pembayaran Konsultasi</h1>

            <?php if ($payment_success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    Pembayaran berhasil! Terima kasih telah menggunakan layanan kami.
                    <p class="mt-2">Lihat detail appointment Anda di halaman <a href="dashboard.php" class="text-primary-600 underline">Profil</a>.</p>
                </div>
            <?php elseif ($appointment): ?>
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4 text-primary-700">Detail Appointment</h2>
                    <table class="w-full text-left border border-gray-200">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-secondary-100">Nama Dokter</th>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['nama_dokter']) ?></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-secondary-100">Spesialisasi</th>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['spesialisasi']) ?></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-secondary-100">Tanggal</th>
                                <td class="px-4 py-2"><?= date('d F Y', strtotime($appointment['waktu'])) ?></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-secondary-100">Jam</th>
                                <td class="px-4 py-2"><?= htmlspecialchars(date('H:i', strtotime($appointment['jam'] ?? '00:00:00'))) ?></td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 bg-secondary-100">Biaya Konsultasi</th>
                                <td class="px-4 py-2">Rp <?= number_format($appointment['biaya_konsultasi'] ?? 0, 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-primary-700">Form Pembayaran</h2>
                    <form method="POST" action="pembayaran.php" class="space-y-4">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                        <input type="hidden" name="nominal_bayar" value="<?= $appointment['biaya_konsultasi'] ?>">

                        <div>
                            <label for="metode_bayar" class="block mb-2 font-medium text-secondary-700">Metode Pembayaran</label>
                            <select name="metode_bayar" id="metode_bayar" class="w-full border rounded px-4 py-3" required>
                                <option value="1">Transfer Bank</option>
                                <option value="2">E-Wallet</option>
                                <option value="3">Kartu Kredit/Debit</option>
                            </select>
                        </div>

                        <button type="submit" name="submit_payment"
                                class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-lg transition-all w-full">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="bg-white p-6 rounded-xl shadow text-secondary-700">
                    <p class="mb-2">Anda belum memiliki appointment yang perlu dibayar.</p>
                    <p>Silakan buat appointment terlebih dahulu di halaman <a href="booking.php" class="text-primary-600 underline">Booking</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include "layout/footer.html"; ?>
</body>
</html>
