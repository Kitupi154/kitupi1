<?php
include "db.php";

/* FETCH SETTINGS */
$settingsQuery = mysqli_query($conn, "SELECT * FROM settings LIMIT 1");
$settings = mysqli_fetch_assoc($settingsQuery);

/* SAFE FALLBACKS */
$phone = $settings['phone'] ?? "+255 XXX XXX XXX";
$email = $settings['email'] ?? "info@example.com";
$location = $settings['location'] ?? "Goba – Matosa Ward, Dar es Salaam";

/* OPTIONAL DB FIELDS (if you add later) */
$about_text = $settings['about_text'] ?? null;
$mission = $settings['mission'] ?? null;
$vision = $settings['vision'] ?? null;
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>About Us | Mr Amosi Technical Services</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

<style>
body {
    font-family: Inter, sans-serif;
}
</style>
</head>

<body class="bg-gray-50">

<!-- NAVBAR (UNCHANGED STRUCTURE) -->
<div class="bg-gray text-black shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">

        <h1 class="text-xl font-bold tracking-wide">
            MR AMOSI SERVICES TECHNICAL SERVICES
        </h1>

        <div class="flex gap-3 items-center">
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="customer.php">Home</a>
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="satellite.php">Services</a>
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="about.php">About Us</a>
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="contactus.php">Contact Us</a>
        </div>
    </div>
</div>

<main>

<!-- HERO SECTION (DB READY) -->
<section class="relative bg-blue-900 min-h-[500px] flex items-center overflow-hidden">

    <div class="absolute inset-0 opacity-30">
        <img src="https://images.unsplash.com/photo-1581092334651-ddf26d9a09d0"
             class="w-full h-full object-cover"
             alt="background"/>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 text-white">

        <span class="text-yellow-300 uppercase tracking-widest text-sm">
            Technical Excellence
        </span>

        <h1 class="text-4xl font-bold mt-2">
            Our Story & Expertise
        </h1>

        <p class="mt-4 max-w-xl text-white/90">
            <?= htmlspecialchars($about_text ?? "We are a professional technical company based in Dar es Salaam, Goba – Matosa Ward, providing satellite installation, CCTV systems, electrical repairs and maintenance services."); ?>
        </p>

    </div>
</section>


<!-- MISSION / VISION (DB CONTROLLED) -->
<section class="max-w-6xl mx-auto py-16 px-6 grid md:grid-cols-2 gap-6">

    <div class="bg-white p-6 shadow rounded-xl">
        <h2 class="text-2xl font-bold mb-2">Our Mission</h2>
        <p class="text-gray-600">
            <?= htmlspecialchars($mission ?? "To deliver reliable, affordable and high-quality technical solutions across Tanzania with integrity and professionalism."); ?>
        </p>
    </div>

    <div class="bg-blue-900 text-white p-6 shadow rounded-xl">
        <h2 class="text-2xl font-bold mb-2">Our Vision</h2>
        <p class="opacity-90">
            <?= htmlspecialchars($vision ?? "To become the leading technical service provider in East Africa by delivering innovative and trusted solutions."); ?>
        </p>
    </div>

</section>


<!-- CORE INFO (FROM SETTINGS DB) -->
<section class="max-w-6xl mx-auto px-6 pb-16 grid md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-bold mb-2">Phone</h3>
        <p><?= htmlspecialchars($phone); ?></p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-bold mb-2">Email</h3>
        <p><?= htmlspecialchars($email); ?></p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-bold mb-2">Location</h3>
        <p><?= htmlspecialchars($location); ?></p>
    </div>

</section>

</main>


<!-- FOOTER -->
<footer class="bg-blue-900 text-white mt-10">
    <div class="max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-6">

        <div>
            <h2 class="font-bold text-lg">Mr Amosi Technical Services</h2>
            <p class="text-white/80 mt-2">
                Reliable technical solutions in Dar es Salaam, Goba – Matosa Ward.
            </p>
        </div>

        <div>
            <h3 class="font-bold mb-2">Quick Links</h3>
            <ul class="space-y-1 text-white/80">
                <li><a href="customer.php">Home</a></li>
                <li><a href="satellite.php">Services</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contactus.php">Contact</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold mb-2">Contact</h3>
            <p><?= htmlspecialchars($phone); ?></p>
            <p><?= htmlspecialchars($email); ?></p>
            <p>Goba – Matosa Ward, Dar es Salaam</p>
        </div>

    </div>

    <div class="text-center text-sm py-4 border-t border-white/20">
        © <?= date("Y"); ?> Mr Amosi Technical Services
    </div>
</footer>

</body>
</html>