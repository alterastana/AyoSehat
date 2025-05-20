<?php 
include "service/database.php";
session_start();

$db = Database::getConnection(); // Inisialisasi koneksi database

$register_message = "";

if(isset($_SESSION["is_login"])){
    header("location: dashboard.php");
    exit();
}

if(isset($_POST["register"])){
    $username = $_POST["username"];
    $nama = $_POST["nama_pasien"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    $hash_password = hash("md5", $password);

    try {
        $sql = "INSERT INTO pasien (username, nama_pasien, email, no_telepon, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssis", $username, $nama, $email, $no_hp, $hash_password);

        if($stmt->execute()){
            $register_message = "Registrasi Berhasil, silakan <a href='login.php' class='text-blue-600 underline'>login</a>";
        } else {
            $register_message = "Registrasi gagal, silakan ulangi kembali";
        }
        $stmt->close();
    } catch(mysqli_sql_exception $e){
        $register_message = $e->getMessage();
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register AyoSehat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include "layout/header.html" ?>
    <div class="flex flex-1 items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-slate-800">Register AyoSehat</h2>
            <?php if (!empty($register_message)): ?>
                <div class="mb-4 text-center font-semibold text-blue-700">
                    <?= $register_message ?>
                </div>
            <?php endif; ?>
            <form action="register.php" method="POST" class="space-y-4">
                <input type="text" placeholder="Username" name="username" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                <input type="text" placeholder="Nama" name="nama_pasien" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                <input type="email" placeholder="E-mail" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                <input type="number" placeholder="Nomor Handphone" name="no_hp" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                <input type="password" placeholder="Password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                <button type="submit" name="register" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Daftar</button>
            </form>
            <div class="text-center mt-4 text-sm">
                Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline">Login di sini</a>
            </div>
        </div>
    </div>
    <?php include "layout/footer.html" ?>
</body>
</html>