<?php include("db.php"); ?>

<?php
$TV_SERVICE_ID = 1;

/* =========================
   HANDLE REQUEST SUBMISSION
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("INSERT INTO service_requests 
    (service_id, customer_name, phone, email, location, request_details, request_status, requested_at)
    VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");

    $stmt->bind_param(
        "isssss",
        $_POST['service_id'],
        $_POST['customer_name'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['location'],
        $_POST['request_details']
    );

    $stmt->execute();
}

/* =========================
   FETCH TV SERVICE
========================= */
$service = $conn->query("SELECT * FROM services WHERE service_id = $TV_SERVICE_ID")->fetch_assoc();

/* =========================
   FETCH TV IMAGES ONLY
========================= */
$images = $conn->query("SELECT * FROM service_images WHERE service_id = $TV_SERVICE_ID");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>TV Installation & Repair</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.hero {
    background: url('https://images.unsplash.com/photo-1593359677879-a4bb92f829d1') center/cover;
}
.overlay {
    background: rgba(0,0,0,0.65);
}
.modal { display:none; }
.modal.show { display:flex; }
</style>
</head>

<body class="bg-gray-100">

<!-- ================= NAVBAR ================= -->
<div class="bg-gray text-black shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">

        <h1 class="text-xl font-bold tracking-wide">
           MR AMOSI SERVICES TECHNICAL SERVICES
        </h1>

        <div class="flex gap-3 items-center">

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="customer.php">Home</a>

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="satellite.php">satellite dishes</a>

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="cctv.php">cctv camera</a>

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="tv.php">tv repairs</a>

        </div>
    </div>

<!-- ================= HERO ================= -->
<section class="hero text-white">
<div class="overlay p-16">

    <h1 class="text-5xl font-bold mb-4">
        TV Installation & Repair Services
    </h1>

    <p class="text-2xl mb-2">
        Professional TV Repair, Setup & Installation
    </p>

    <p class="text-lg max-w-2xl text-gray-200">
        We repair all TV issues including display failure, sound problems,
        smart TV setup, wall mounting, and full installation services.
    </p>

    <button onclick="openModal()"
        class="mt-6 bg-green-500 text-black px-6 py-2 rounded font-bold">
        Request TV Service
    </button>

</div>
</section>

<!-- ================= CONTENT ================= -->
<div class="p-10 grid md:grid-cols-2 gap-10">

    <!-- LEFT DESCRIPTION -->
    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-3xl font-bold mb-4">TV Repair Services</h2>

        <p class="text-xl font-bold">📺 No Power / Blank Screen</p>
        <p class="text-gray-600 mb-3">Fix TVs that do not turn on or display image issues.</p>

        <p class="text-xl font-bold">🖥️ Screen Repair</p>
        <p class="text-gray-600 mb-3">Repair cracked or damaged LED / OLED panels.</p>

        <p class="text-xl font-bold">🔊 Sound Problems</p>
        <p class="text-gray-600 mb-3">Fix no sound, low sound, or distorted audio issues.</p>

        <p class="text-xl font-bold">📡 Smart TV Setup</p>
        <p class="text-gray-600 mb-3">Apps, WiFi connection, software updates and configuration.</p>

        <p class="text-xl font-bold">🛠️ Wall Mounting</p>
        <p class="text-gray-600">Professional installation with hidden cables and alignment.</p>

    </div>

    <!-- RIGHT IMAGES FROM DB -->
    <div class="grid grid-cols-2 gap-4">

        <?php while($img = $images->fetch_assoc()): ?>
            <img class="rounded shadow h-40 w-full object-cover"
                 src="uploads/<?php echo $img['image_path']; ?>">
        <?php endwhile; ?>

    </div>

</div>

<!-- ================= REQUEST MODAL ================= -->
<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-70 items-center justify-center">

    <div class="bg-white p-6 rounded w-96">

        <h2 class="text-2xl font-bold mb-4">TV Service Request</h2>

        <form method="POST">

            <input class="w-full mb-2 p-2 border" name="customer_name" placeholder="Full Name" required>
            <input class="w-full mb-2 p-2 border" name="phone" placeholder="Phone" required>
            <input class="w-full mb-2 p-2 border" name="email" placeholder="Email">
            <input class="w-full mb-2 p-2 border" name="location" placeholder="Location">

            <textarea class="w-full mb-2 p-2 border"
                      name="request_details"
                      placeholder="Describe your TV issue or installation need"></textarea>

            <input type="hidden" name="service_id" value="<?php echo $TV_SERVICE_ID; ?>">

            <button class="bg-green-600 text-white px-4 py-2 w-full">
                Submit Request
            </button>

        </form>

        <button onclick="closeModal()" class="mt-2 text-red-500">Close</button>

    </div>
</div>

<!-- ================= FOOTER ================= -->
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