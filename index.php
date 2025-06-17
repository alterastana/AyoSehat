<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AyoSehat - Booking Konsultasi Dokter Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #0e7b74 0%, #139f91 100%);

        }
        
        .doctor-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .doctor-icon {
            transition: all 0.3s ease;
        }
        
        .doctor-card:hover .doctor-icon {
            transform: scale(1.1);
            background-color: #2e8b57;
            color: white;
        }
        
        .specialty-card {
            transition: all 0.3s ease;
        }
        
        .specialty-card:hover {
            transform: translateY(-3px);
        }
        
        .feature-card {
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
<?php include "layout/header.html" ?>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="hero-section text-white py-20 md:py-28">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">Konsultasi dengan Dokter Spesialis<br>Lebih Mudah dan Nyaman</h1>
                <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto opacity-90">Booking janji temu online dengan dokter berpengalaman kapan saja, di mana saja</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="booking.php" class="btn-primary bg-white text-green-700 hover:bg-gray-100 font-bold py-4 px-10 rounded-full text-lg inline-flex items-center justify-center">
                        <i class="fas fa-calendar-check mr-2"></i> Booking Sekarang
                    </a>
                    <a href="doctors.php" class="btn-primary bg-transparent border-2 border-white text-white hover:bg-white hover:text-green-700 font-bold py-4 px-10 rounded-full text-lg inline-flex items-center justify-center">
                        <i class="fas fa-user-md mr-2"></i> Lihat Dokter
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-3">MENGAPA MEMILIH KAMI</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Layanan Kesehatan Terbaik untuk Anda</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Kami memberikan pengalaman konsultasi dokter yang lebih baik dengan teknologi terkini</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="feature-card bg-white p-8 rounded-xl border border-gray-100">
                        <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-clock text-3xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3 text-gray-800">24/7 Tersedia</h3>
                        <p class="text-gray-600 text-center">Konsultasi kapan saja dengan dokter yang siap membantu, termasuk layanan darurat 24 jam</p>
                    </div>
                    <div class="feature-card bg-white p-8 rounded-xl border border-gray-100">
                        <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-user-md text-3xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3 text-gray-800">Dokter Spesialis</h3>
                        <p class="text-gray-600 text-center">Tenaga medis profesional dan berpengalaman dengan sertifikasi resmi</p>
                    </div>
                    <div class="feature-card bg-white p-8 rounded-xl border border-gray-100">
                        <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-mobile-alt text-3xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3 text-gray-800">Konsultasi Online</h3>
                        <p class="text-gray-600 text-center">Tanpa antri, langsung dari rumah atau kantor melalui video call atau chat</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Doctor Specialties -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-3">SPESIALISASI</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Temukan Dokter Spesialis Anda</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai dokter spesialis untuk kebutuhan kesehatan Anda</p>
                </div>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <a href="booking.php?spesialis=umum" class="specialty-card bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all text-center block">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-stethoscope text-3xl text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 mb-1">Dokter Umum</h3>
                        <p class="text-sm text-gray-500">Konsultasi kesehatan umum</p>
                    </a>
                    <a href="booking.php?spesialis=jantung" class="specialty-card bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all text-center block">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-heartbeat text-3xl text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 mb-1">Spesialis Jantung</h3>
                        <p class="text-sm text-gray-500">Perawatan jantung dan pembuluh darah</p>
                    </a>
                    <a href="booking.php?spesialis=anak" class="specialty-card bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all text-center block">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-baby text-3xl text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 mb-1">Spesialis Anak</h3>
                        <p class="text-sm text-gray-500">Kesehatan bayi dan anak</p>
                    </a>
                    <a href="booking.php?spesialis=kulit" class="specialty-card bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all text-center block">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-allergies text-3xl text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 mb-1">Spesialis Kulit</h3>
                        <p class="text-sm text-gray-500">Perawatan kulit dan kelamin</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- Doctors Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-3">TIM KAMI</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Dokter Spesialis Kami</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Tim dokter profesional siap melayani kebutuhan kesehatan Anda</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Doctor 1 -->
                    <div class="doctor-card bg-white">
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="dr. Andini Rahmawati" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 text-green-700 p-3 rounded-full mr-4 doctor-icon">
                                    <i class="fas fa-user-md text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl text-gray-800">dr. Andini Rahmawati</h3>
                                    <p class="text-green-700 font-medium">Spesialis Anak</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-6">
                                <div>
                                    <span class="font-semibold text-lg text-gray-800">Rp 150.000</span>
                                    <span class="block text-sm text-gray-500">per konsultasi</span>
                                </div>
                                <a href="booking.php?id=1" class="btn-primary bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium inline-flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i> Booking
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor 2 -->
                    <div class="doctor-card bg-white">
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="dr. Budi Santoso" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 text-green-700 p-3 rounded-full mr-4 doctor-icon">
                                    <i class="fas fa-user-md text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl text-gray-800">dr. Budi Santoso</h3>
                                    <p class="text-green-700 font-medium">Spesialis Bedah</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-6">
                                <div>
                                    <span class="font-semibold text-lg text-gray-800">Rp 250.000</span>
                                    <span class="block text-sm text-gray-500">per konsultasi</span>
                                </div>
                                <a href="booking.php?id=2" class="btn-primary bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium inline-flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i> Booking
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor 3 -->
                    <div class="doctor-card bg-white">
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="dr. Clara Yunita" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 text-green-700 p-3 rounded-full mr-4 doctor-icon">
                                    <i class="fas fa-user-md text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl text-gray-800">dr. Clara Yunita</h3>
                                    <p class="text-green-700 font-medium">Spesialis Gigi</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-6">
                                <div>
                                    <span class="font-semibold text-lg text-gray-800">Rp 120.000</span>
                                    <span class="block text-sm text-gray-500">per konsultasi</span>
                                </div>
                                <a href="booking.php?id=3" class="btn-primary bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium inline-flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i> Booking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View All Button -->
                <div class="text-center mt-16">
                    <a href="doctors.php" class="btn-primary inline-block border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-semibold py-3 px-8 rounded-full transition-all">
                        <i class="fas fa-arrow-right mr-2"></i> Lihat Semua Dokter
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 hero-section text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Konsultasi dengan Dokter?</h2>
                <p class="text-xl mb-10 max-w-2xl mx-auto opacity-90">Daftar sekarang dan dapatkan kemudahan akses layanan kesehatan</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="register.php" class="btn-primary bg-white text-green-700 hover:bg-gray-100 font-bold py-4 px-10 rounded-full text-lg inline-flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </a>
                    <a href="login.php" class="btn-primary bg-transparent border-2 border-white text-white hover:bg-white hover:text-green-700 font-bold py-4 px-10 rounded-full text-lg inline-flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                </div>
            </div>
        </section>
    </main>

    <?php include "layout/footer.html" ?>
</body>
</html>