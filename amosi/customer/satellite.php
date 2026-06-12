<?php
include("db.php");

$SATELLITE_SERVICE_ID = 2;
$success = false;

/* =========================
   HANDLE REQUEST SUBMISSION
========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $service_id = (int)($_POST['service_id'] ?? 0);
    $customer_name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $request_details = trim($_POST['request_details'] ?? '');

    if (!empty($customer_name) && !empty($phone) && $service_id > 0) {

        $stmt = $conn->prepare("
            INSERT INTO service_requests
            (service_id, customer_name, phone, email, location, request_details, request_status, requested_at)
            VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())
        ");

        $stmt->bind_param(
            "isssss",
            $service_id,
            $customer_name,
            $phone,
            $email,
            $location,
            $request_details
        );

        if ($stmt->execute()) {
            $success = true;
        }

        $stmt->close();
    }
}

/* =========================
   GET SERVICE INFO
========================= */
$service = $conn->query("
    SELECT * FROM services 
    WHERE service_id = $SATELLITE_SERVICE_ID
")->fetch_assoc();

/* =========================
   GET SATELLITE IMAGES
========================= */
$images = $conn->query("
    SELECT * FROM service_images 
    WHERE service_id = $SATELLITE_SERVICE_ID 
    ORDER BY image_id ASC
");
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

<?php if(isset($success)): ?>

<div class="bg-green-600 text-white text-center py-3">
    Service request submitted successfully.
</div>

<?php endif; ?>

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
<button
type="button"
onclick="openModal()"
class="mt-6 bg-yellow-500 text-black px-6 py-3 rounded-lg font-bold hover:bg-yellow-400">

    Request Satellite Service

</button>

</div>
</section>

<!-- ================= SATELLITE SERVICES CONTENT ================= -->
<section class="bg-gray-50 py-14">

<div class="max-w-6xl mx-auto px-6">

    <!-- HEADER -->
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
            Satellite Installation & Repair Services
        </h2>

        <p class="text-gray-600 mt-3 max-w-2xl mx-auto text-sm md:text-base">
            We provide professional satellite dish installation, signal repair, alignment, and maintenance services for all major TV providers.
        </p>
    </div>

    <!-- CONTENT -->
    <?php if($images && $images->num_rows > 0): ?>

        <?php while($img = $images->fetch_assoc()): ?>

            <div class="grid md:grid-cols-3 gap-6 items-center mb-6 bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-md transition">

                <!-- TEXT -->
                <div class="md:col-span-2 p-5">

                    <h3 class="text-xl font-semibold text-green-700 mb-2">
                        <?= htmlspecialchars($img['image_title']); ?>
                    </h3>

                    <p class="text-gray-600 text-sm leading-relaxed text-justify">
                        <?= htmlspecialchars($img['image_description']); ?>
                    </p>

                </div>

                <!-- IMAGE -->
            <div class="w-full h-40 rounded-lg overflow-hidden border bg-gray-50 p-2">

    <img
        src="uploads/<?= htmlspecialchars($img['image_path']); ?>"
        class="w-full h-full object-contain hover:scale-105 transition duration-300">

</div>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="text-center py-10 text-gray-500">
            No satellite services available.
        </div>

    <?php endif; ?>

</div>

</section>

<!-- ================= SUPPORTED BRANDS SECTION ================= -->
<section class="bg-gray-50 py-14">

<div class="max-w-6xl mx-auto px-6">

    <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">
        Supported Satellite Systems
    </h2>

    <div class="grid md:grid-cols-4 gap-6">

        <!-- AZAM TV -->
        <div class="relative h-72 rounded-2xl overflow-hidden shadow-lg group">

            <!-- IMAGE -->
            <!-- <img src="admin/uploads/azamtv.jpg"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500"> -->

            <!-- LIGHT OVERLAY (NOT TOO DARK) -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

            <!-- CONTENT -->
            <div class="absolute bottom-0 p-5 text-white z-10">
                <h2 class="text-xl font-bold mb-2">AzamTV</h2>
                <ul class="text-sm space-y-1">
                    <li>• Dish Setup Installation</li>
                    <li>• Antenna Setup Installation</li>
                    <li>• Signal Repair</li>
                    <li>• Decoder Configuration</li>
                    <li>• Channel Activation</li>
                </ul>
            </div>

        </div>

        <!-- DSTV -->
        <div class="relative h-72 rounded-2xl overflow-hidden shadow-lg group">

            <img src="admin/uploads/dstv.png"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500">

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

            <div class="absolute bottom-0 p-5 text-white z-10">
                <h2 class="text-xl font-bold mb-2">DSTV</h2>
                <ul class="text-sm space-y-1">
                    <li>• Dish Installation</li>
                    <li>• Antenna Installation</li>
                    <li>• Decoder Setup</li>
                    <li>• Signal Alignment</li>
                    <li>• Subscription Support</li>
                </ul>
            </div>

        </div>

        <!-- STARTIMES -->
        <div class="relative h-72 rounded-2xl overflow-hidden shadow-lg group">

            <img src="admin/uploads/startimes.jpg"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500">

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

            <div class="absolute bottom-0 p-5 text-white z-10">
                <h2 class="text-xl font-bold mb-2">StarTimes</h2>
                <ul class="text-sm space-y-1">
                    <li>• Dish Setup</li>
                    <li>• Antenna Setup</li>
                    <li>• Decoder Repair</li>
                    <li>• Signal Troubleshooting</li>
                    <li>• Channel Configuration</li>
                </ul>
            </div>

        </div>

        <!-- ZUKU -->
        <div class="relative h-72 rounded-2xl overflow-hidden shadow-lg group">

            <img src="admin/uploads/zuku.png"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500">

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

            <div class="absolute bottom-0 p-5 text-white z-10">
                <h2 class="text-xl font-bold mb-2">Zuku</h2>
                <ul class="text-sm space-y-1">
                    <li>• Dish Installation</li>
                    <li>• Antenna Setup</li>
                    <li>• Decoder Maintenance</li>
                    <li>• Signal Repair</li>
                    <li>• Subscription Assistance</li>
                </ul>
            </div>

        </div>

    </div>

</div>

</section>

<!-- REQUEST MODAL -->
<div id="modal"
     class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-xl w-full max-w-md relative">

        <button
        type="button"
        onclick="closeModal()"
        class="absolute top-3 right-4 text-2xl font-bold text-red-500">
            ×
        </button>

        <h2 class="text-2xl font-bold mb-4">
            Satellite Service Request
        </h2>

    <form method="POST" class="space-y-4">

    <!-- Full Name -->
    <div>
        <label for="customer_name" class="block mb-2 text-sm font-semibold text-gray-700">
            Full Name <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="customer_name"
            name="customer_name"
            required
            placeholder="Enter your full name (e.g., John Michael Doe)"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
    </div>

    <!-- Phone Number -->
    <div>
        <label for="phone" class="block mb-2 text-sm font-semibold text-gray-700">
            Phone Number <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="phone"
            name="phone"
            required
            placeholder="Enter your active phone number (e.g., +255 712 345 678)"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
    </div>

    <!-- Email Address -->
    <div>
        <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">
            Email Address
        </label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email address (optional)"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
    </div>

    <!-- Location -->
    <div>
        <label for="location" class="block mb-2 text-sm font-semibold text-gray-700">
            Service Location
        </label>
        <input
            type="text"
            id="location"
            name="location"
            placeholder="Enter your location (eg Goba,Dar es salaam)"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
    </div>

    <!-- Request Details -->
    <div>
        <label for="request_details" class="block mb-2 text-sm font-semibold text-gray-700">
            Request Details
        </label>
        <textarea
            id="request_details"
            name="request_details"
            rows="4"
            placeholder="Please describe your issue, installation request, or service requirements in detail..."
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none resize-none"></textarea>
    </div>

    <input
        type="hidden"
        name="service_id"
        value="<?php echo $SATELLITE_SERVICE_ID; ?>">

    <!-- Submit Button -->
    <button
        type="submit"
        name="submit_request"
        class="w-full bg-yellow-500 hover:bg-yellow-400 text-black py-3 rounded-lg font-bold transition duration-300 shadow-md hover:shadow-lg">

        Submit Request

    </button>

</form>

    </div>

</div>

        <button onclick="closeModal()" class="mt-2 text-red-500">Close</button>

    </div>
</div>
<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

window.onclick = function(event) {

    let modal = document.getElementById('modal');

    if(event.target === modal){
        closeModal();
    }

}
</script>

<script>
function openModal() {
    document.getElementById("modal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("modal").classList.add("hidden");
}

window.onclick = function(event){

    let modal = document.getElementById("modal");

    if(event.target === modal){
        closeModal();
    }
}
</script>

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