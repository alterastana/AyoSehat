<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('location: login.php');
    exit();
}

include "service/database.php";
$db = Database::getConnection();

// Get user data from database
$username = $_SESSION['username'];
$sql = "SELECT username, nama_pasien, email, no_telepon FROM pasien WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AyoSehat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'fade-in-down': 'fadeInDown 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
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
        .nav-item {
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            transform: translateX(5px);
        }
        .btn-primary {
            transition: all 0.3s ease;
            background-image: linear-gradient(to right, #0d9488, #14b8a6);
        }
        .btn-primary:hover {
            background-image: linear-gradient(to right, #0f766e, #0d9488);
            transform: translateY(-2px);
        }
        .btn-logout {
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -2px rgba(239, 68, 68, 0.3);
        }
        /* Styling untuk tabel */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .styled-table th, .styled-table td {
            padding: 12px 15px;
        }

        .styled-table th {
            background-color: #009879;
            color: #ffffff;
            text-align: center;
        }

        .styled-table tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        .styled-table tr:hover {
            background-color: #f1f1f1;
        }
        
    </style>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html" ?>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Logout Button Atas -->
            <div class="flex justify-end mb-6">
                <form action="dashboard.php" method="POST">
                    <button type="submit" name="logout" class="btn-logout bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                        Logout
                    </button>
                </form>
            </div>
            <!-- Welcome Section -->
            <div class="text-center mb-16 animate__animated animate__fadeIn">
                <h1 class="text-5xl font-extrabold text-primary-800 mb-4 animate__animated animate__fadeInDown">
                    Welcome Back, <span class="text-primary-600"><?= htmlspecialchars($user['nama_pasien']) ?></span>!
                </h1>
                <p class="text-xl text-secondary-600 max-w-2xl mx-auto animate__animated animate__fadeInUp animate__delay-1s">
                    Manage your health journey with our comprehensive healthcare services
                </p>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeIn animate__delay-1s">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl p-6 smooth-shadow card-hover">
                    <div class="flex items-center mb-6">
                        <div class="bg-primary-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-secondary-800">Profile</h2>
                    </div>
                    <div class="space-y-4 text-secondary-600">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Username</span>&nbsp; <?= htmlspecialchars($user['username']) ?>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span class="font-medium">Email</span>&nbsp; <?= htmlspecialchars($user['email']) ?>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span class="font-medium">Phone</span>&nbsp; <?= htmlspecialchars($user['no_telepon']) ?>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="edit_profil.php" class="inline-flex items-center btn-primary text-white font-medium rounded-lg px-5 py-2.5">
                            Edit Profile
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 smooth-shadow card-hover">
                    <div class="flex items-center mb-6">
                        <div class="bg-primary-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-secondary-800">Quick Actions</h2>
                    </div>
                    <div class="space-y-4">
                        <a href="jadwal_dokter.php" class="flex items-center nav-item p-3 rounded-lg hover:bg-primary-50 text-secondary-700 hover:text-primary-700">
                            <div class="bg-primary-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Doctor Schedule</h3>
                                <p class="text-sm text-secondary-500">View available doctor schedules</p>
                            </div>
                        </a>
                        <a href="booking.php" class="flex items-center nav-item p-3 rounded-lg hover:bg-primary-50 text-secondary-700 hover:text-primary-700">
                            <div class="bg-primary-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Book Consultation</h3>
                                <p class="text-sm text-secondary-500">Schedule an appointment</p>
                            </div>
                        </a>
                        <a href="pembayaran.php" class="flex items-center nav-item p-3 rounded-lg hover:bg-primary-50 text-secondary-700 hover:text-primary-700">
                            <div class="bg-primary-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Payments</h3>
                                <p class="text-sm text-secondary-500">Manage your payments</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Health Status -->
                <div class="bg-white rounded-xl p-6 smooth-shadow card-hover">
                    <div class="flex items-center mb-6">
                        <div class="bg-primary-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-secondary-800">Health Status</h2>
                    </div>
                    <div class="animate-pulse-slow text-center py-8">
                        <div class="inline-block animate-float">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-secondary-800 mt-4">Good Health</h3>
                        <p class="text-secondary-500 mt-2">No upcoming appointments</p>
                    </div>
                    <div class="mt-4">
                        <a href="notifikasi.php" class="w-full flex items-center justify-between p-3 rounded-lg bg-secondary-50 hover:bg-secondary-100 text-secondary-700">
                            <span>View Notifications</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "layout/footer.html" ?>
</body>
</html>