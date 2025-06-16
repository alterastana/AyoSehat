<?php 

include "service/database.php";
session_start();

$db = Database::getConnection();

if (!isset($_SESSION["is_login"])) {
    header("location: login.php");
    exit();
}
$sql = "SELECT * FROM dokter";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "layout/header.html" ?>
    <table border = 1>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Spesialisasi</th>
            <th>Biaya</th>
            <th>Jadwal</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
        <td><?= $row['id_dokter']; ?></td>
            <td><?= $row['nama_dokter']; ?></td>
            <td><?= $row['spesialisasi']; ?></td>
            <td><?= $row['biaya_konsultasi']; ?></td>
            <td><?= $row['jadwal']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <main>
    </main>
    <?php include "layout/footer.html" ?>
</body>
</html>