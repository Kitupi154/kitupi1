<?php include("db.php"); ?>

<?php
$CCTV_SERVICE_ID = 3;

/* =========================
   HANDLE REQUEST SUBMISSION
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $request_details = $_POST['request_details'];
    $service_id = $_POST['service_id'];

    $stmt = $conn->prepare("INSERT INTO service_requests 
    (service_id, customer_name, phone, email, location, request_details, request_status, requested_at) 
    VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");

    $stmt->bind_param("isssss",
        $service_id,
        $customer_name,
        $phone,
        $email,
        $location,
        $request_details
    );

    $stmt->execute();
}

/* =========================
   FETCH CCTV SERVICE
========================= */
$serviceQuery = $conn->query("SELECT * FROM services WHERE service_id = $CCTV_SERVICE_ID");
$service = $serviceQuery->fetch_assoc();

/* =========================
   FETCH CCTV IMAGES ONLY
========================= */
$imagesQuery = $conn->query("SELECT * FROM service_images WHERE service_id = $CCTV_SERVICE_ID");
?>

<!DOCTYPE html>
<html>
<head>
<title>CCTV Installation & Security Services</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.hero {
    background: url('https://images.unsplash.com/photo-1557597774-9d273605dfa9') center/cover;
}
.overlay {
    background: rgba(0,0,0,0.65);
}
.modal { display:none; }
.modal.show { display:flex; }
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

<!-- HERO -->
<section class="hero text-white">
<div class="overlay p-16">

    <h1 class="text-5xl font-bold mb-4">
        CCTV Installation & Security Systems
    </h1>

    <p class="text-2xl mb-2">
        Professional Surveillance & Security Solutions
    </p>

    <p class="text-lg max-w-2xl text-gray-200">
        We provide CCTV installation, configuration, maintenance, and security monitoring
        for homes, offices, and commercial buildings.
    </p>

    <button onclick="openModal()"
        class="mt-6 bg-yellow-500 text-black px-6 py-2 rounded font-bold">
        Request CCTV Service
    </button>

</div>
</section>

<!-- CONTENT -->
<div class="p-10 grid md:grid-cols-2 gap-10">

    <!-- LEFT -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-3xl font-bold mb-4">CCTV Services We Offer</h2>

        <p class="text-xl font-semibold">✔ CCTV Installation</p>
        <p class="mb-3 text-gray-600">Full setup for homes, offices & buildings.</p>

        <p class="text-xl font-semibold">✔ Camera Configuration</p>
        <p class="mb-3 text-gray-600">Network setup, DVR/NVR configuration.</p>

        <p class="text-xl font-semibold">✔ Maintenance & Repair</p>
        <p class="mb-3 text-gray-600">Fix faulty cameras, wiring, and storage systems.</p>

        <p class="text-xl font-semibold">✔ Remote Monitoring</p>
        <p class="mb-3 text-gray-600">Access CCTV from mobile or computer anywhere.</p>
    </div>

    <!-- RIGHT IMAGES -->
    <div class="grid grid-cols-2 gap-4">
        <?php while($img = $imagesQuery->fetch_assoc()): ?>
            <img class="rounded shadow h-40 w-full object-cover"
                 src="uploads/<?php echo $img['image_path']; ?>">
        <?php endwhile; ?>
    </div>

</div>

<!-- MODAL REQUEST FORM -->
<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-70 items-center justify-center">

    <div class="bg-white p-6 rounded w-96">

        <h2 class="text-2xl font-bold mb-4">CCTV Service Request</h2>

        <form method="POST">

            <input class="w-full mb-2 p-2 border" name="customer_name" placeholder="Full Name" required>
            <input class="w-full mb-2 p-2 border" name="phone" placeholder="Phone" required>
            <input class="w-full mb-2 p-2 border" name="email" placeholder="Email">
            <input class="w-full mb-2 p-2 border" name="location" placeholder="Location">

            <textarea class="w-full mb-2 p-2 border" name="request_details"
                placeholder="Describe your CCTV problem or installation need"></textarea>

            <input type="hidden" name="service_id" value="<?php echo $CCTV_SERVICE_ID; ?>">

            <button class="bg-blue-600 text-white px-4 py-2 w-full">
                Submit Request
            </button>

        </form>

        <button onclick="closeModal()" class="mt-2 text-red-500">Close</button>

    </div>
</div>

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