<?php 
include "service/database.php";
session_start();

if(!isset($_SESSION["is_login"])) {
    header("location: login.php");
    exit();
}

$db = Database::getConnection();
$username = $_SESSION['username'];

// Get current user data
$sql = "SELECT * FROM pasien WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$error_message = "";
$success_message = "";

if (isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $nama_pasien = $_POST['nama_pasien'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format email tidak valid";
    } 
    // Check if username is changed and exists
    elseif ($new_username != $username) {
        $check_sql = "SELECT username FROM pasien WHERE username = ?";
        $check_stmt = $db->prepare($check_sql);
        $check_stmt->bind_param("s", $new_username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error_message = "Username sudah digunakan";
        }
        $check_stmt->close();
    }
    // Check if password fields are filled
    elseif (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
        // Verify current password if trying to change password
        $current_password_hash = hash("md5", $current_password);
        if ($current_password_hash != $user['password']) {
            $error_message = "Password saat ini salah";
        } 
        // Check if new passwords match
        elseif ($new_password != $confirm_password) {
            $error_message = "Password baru tidak cocok";
        }
    }

    // If no errors, proceed with update
    if (empty($error_message)) {
        // Determine which fields to update
        $update_fields = array();
        $params = array();
        $types = "";
        
        // Check each field for changes
        if ($new_username != $user['username']) {
            $update_fields[] = "username=?";
            $params[] = $new_username;
            $types .= "s";
        }
        
        if ($nama_pasien != $user['nama_pasien']) {
            $update_fields[] = "nama_pasien=?";
            $params[] = $nama_pasien;
            $types .= "s";
        }
        
        if ($email != $user['email']) {
            $update_fields[] = "email=?";
            $params[] = $email;
            $types .= "s";
        }
        
        if ($no_telepon != $user['no_telepon']) {
            $update_fields[] = "no_telepon=?";
            $params[] = $no_telepon;
            $types .= "s";
        }
        
        // Handle password change if provided
        if (!empty($new_password)) {
            $new_password_hash = hash("md5", $new_password);
            $update_fields[] = "password=?";
            $params[] = $new_password_hash;
            $types .= "s";
        }
        
        // Only update if there are changes
        if (!empty($update_fields)) {
            $sql = "UPDATE pasien SET " . implode(", ", $update_fields) . " WHERE username=?";
            $params[] = $username;
            $types .= "s";
            
            $stmt = $db->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $success_message = "Profil berhasil diperbarui";
                
                // Update session if username changed
                if ($new_username != $username) {
                    $_SESSION['username'] = $new_username;
                    $username = $new_username;
                }
                
                // Refresh user data
                $sql = "SELECT * FROM pasien WHERE username = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            } else {
                $error_message = "Gagal memperbarui profil";
            }
            $stmt->close();
        } else {
            $error_message = "Tidak ada perubahan yang dilakukan";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - AyoSehat</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.3);
        }
        .smooth-shadow {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html" ?>
    
    <main class="flex-1 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl smooth-shadow card-hover overflow-hidden">
                <div class="bg-primary-600 py-4 px-6">
                    <h1 class="text-2xl font-bold text-white">
                        <i class="fas fa-user-edit mr-2"></i> Edit Profil
                    </h1>
                </div>
                
                <div class="p-8">
                    <?php if (!empty($error_message)): ?>
                        <div class="mb-6 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-medium"><?= htmlspecialchars($error_message) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success_message)): ?>
                        <div class="mb-6 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span class="font-medium"><?= htmlspecialchars($success_message) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form action="edit_profil.php" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-secondary-700 mb-1">Username</label>
                                <input 
                                    type="text" 
                                    id="username"
                                    name="username"
                                    value="<?= htmlspecialchars($user['username']) ?>" 
                                    class="w-full px-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                    required
                                />
                            </div>
                            
                            <div>
                                <label for="nama_pasien" class="block text-sm font-medium text-secondary-700 mb-1">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    id="nama_pasien"
                                    name="nama_pasien"
                                    placeholder="Masukkan nama lengkap" 
                                    value="<?= htmlspecialchars($user['nama_pasien']) ?>" 
                                    class="w-full px-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                    required
                                />
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-secondary-700 mb-1">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-secondary-400"></i>
                                    </div>
                                    <input 
                                        type="email" 
                                        id="email"
                                        name="email"
                                        placeholder="Masukkan email" 
                                        value="<?= htmlspecialchars($user['email']) ?>" 
                                        class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                        required
                                    />
                                </div>
                            </div>
                            
                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-secondary-700 mb-1">Nomor Telepon</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-secondary-400"></i>
                                    </div>
                                    <input 
                                        type="tel" 
                                        id="no_telepon"
                                        name="no_telepon"
                                        placeholder="Masukkan nomor telepon" 
                                        value="<?= htmlspecialchars($user['no_telepon']) ?>" 
                                        class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-secondary-200 pt-6">
                            <h3 class="text-lg font-medium text-secondary-800 mb-4">Ubah Password</h3>
                            <p class="text-sm text-secondary-500 mb-4">Biarkan kosong jika tidak ingin mengubah password</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-secondary-700 mb-1">Password Saat Ini</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-secondary-400"></i>
                                        </div>
                                        <input 
                                            type="password" 
                                            id="current_password"
                                            name="current_password"
                                            placeholder="Masukkan password saat ini" 
                                            class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                        />
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-secondary-700 mb-1">Password Baru</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-lock text-secondary-400"></i>
                                            </div>
                                            <input 
                                                type="password" 
                                                id="new_password"
                                                name="new_password"
                                                placeholder="Masukkan password baru" 
                                                class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                            />
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="confirm_password" class="block text-sm font-medium text-secondary-700 mb-1">Konfirmasi Password Baru</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-lock text-secondary-400"></i>
                                            </div>
                                            <input 
                                                type="password" 
                                                id="confirm_password"
                                                name="confirm_password"
                                                placeholder="Konfirmasi password baru" 
                                                class="w-full pl-10 pr-4 py-3 border border-secondary-300 rounded-lg input-focus-effect focus:outline-none focus:border-primary-500 transition"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="dashboard.php" class="px-6 py-3 border border-secondary-300 text-secondary-700 font-medium rounded-lg hover:bg-secondary-50 transition">
                                Batal
                            </a>
                            <button 
                                type="submit" 
                                name="update"
                                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition duration-300 shadow-md"
                            >
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php include "layout/footer.html" ?>
</body>
</html>