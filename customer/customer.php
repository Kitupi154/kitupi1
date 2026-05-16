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
<div class="bg-gray text-black shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">

        <h1 class="text-xl font-bold tracking-wide">
            MR AMOSI SERVICES TECHNICAL SERVICES
        </h1>

        <div class="flex gap-3 items-center">
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="customer.php">Home</a>
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="customer.php">Services</a>
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="about.php">About Us</a>
            <a class="px-4 py-2 rounded-lg hover:bg-gray-200" href="contactus.php">Contact Us</a>
        </div>
    </div>
</div>


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
                 class="bg-gray-500 hover:bg-gray-600 text-black font-bold px-6 py-3 rounded-lg transition">
                TV Services
            </a>

            <a href="cctv.php"
                 class="bg-gray-500 hover:bg-gray-600 text-black font-bold px-6 py-3 rounded-lg transition">
                CCTV Services
            </a>

            <a href="satellite.php"
               class="bg-gray-500 hover:bg-gray-600 text-black font-bold px-6 py-3 rounded-lg transition">
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

<footer class="bg-primary-container text-white">
    <div class="max-w-container_max mx-auto px-lg py-xxl grid grid-cols-1 md:grid-cols-3 gap-lg">

        <!-- Brand -->
        <div>
            <h2 class="text-xl font-bold mb-md">MR AMOSI TECHNICAL SERVICES</h2>
            <p class="text-sm opacity-80 leading-relaxed">
                We specialize in satellite installation, CCTV systems, electrical repairs, and technical maintenance services across Dar es Salaam.
                <br><br>
                Our focus is quality workmanship, fast response, and trusted service delivery.
            </p>
        </div>

        <!-- Links -->
        <div>
            <h3 class="font-bold mb-md">Quick Links</h3>
            <div class="flex flex-col gap-sm text-sm opacity-80">
                <a href="customer.php">Home</a>
                <a href="satellite.php">Services</a>
                <a href="about.html">About Us</a>
                <a href="contactus.php">Contact us</a>
            </div>
        </div>

        <!-- Contact -->
        <div>
            <h3 class="font-bold mb-md">Contact Us</h3>

            <p class="text-sm opacity-80">
                📞 <?= htmlspecialchars($settings['phone']); ?>
            </p>

            <p class="text-sm opacity-80 mt-sm">
                📧 <?= htmlspecialchars($settings['email']); ?>
            </p>

            <p class="text-sm opacity-80 mt-sm">
                📍 Goba – Matosa Ward, Dar es Salaam
            </p>
        </div>

    </div>

    <div class="text-center text-xs opacity-60 py-md border-t border-white/10">
        © 2026 MR AMOSI TECHNICAL SERVICES. All rights reserved.
    </div>
</footer>