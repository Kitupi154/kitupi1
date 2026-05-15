<?php
include("db.php");

// Get one image for CCTV
$cctv = mysqli_query($conn,
"SELECT services.service_name,
        service_images.image_path
 FROM services
 INNER JOIN service_images
 ON services.service_id = service_images.service_id
 WHERE services.service_name LIKE '%CCTV%'
 LIMIT 1");

$cctv_row = mysqli_fetch_assoc($cctv);

// Get one image for Satellite
$satellite = mysqli_query($conn,
"SELECT services.service_name,
        service_images.image_path
 FROM services
 INNER JOIN service_images
 ON services.service_id = service_images.service_id
 WHERE services.service_name LIKE '%Satellite%'
 LIMIT 1");

$satellite_row = mysqli_fetch_assoc($satellite);

// Get one image for TV Repair
$tv = mysqli_query($conn,
"SELECT services.service_name,
        service_images.image_path
 FROM services
 INNER JOIN service_images
 ON services.service_id = service_images.service_id
 WHERE services.service_name LIKE '%TV%'
 LIMIT 1");

$tv_row = mysqli_fetch_assoc($tv);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Amosi Technical Services</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
.hero {
    background-image: url('https://images.unsplash.com/photo-1581091870622-1e7d7f6c8c1a');
    background-size: cover;
    background-position: center;
}
.overlay {
    background: rgba(0,0,0,0.65);
}
</style>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<div class="bg-black text-white shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">

        <h1 class="text-xl font-bold tracking-wide">
            AMOSI SERVICES
        </h1>

        <div class="flex gap-3 items-center">

            <a class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 transition"
               href="customer.php">Home</a>

            <a class="px-4 py-2 rounded-lg bg-yellow-600 hover:bg-yellow-500 transition"
               href="satellite.php">Satellite</a>

            <a class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-500 transition"
               href="cctv.php">CCTV</a>

            <a class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-500 transition"
               href="tv.php">TV Repair</a>

        </div>
    </div>
</div>

<!-- HERO SECTION -->
<!-- HERO SECTION -->
<section class="relative">

    <!-- BACKGROUND IMAGE (Technician Working) -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4"
             class="w-full h-full object-cover">
    </div>

    <!-- DARK OVERLAY -->
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>

    <!-- HERO CONTENT -->
    <div class="relative py-28 px-6 text-center text-white">

        <!-- SMALL LABEL -->
        <p class="text-yellow-400 font-semibold tracking-widest uppercase mb-3">
            Professional Technical Services
        </p>

        <!-- MAIN TITLE -->
        <h2 class="text-6xl font-bold mb-4 leading-tight">
            TV • CCTV • Satellite Repair Experts
        </h2>

        <!-- SUB TITLE -->
        <p class="text-2xl font-semibold text-gray-200 mb-4">
            Fast • Reliable • Affordable Installation & Maintenance
        </p>

        <!-- DESCRIPTION -->
        <p class="text-lg max-w-3xl mx-auto text-gray-300 leading-relaxed">
            We specialize in TV installation & repair, CCTV security systems,
            and satellite dish setup including AzamTV, DSTV, Startimes, and Zuku.
            Our certified technicians deliver on-site solutions with professional care.
        </p>

        <!-- CTA BUTTONS -->
        <div class="mt-8 flex justify-center gap-4 flex-wrap">

            <a href="tv.php"
               class="bg-green-500 hover:bg-green-600 text-black font-bold px-6 py-3 rounded-lg transition">
                TV Services
            </a>

            <a href="cctv.php"
               class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-lg transition">
                CCTV Services
            </a>

            <a href="satellite.php"
               class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-3 rounded-lg transition">
                Satellite Services
            </a>

        </div>

    </div>

</section>

<!-- SERVICES -->
<section class="max-w-7xl mx-auto px-6 py-16">

    <h2 class="text-4xl font-bold text-center mb-12">
        Our Services
    </h2>

    <div class="grid md:grid-cols-3 gap-8">

        <!-- CCTV -->
        <a href="cctv.php"
        class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">

            <img src="uploads/<?= $cctv_row['image_path']; ?>"
                 class="w-full h-72 object-cover">

            <div class="p-6">
                <h3 class="text-2xl font-bold mb-3">CCTV Services</h3>
                <p class="text-gray-600">
                    Security camera installation, monitoring systems and maintenance.
                </p>
            </div>

        </a>

        <!-- SATELLITE -->
        <a href="satellite.php"
        class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">

            <img src="uploads/<?= $satellite_row['image_path']; ?>"
                 class="w-full h-72 object-cover">

            <div class="p-6">
                <h3 class="text-2xl font-bold mb-3">Satellite Services</h3>
                <p class="text-gray-600">
                    Dish installation, signal alignment and decoder setup for all providers.
                </p>
            </div>

        </a>

        <!-- TV -->
        <a href="tv.php"
        class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">

            <img src="uploads/<?= $tv_row['image_path']; ?>"
                 class="w-full h-72 object-cover">

            <div class="p-6">
                <h3 class="text-2xl font-bold mb-3">TV Repair</h3>
                <p class="text-gray-600">
                    Smart TV setup, screen repair, sound issues and wall mounting.
                </p>
            </div>

        </a>

    </div>

</section>

<!-- FOOTER -->
<footer class="bg-black text-white text-center p-6 mt-10">
    <p class="text-sm">© 2026 Amosi Technical Services | All Rights Reserved</p>
</footer>

</body>
</html>