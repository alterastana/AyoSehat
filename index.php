<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AyoSehat - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<?php include "layout/header.html" ?>

    <main class="flex-grow flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
            <h2 class="text-3xl font-semibold mb-4">Selamat Datang di AyoSehat</h2>
            <p class="mb-6">Platform kesehatan untuk kemudahan Anda.</p>
            <a href="login.php" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-6 rounded transition">Login</a>
        </div>
    </main>
    <?php include "layout/footer.html" ?>
</body>
</html>
