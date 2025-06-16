<?php 

include "service/database.php";
session_start();

$db = Database::getConnection();

if (!isset($_SESSION["is_login"])) {
    header("location: login.php");
    exit();
}

$appointment = null;
$doctor = null;
$payment_success = false;

// Handle payment submission
if (isset($_POST['submit_payment'])) {
    $appointment_id = $_POST['appointment_id'];
    $metode_bayar = $_POST['metode_bayar'];
    
    try {
        // Update appointment status to paid (1)
        $sql = "UPDATE appointment SET status = 1 WHERE appointment_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $stmt->close();
        
        // Insert payment record
        $sql = "INSERT INTO payment (appointment_id, nominal_bayar, metode_bayar, status_bayar) 
                VALUES (?, ?, ?, 1)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("idi", $appointment_id, $_POST['nominal_bayar'], $metode_bayar);
        $stmt->execute();
        $stmt->close();
        
        $payment_success = true;
    } catch (mysqli_sql_exception $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}

// Get the latest unpaid appointment for the patient
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Konsultasi</title>
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .info-box {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .payment-form {
            margin-top: 20px;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php include "layout/header.html" ?>
    <main class="container">
        <h1>Pembayaran Konsultasi</h1>
        
        <?php if ($payment_success): ?>
            <div class="success-message">
                Pembayaran berhasil! Terima kasih telah menggunakan layanan kami.
            </div>
            <p>Anda dapat melihat detail appointment di halaman profil Anda.</p>
        <?php elseif ($appointment): ?>
            <div class="info-box">
                <h3>Detail Appointment</h3>
                <table>
                    <tr>
                        <th>Nama Dokter</th>
                        <td><?= htmlspecialchars($appointment['nama_dokter']) ?></td>
                    </tr>
                    <tr>
                        <th>Spesialisasi</th>
                        <td><?= htmlspecialchars($appointment['spesialisasi']) ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Konsultasi</th>
                        <td><?= date('d F Y H:i', strtotime($appointment['waktu'])) ?></td>
                    </tr>
                    <tr>
                        <th>Biaya Konsultasi</th>
                        <td>Rp <?= number_format($appointment['biaya_kosultas'], 0, ',', '.') ?></td>
                    </tr>
                </table>
            </div>

            <div class="payment-form">
                <h3>Form Pembayaran</h3>
                <form method="POST" action="pembayaran.php">
                    <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                    <input type="hidden" name="nominal_bayar" value="<?= $appointment['biaya_kosultas'] ?>">
                    
                    <label for="metode_bayar">Metode Pembayaran:</label><br>
                    <select name="metode_bayar" id="metode_bayar" required>
                        <option value="1">Transfer Bank</option>
                        <option value="2">E-Wallet</option>
                        <option value="3">Kartu Kredit/Debit</option>
                    </select><br><br>
                    
                    <button type="submit" name="submit_payment">Bayar Sekarang</button>
                </form>
            </div>
        <?php else: ?>
            <p>Anda belum memiliki appointment yang perlu dibayar.</p>
            <p>Silakan buat appointment terlebih dahulu di halaman <a href="booking.php">booking</a>.</p>
        <?php endif; ?>
    </main>
    <?php include "layout/footer.html" ?>
</body>
</html>