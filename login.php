<?php

include "service/database.php";
session_start();

$db = Database::getConnection();

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

$login_message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash_password = hash("md5", $password);
    $sql = "SELECT * FROM pasien WHERE username=? AND password=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $username, $hash_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;
        header("location: dashboard.php");
        exit();
    } else {
        $login_message = "Akun tidak ditemukan";
    }
    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AyoSehat</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        .input-focus-effect:focus {
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.3); /* primary-500 */
        }
    </style>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html" ?>
    
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-md">
            <div class="bg-primary-600 py-4 px-6">
                <h1 class="text-2xl font-bold text-white text-center">
                    <i class="fas fa-heartbeat mr-2"></i> AyoSehat
                </h1>
            </div>
            
            <div class="p-8">
                <h2 class="text-2xl font-bold mb-6 text-center text-secondary-800">Masuk ke Akun Anda</h2>
                
                <?php if (!empty($login_message)): ?>
                    <div class="mb-6 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span class="font-medium"><?= htmlspecialchars($login_message) ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form action="login.php" method="POST" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-secondary-700 mb-1">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-secondary-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="username"
                                placeholder="Masukkan username" 
                                name="username"
                                class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                required
                            />
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-secondary-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-secondary-400"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password"
                                placeholder="Masukkan password" 
                                name="password"
                                class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                required
                            />
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="remember"
                                name="remember"
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded"
                            />
                            <label for="remember" class="ml-2 block text-sm text-secondary-700">Ingat saya</label>
                        </div>
                        <a href="#" class="text-sm text-primary-600 hover:underline">Lupa password?</a>
                    </div>
                    
                    <button 
                        type="submit" 
                        name="login"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-[1.01] shadow-md"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </button>
                </form>
                
                <div class="mt-6 text-center text-sm text-secondary-600">
                    <p>Belum punya akun? 
                        <a href="register.php" class="text-primary-600 font-medium hover:underline">Daftar sekarang</a>
                    </p>
                </div>
            </div>
            
            <div class="bg-secondary-50 px-6 py-4 rounded-b-xl">
                <div class="text-center text-xs text-secondary-500">
                    <p>© 2025 AyoSehat. All rights reserved.</p>
                </div>
            </div>
        </div>
    </main>
    
    <?php include "layout/footer.html" ?>
</body>
</html>