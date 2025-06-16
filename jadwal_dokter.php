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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Dokter - AyoSehat</title>
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
        .btn-primary {
            transition: all 0.3s ease;
            background-image: linear-gradient(to right, #0d9488, #14b8a6);
        }
        .btn-primary:hover {
            background-image: linear-gradient(to right, #0f766e, #0d9488);
            transform: translateY(-2px);
        }
        .doctor-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 2rem 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }
        .doctor-table thead tr {
            background: linear-gradient(to right, #0d9488, #14b8a6);
            color: white;
            text-align: left;
        }
        .doctor-table th,
        .doctor-table td {
            padding: 1rem 1.5rem;
        }
        .doctor-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }
        .doctor-table tbody tr {
            transition: all 0.2s ease;
            background-color: white;
        }
        .doctor-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .doctor-table tbody tr:hover {
            background-color: #f0fdfa;
            transform: translateX(4px);
        }
        .doctor-table td {
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        .doctor-table td:first-child {
            font-weight: 600;
            color: #0f172a;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-primary {
            background-color: #ccfbf1;
            color: #0d9488;
        }
    </style>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html"; ?>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Page Header -->
            <div class="text-center mb-12 animate__animated animate__fadeIn">
                <h1 class="text-4xl font-extrabold text-primary-800 mb-4 animate__animated animate__fadeInDown">
                    Jadwal Dokter
                </h1>
                <p class="text-xl text-secondary-600 animate__animated animate__fadeInUp animate__delay-1s">
                    Temukan jadwal praktik dokter spesialis kami
                </p>
            </div>

            <!-- Doctor Schedule Table -->
            <div class="bg-white rounded-xl smooth-shadow overflow-hidden animate__animated animate__fadeIn animate__delay-1s">
                <table class="w-full doctor-table">
                    <thead>
                        <tr>
                            <th class="text-left py-4 px-6">Nama Dokter</th>
                            <th class="text-left py-4 px-6">Spesialisasi</th>
                            <th class="text-center py-4 px-6">Biaya Konsultasi</th>
                            <th class="text-center py-4 px-6">Jadwal Praktik</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-primary-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-secondary-900"><?= htmlspecialchars($row['nama_dokter']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge badge-primary"><?= htmlspecialchars($row['spesialisasi']) ?></span>
                            </td>
                            <td class="py-4 px-6 text-center text-secondary-700">
                                Rp <?= number_format($row['biaya_konsultasi'], 0, ',', '.') ?>
                            </td>
                            <td class="py-4 px-6 text-center text-secondary-700">
                                <?= htmlspecialchars($row['jadwal']) ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- CTA Section -->
            <div class="mt-12 text-center animate__animated animate__fadeInUp">
                <a href="booking.php" class="inline-flex items-center btn-primary text-white font-medium rounded-lg px-6 py-3">
                    Buat Janji Konsultasi
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </main>

    <?php include "layout/footer.html"; ?>
</body>
</html>