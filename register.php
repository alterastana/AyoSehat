<?php 
include "service/database.php";
session_start();

$db = Database::getConnection();
$register_message = "";

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

if (isset($_POST["register"])) {
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

        if ($stmt->execute()) {
            $register_message = "Registrasi berhasil, silakan <a href='login.php' class='text-teal-700 underline'>login</a>";
        } else {
            $register_message = "Registrasi gagal, silakan ulangi kembali";
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        $register_message = $e->getMessage();
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar AyoSehat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<?php include "layout/header.html" ?>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex flex-1 items-center justify-center py-10">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg">
            <!-- Header -->
            <div class="bg-teal-700 rounded-t-lg px-6 py-4 text-center">
                <h1 class="text-white text-2xl font-bold"><i class="fas fa-heart-pulse mr-2"></i> AyoSehat</h1>
            </div>

            <!-- Form -->
            <div class="px-8 py-6">
                <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">Buat Akun Anda</h2>

                <?php if (!empty($register_message)): ?>
                    <div class="mb-4 text-center font-medium text-sm text-green-700">
                        <?= $register_message ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="register.php" class="space-y-4">
                    <!-- Username -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Username</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa fa-user"></i></span>
                            <input type="text" name="username" placeholder="Masukkan username" required
                                class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa fa-id-card"></i></span>
                            <input type="text" name="nama_pasien" placeholder="Masukkan nama" required
                                class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Email</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" placeholder="Masukkan email" required
                                class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">No. HP</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa fa-phone"></i></span>
                            <input type="number" name="no_hp" placeholder="Masukkan nomor HP" required
                                class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Password</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" placeholder="Masukkan password" required
                                class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Tombol -->
                    <button type="submit" name="register"
                        class="w-full bg-teal-700 hover:bg-teal-800 text-white font-semibold py-2 px-4 rounded transition inline-flex justify-center items-center">
                        <i class="fa fa-user-plus mr-2"></i> Daftar
                    </button>
                </form>

                <!-- Link ke login -->
                <p class="text-center text-sm mt-4 text-gray-600">
                    Sudah punya akun? <a href="login.php" class="text-teal-700 font-medium hover:underline">Login sekarang</a>
                </p>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 text-center text-xs text-gray-500 py-3 rounded-b-lg">
                © 2025 AyoSehat. All rights reserved.
            </div>
        </div>
    </div>
       <?php include "layout/footer.html"; ?>
</body>
</html>

