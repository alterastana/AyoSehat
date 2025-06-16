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
            $success_message = "Appointment berhasil dibuat!";
        } else {
            $error_message = "Gagal membuat appointment. Silakan coba lagi.";
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Janji - AyoSehat</title>
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
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        .form-input:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2);
        }
    </style>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html"; ?>

    <main class="flex-1">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Page Header -->
            <div class="text-center mb-12 animate__animated animate__fadeIn">
                <h1 class="text-4xl font-extrabold text-primary-800 mb-4 animate__animated animate__fadeInDown">
                    Buat Janji Konsultasi
                </h1>
                <p class="text-xl text-secondary-600 animate__animated animate__fadeInUp animate__delay-1s">
                    Pilih dokter dan waktu yang sesuai untuk kebutuhan Anda
                </p>
            </div>

            <!-- Success/Error Messages -->
            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 animate__animated animate__fadeIn">
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 animate__animated animate__fadeIn">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <!-- Booking Form -->
            <div class="bg-white rounded-xl p-8 smooth-shadow animate__animated animate__fadeIn animate__delay-1s">
                <form method="POST" action="booking.php" class="space-y-6">
                    <div>
                        <label for="id_dokter" class="block text-sm font-medium text-secondary-700 mb-2">Pilih Dokter</label>
                        <select name="id_dokter" id="id_dokter" required
                                class="form-input w-full px-4 py-3 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <?php
                                // Fetch doctors from the database
                                $sql = "SELECT id_dokter, nama_dokter, spesialisasi FROM dokter";
                                $result = $db->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['id_dokter']) . "'>" . 
                                             htmlspecialchars($row['nama_dokter']) . " - " . 
                                             htmlspecialchars($row['spesialisasi']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada dokter tersedia</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="waktu" class="block text-sm font-medium text-secondary-700 mb-2">Pilih Tanggal</label>
                        <input type="date" name="waktu" id="waktu" required 
                               min="<?= date('Y-m-d') ?>" 
                               class="form-input w-full px-4 py-3 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div class="pt-4">
                        <button type="submit" name="book_appointment" 
                                class="btn-primary text-white font-medium rounded-lg px-6 py-3 w-full transition duration-300">
                            Buat Janji
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 bg-primary-50 rounded-xl p-6 smooth-shadow animate__animated animate__fadeInUp">
                <div class="flex items-start">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-primary-800 mb-2">Informasi Penting</h3>
                        <ul class="list-disc pl-5 space-y-1 text-secondary-700">
                            <li>Pastikan Anda memilih tanggal yang sesuai dengan jadwal dokter</li>
                            <li>Anda akan menerima konfirmasi melalui email setelah membuat janji</li>
                            <li>Batalkan atau ubah janji minimal 24 jam sebelum waktu konsultasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "layout/footer.html"; ?>
</body>
</html>