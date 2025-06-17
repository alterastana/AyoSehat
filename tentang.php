<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - AyoSehat</title>
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
        .feature-icon {
            transition: all 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: rotate(10deg) scale(1.1);
        }
    </style>
</head>
<body class="bg-secondary-100 min-h-screen flex flex-col font-sans antialiased">
    <?php include "layout/header.html"; ?>

    <main class="flex-1">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate__animated animate__fadeIn">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6 animate__animated animate__fadeInDown">
                    Tentang AyoSehat
                </h1>
                <p class="text-xl max-w-3xl mx-auto animate__animated animate__fadeInUp animate__delay-1s">
                    Komitmen kami untuk memberikan pelayanan kesehatan terbaik dengan teknologi terkini
                </p>
            </div>
        </section>

        <!-- About Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Our Story -->
            <section class="mb-20 animate__animated animate__fadeIn">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="animate__animated animate__fadeInLeft">
                        <h2 class="text-3xl font-bold text-primary-800 mb-6">Visi & Misi Kami</h2>
                        <div class="space-y-4 text-secondary-700">
                            <p>
                                Didirikan pada tahun 2025, AyoSehat hadir untuk menjawab tantangan akses kesehatan di Indonesia dengan solusi digital yang inovatif.
                            </p>
                            <p>
                                Visi kami adalah menciptakan ekosistem kesehatan digital yang terintegrasi, menjangkau seluruh lapisan masyarakat dengan layanan yang terjangkau dan berkualitas.
                            </p>
                            <p>
                                Misi kami adalah memanfaatkan teknologi untuk menyederhanakan proses kesehatan, dari konsultasi dokter hingga manajemen rekam medis pasien.
                            </p>
                        </div>
                    </div>
                    <div class="animate__animated animate__fadeInRight">
                        <div class="bg-white rounded-xl p-2 smooth-shadow card-hover">
                            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Tim AyoSehat" 
                                 class="w-full h-auto rounded-lg">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Our Values -->
            <section class="mb-20 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-center text-primary-800 mb-12">Nilai-nilai Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl p-6 smooth-shadow card-hover feature-card">
                        <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 feature-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-center text-secondary-800 mb-2">Inovasi</h3>
                        <p class="text-secondary-600 text-center">
                            Terus mengembangkan solusi teknologi untuk memecahkan masalah kesehatan dengan cara yang kreatif dan efektif.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl p-6 smooth-shadow card-hover feature-card">
                        <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 feature-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-center text-secondary-800 mb-2">Integritas</h3>
                        <p class="text-secondary-600 text-center">
                            Menjunjung tinggi kejujuran dan transparansi dalam setiap aspek pelayanan kami kepada pasien.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl p-6 smooth-shadow card-hover feature-card">
                        <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 feature-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-center text-secondary-800 mb-2">Kepedulian</h3>
                        <p class="text-secondary-600 text-center">
                            Menempatkan pasien sebagai pusat dari segala layanan kami dengan empati dan perhatian penuh.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Our Team -->
            <section class="animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-center text-primary-800 mb-12">Tim Kami</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Team Member 1 -->
                    <div class="bg-white rounded-xl overflow-hidden smooth-shadow card-hover">
                        <img src="images/business-finance-employment-female-successful-entrepreneurs-concept-smiling-professional-female-office-manager-ceo-e-commerce-company-looking-pleased-camera-white-background.jpg" alt="Dr. Sarah Wijaya" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-secondary-800">Dr. Sarah Wijaya</h3>
                            <p class="text-primary-600 font-medium mb-2">Dokter Umum</p>
                            <p class="text-secondary-600 text-sm">
                                Spesialis kesehatan keluarga dengan pengalaman 10 tahun di berbagai rumah sakit ternama.
                            </p>
                        </div>
                    </div>
                    <!-- Team Member 2 -->
                    <div class="bg-white rounded-xl overflow-hidden smooth-shadow card-hover">
                        <img src="images/vitaly-gariev-lNbM1c4vdCk-unsplash.jpg" alt="Michael Tanuwijaya" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-secondary-800">Michael Tanuwijaya</h3>
                            <p class="text-primary-600 font-medium mb-2">CTO & Co-founder</p>
                            <p class="text-secondary-600 text-sm">
                                Ahli teknologi dengan spesialisasi dalam pengembangan sistem kesehatan digital.
                            </p>
                        </div>
                    </div>
                    <!-- Team Member 3 -->
                    <div class="bg-white rounded-xl overflow-hidden smooth-shadow card-hover">
                        <img src="images/close-up-portrait-businesswoman-asian-female-entrepreneur-suit-smiling-looking-professional-standing-against-white-background.jpg" alt="Dian Permatasari" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-secondary-800">Dian Permatasari</h3>
                            <p class="text-primary-600 font-medium mb-2">Head of Customer Service</p>
                            <p class="text-secondary-600 text-sm">
                                Berpengalaman dalam manajemen layanan pelanggan di industri kesehatan selama 8 tahun.
                            </p>
                        </div>
                    </div>
                    <!-- Team Member 4 -->
                    <div class="bg-white rounded-xl overflow-hidden smooth-shadow card-hover">
                        <img src="images/usman-yousaf-tPxS-1IPZAo-unsplash.jpg" alt="Dr. Aditya Pratama" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-secondary-800">Dr. Aditya Pratama</h3>
                            <p class="text-primary-600 font-medium mb-2">Dokter Spesialis Jantung</p>
                            <p class="text-secondary-600 text-sm">
                                Ahli kardiologi dengan spesialisasi dalam pencegahan penyakit kardiovaskular.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="mt-20 bg-primary-700 rounded-xl p-8 md:p-12 text-center text-white smooth-shadow animate__animated animate__fadeIn">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Siap Memulai Perjalanan Kesehatan Anda?</h2>
                <p class="text-primary-100 max-w-2xl mx-auto mb-8">
                    Bergabunglah dengan ribuan pasien yang telah merasakan kemudahan layanan kesehatan digital dari AyoSehat.
                </p>
                <a href="register.php" class="inline-block bg-white text-primary-700 font-bold py-3 px-8 rounded-lg hover:bg-secondary-100 transition duration-300">
                    Daftar Sekarang
                </a>
            </section>
        </div>
    </main>

    <?php include "layout/footer.html"; ?>
</body>
</html>