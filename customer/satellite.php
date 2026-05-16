<?php include("db.php"); ?>

<?php
$SATELLITE_SERVICE_ID = 2;

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
   GET SERVICE DATA
========================= */
$service = $conn->query("SELECT * FROM services WHERE service_id = $SATELLITE_SERVICE_ID")->fetch_assoc();

/* =========================
   GET IMAGES
========================= */
$images = $conn->query("SELECT * FROM service_images WHERE service_id = $SATELLITE_SERVICE_ID");
?>

<!DOCTYPE html>
<html>
<head>
<title>Satellite Installation & Repair</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.hero {
    background: url('https://images.unsplash.com/photo-1616401784845-180882ba9ba8') center/cover;
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
        Satellite Dish Installation & Repair
    </h1>

    <p class="text-2xl mb-2">
        AzamTV • DStv • StarTimes • Zuku Installation Experts
    </p>

    <p class="text-lg max-w-2xl text-gray-200">
        We install, repair, align and maintain all satellite systems including dish and antenna setups
        with professional signal optimization.
    </p>

    <button onclick="openModal()"
        class="mt-6 bg-yellow-500 text-black px-6 py-2 rounded font-bold">
        Request Satellite Service
    </button>

</div>
</section>

<!-- SERVICES SECTION -->
<div class="p-10 grid md:grid-cols-2 gap-10">

    <!-- LEFT CONTENT -->
    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-3xl font-bold mb-4">Satellite Installation Services</h2>

        <p class="text-xl font-bold">📡 Dish Installation</p>
        <p class="text-gray-600 mb-3">Proper alignment for strong and stable signal reception.</p>

        <p class="text-xl font-bold">📶 Antenna Installation</p>
        <p class="text-gray-600 mb-3">Digital antenna setup for local and free-to-air channels.</p>

        <p class="text-xl font-bold">🛠️ Signal Repair & Alignment</p>
        <p class="text-gray-600 mb-3">Fix weak signals, no signal errors, and decoder issues.</p>

        <p class="text-xl font-bold">⚙️ Maintenance Service</p>
        <p class="text-gray-600 mb-3">Regular system checkups for long-term performance.</p>

        <p class="text-xl font-bold">mobile intergration</p>
        <p class="text-gray-600">
            intergrating the satelites services in your mobile eg azamtv max
        </p>
           <p class="text-xl font-bold">🔧 Extra Solutions</p>
        <p class="text-gray-600">
            LNB replacement, decoder configuration, cable rewiring, and multi-TV setup.
        </p>
    </div>

    <!-- RIGHT IMAGES FROM DB -->
    <div class="grid grid-cols-2 gap-4">

        <?php while($img = $images->fetch_assoc()): ?>
            <img class="rounded shadow h-40 w-full object-cover"
                 src="uploads/<?php echo $img['image_path']; ?>">
        <?php endwhile; ?>

    </div>

</div>

<!-- SUPPORTED BRANDS SECTION -->
<div class="px-10 pb-10">
    <h2 class="text-2xl font-bold mb-4">Supported Satellite Systems</h2>

    <div class="grid md:grid-cols-4 gap-4 text-center">

       <div class="rounded-3xl overflow-hidden shadow-xl text-white p-8 relative"
     style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)),
     url('https://upload.wikimedia.org/wikipedia/commons/5/52/Azam_Media_logo.png');
     background-size: cover;
     background-position: center;">

    <h2 class="text-3xl font-bold mb-4">
        AzamTV Installation & Repairs
    </h2>

    <ul class="space-y-2 text-lg">
        <li>✔ Dish Setup Installation</li>
        <li>✔ Antenna Setup Installation</li>
        <li>✔ Signal Problems Repair</li>
        <li>✔ Decoder Configuration</li>
        <li>✔ Channel Activation</li>
    </ul>
</div>
        <div class="rounded-3xl overflow-hidden shadow-xl text-white p-8 relative"
     style="background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)),
     url('https://upload.wikimedia.org/wikipedia/commons/8/81/DStv_logo.png');
     background-size: cover;
     background-position: center;">

    <h2 class="text-3xl font-bold mb-4">
        DSTV Installation & Repairs
    </h2>

    <ul class="space-y-2 text-lg">
        <li>✔ Dish Installation</li>
        <li>✔ Antenna Installation</li>
        <li>✔ Decoder Setup</li>
        <li>✔ Signal Alignment</li>
        <li>✔ Subscription Support</li>
    </ul>
</div>
     <div class="rounded-3xl overflow-hidden shadow-xl text-white p-8 relative"
     style="background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)),
     url('https://upload.wikimedia.org/wikipedia/commons/4/49/StarTimes_logo.png');
     background-size: cover;
     background-position: center;">

    <h2 class="text-3xl font-bold mb-4">
        StarTimes Installation & Repairs
    </h2>

    <ul class="space-y-2 text-lg">
        <li>✔ Dish Setup</li>
        <li>✔ Antenna Setup</li>
        <li>✔ Decoder Repair</li>
        <li>✔ Signal Troubleshooting</li>
        <li>✔ Channel Configuration</li>
    </ul>
</div>
     <div class="rounded-3xl overflow-hidden shadow-xl text-white p-8 relative"
     style="background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)),
     url('https://upload.wikimedia.org/wikipedia/commons/b/bf/Zuku_Logo.png');
     background-size: cover;
     background-position: center;">

    <h2 class="text-3xl font-bold mb-4">
        Zuku Installation & Repairs
    </h2>

    <ul class="space-y-2 text-lg">
        <li>✔ Dish Installation</li>
        <li>✔ Antenna Setup</li>
        <li>✔ Decoder Maintenance</li>
        <li>✔ Signal Repair</li>
        <li>✔ Subscription Assistance</li>
    </ul>
</div>

    </div>
</div>

<!-- REQUEST MODAL -->
<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-70 items-center justify-center">

    <div class="bg-white p-6 rounded w-96">

        <h2 class="text-2xl font-bold mb-4">Satellite Service Request</h2>

        <form method="POST">

            <input class="w-full mb-2 p-2 border" name="customer_name" placeholder="Full Name" required>
            <input class="w-full mb-2 p-2 border" name="phone" placeholder="Phone" required>
            <input class="w-full mb-2 p-2 border" name="email" placeholder="Email">
            <input class="w-full mb-2 p-2 border" name="location" placeholder="Location">

            <textarea class="w-full mb-2 p-2 border" name="request_details"
                placeholder="Describe your satellite issue or installation need"></textarea>

            <input type="hidden" name="service_id" value="<?php echo $SATELLITE_SERVICE_ID; ?>">

            <button class="bg-yellow-500 text-black px-4 py-2 w-full font-bold">
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