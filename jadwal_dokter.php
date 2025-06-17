<?php 
include "service/database.php";
session_start();

$db = Database::getConnection();

if (!isset($_SESSION["is_login"])) {
    header("location: login.php");
    exit();
}

$sql = "SELECT 
          d.id_dokter,
          d.nama_dokter,
          d.spesialisasi,
          d.biaya_konsultasi,
          GROUP_CONCAT(CONCAT(j.hari, ' (', TIME_FORMAT(j.jam_mulai, '%H:%i'), '-', TIME_FORMAT(j.jam_selesai, '%H:%i'), ')') 
                       ORDER BY FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') 
                       SEPARATOR ', ') AS jadwal
        FROM dokter d
        LEFT JOIN jadwal_praktik j ON d.id_dokter = j.id_dokter
        GROUP BY d.id_dokter";

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
        }
      }
    }
  </script>
  <style>
    .doctor-table th,
    .doctor-table td {
      padding: 1rem 1.5rem;
    }
    .doctor-table thead {
      background: linear-gradient(to right, #0d9488, #14b8a6);
      color: white;
    }
    .doctor-table tbody tr:nth-child(even) {
      background-color: #f8fafc;
    }
    .doctor-table tbody tr:hover {
      background-color: #f0fdfa;
    }
    .badge-primary {
      background-color: #ccfbf1;
      color: #0d9488;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
    }
  </style>
</head>
<body class="bg-secondary-100 min-h-screen font-sans">
  <?php include "layout/header.html"; ?>

  <main class="flex-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="text-center mb-12 animate__animated animate__fadeIn">
        <h1 class="text-4xl font-extrabold text-primary-800 mb-4">Jadwal Dokter</h1>
        <p class="text-xl text-secondary-600">Temukan jadwal praktik dokter spesialis kami</p>
      </div>

      <div class="bg-white rounded-xl overflow-hidden shadow-lg animate__animated animate__fadeIn animate__delay-1s">
        <table class="w-full doctor-table">
          <thead>
            <tr>
              <th>Nama Dokter</th>
              <th>Spesialisasi</th>
              <th class="text-center">Biaya Konsultasi</th>
              <th class="text-center">Jadwal Praktik</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td>
                  <div class="font-medium text-secondary-900"><?= htmlspecialchars($row['nama_dokter'] ?? 'Tidak diketahui') ?></div>
                </td>
                <td>
                  <span class="badge-primary"><?= htmlspecialchars($row['spesialisasi'] ?? 'Umum') ?></span>
                </td>
                <td class="text-center text-secondary-700">
                  Rp <?= number_format($row['biaya_konsultasi'] ?? 0, 0, ',', '.') ?>
                </td>
                <td class="text-center text-secondary-700">
<?= $row['jadwal'] ? htmlspecialchars($row['jadwal']) : '<span class="text-sm text-gray-400 italic">Belum tersedia</span>' ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="mt-12 text-center">
        <a href="booking.php" class="inline-flex items-center btn-primary text-white font-medium rounded-lg px-6 py-3 bg-primary-600 hover:bg-primary-700">
          Buat Janji Konsultasi
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </a>
      </div>
    </div>
  </main>

  <?php include "layout/footer.html"; ?>
</body>
</html>
