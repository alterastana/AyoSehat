<?php

include "service/database.php";
session_start();

$db = Database::getConnection();

if (!isset($_SESSION["is_login"])) {
    header("location: login.php");
    exit();
}

// Logic untuk membuat appointment
if (isset($_POST['book_appointment'])) {
    $pasien_id = $_SESSION['id_pasien']; // Pastikan 'id_pasien' diset saat login
    $dokter_id = $_POST['id_dokter'];
    $waktu = $_POST['waktu'];

    try {
        $sql = "INSERT INTO appointment (id_pasien, id_dokter, waktu) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("iis", $pasien_id, $dokter_id, $waktu);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Appointment berhasil dibuat!</p>";
        } else {
            echo "<p style='color:red;'>Gagal membuat appointment. Silakan coba lagi.</p>";
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Appointment</title>
</head>
<body>
    <?php include "layout/header.html" ?>
    <main>
        <h1>Buat Appointment</h1>
        <form method="POST" action="booking.php">
            <label for="id_dokter">Pilih Dokter:</label>
            <select name="id_dokter" id="id_dokter" required>
            <?php
                // Fetch doctors from the database
                $sql = "SELECT id_dokter, nama_dokter FROM dokter";
                $result = $db->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_dokter'] . "'>" . $row['nama_dokter'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada dokter tersedia</option>";
                }
            ?>
            </select>
            <br><br>
            <label for="waktu">Pilih Tanggal:</label>
            <input type="date" name="waktu" id="waktu" required min="<?= date('YYYY-MM-DD') ?>">
            <br><br>
            <button type="submit" name="book_appointment">Buat Appointment</button>
        </form>
    </main>
    <?php include "layout/footer.html" ?>
</body>
</html>