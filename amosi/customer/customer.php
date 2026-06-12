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
<!-- REQUEST MODAL -->
<div
id="modal"
class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 relative">

        <button
        type="button"
        onclick="closeModal()"
        class="absolute top-3 right-4 text-2xl text-gray-500 hover:text-red-500">
            &times;
        </button>

        <h2 class="text-2xl font-bold mb-5">
            Satellite Service Request
        </h2>

        <form method="POST">

            <input
            type="text"
            name="customer_name"
            placeholder="Full Name"
            required
            class="w-full mb-3 p-3 border rounded-lg">

            <input
            type="text"
            name="phone"
            placeholder="Phone Number"
            required
            class="w-full mb-3 p-3 border rounded-lg">

            <input
            type="email"
            name="email"
            placeholder="Email Address"
            class="w-full mb-3 p-3 border rounded-lg">

            <input
            type="text"
            name="location"
            placeholder="Location"
            class="w-full mb-3 p-3 border rounded-lg">

            <textarea
            name="request_details"
            rows="4"
            placeholder="Describe your installation or repair request"
            class="w-full mb-3 p-3 border rounded-lg"></textarea>

            <input
            type="hidden"
            name="service_id"
            value="<?php echo $SATELLITE_SERVICE_ID; ?>">

            <button
            type="submit"
            class="w-full bg-yellow-500 text-black font-bold py-3 rounded-lg hover:bg-yellow-400 transition">

                Submit Request

            </button>

        </form>

    </div>

</div>
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

<footer class="bg-gray-900 text-white">
    <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- Brand -->
        <div>
            <h2 class="text-xl font-bold mb-4">MR AMOSI TECHNICAL SERVICES</h2>
            <p class="text-sm text-gray-300 leading-relaxed">
                We specialize in satellite installation, CCTV systems, electrical repairs, and technical maintenance services across Dar es Salaam.
                <br><br>
                Fast, reliable and professional service delivery.
            </p>
        </div>

        <!-- Links -->
        <div>
            <h3 class="font-bold mb-4">Quick Links</h3>
            <div class="flex flex-col gap-2 text-sm text-gray-300">
                <a href="customer.php" class="hover:text-green-400">Home</a>
                <a href="satellite.php" class="hover:text-green-400">Services</a>
                <a href="about.html" class="hover:text-green-400">About Us</a>
                <a href="contactus.php" class="hover:text-green-400">Contact Us</a>
            </div>
        </div>

        <!-- Contact -->
        <div>
            <h3 class="font-bold mb-4">Contact Us</h3>

            <p class="text-sm text-gray-300">
                📞 +255 XXX XXX XXX
            </p>

            <p class="text-sm text-gray-300 mt-2">
                📧 info@amosiservices.com
            </p>

            <p class="text-sm text-gray-300 mt-2">
                📍 Goba – Matosa Ward, Dar es Salaam
            </p>
        </div>

    </div>

    <div class="text-center text-xs text-gray-500 py-4 border-t border-gray-800">
        © 2026 MR AMOSI TECHNICAL SERVICES. All rights reserved.
    </div>
</footer>