<?php
include("db.php");

$TV_SERVICE_ID = 1;
$success = false;
$error = "";

/* =========================
   HANDLE REQUEST SUBMISSION
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['customer_name'])) {

    $service_id = intval($_POST['service_id']);
    $customer_name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $location = trim($_POST['location']);
    $request_details = trim($_POST['request_details']);

    $stmt = $conn->prepare("
        INSERT INTO service_requests
        (
            service_id,
            customer_name,
            phone,
            email,
            location,
            request_details,
            request_status,
            requested_at
        )
        VALUES
        (?, ?, ?, ?, ?, ?, 'Pending', NOW())
    ");

    if($stmt){

        $stmt->bind_param(
            "isssss",
            $service_id,
            $customer_name,
            $phone,
            $email,
            $location,
            $request_details
        );

        if($stmt->execute()){
            $success = true;
        } else {
            $error = $stmt->error;
        }

        $stmt->close();

    } else {
        $error = $conn->error;
    }



$CCTV_SERVICE_ID = 3;

$images = mysqli_query(
    $conn,
    "SELECT *
     FROM service_images
     WHERE service_id = '$CCTV_SERVICE_ID'
     ORDER BY image_id ASC"
);


}

/* =========================
   FETCH TV SERVICE
========================= */
$service = $conn->query("
    SELECT *
    FROM services
    WHERE service_id = $TV_SERVICE_ID
")->fetch_assoc();

/* =========================
   FETCH TV IMAGES
========================= */
$images = $conn->query("
    SELECT *
    FROM service_images
    WHERE service_id = $TV_SERVICE_ID
");
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

<button
    type="button"
    onclick="openModal()"
    class="mt-6 bg-green-500 text-black px-6 py-2 rounded font-bold"
>
    Request TV Service
</button>
</section>

<!-- ================= CCTV SERVICES CONTENT ================= -->
<section>

<div class="max-w-6xl mx-auto px-6 py-10">

    <h2 class="text-4xl font-bold text-center mb-12">
        CCTV Services We Offer
    </h2>

    <?php while($img = $images->fetch_assoc()): ?>

        <div class="grid md:grid-cols-3 gap-6 items-center mb-8 bg-white rounded-xl shadow-md border overflow-hidden hover:shadow-xl transition duration-300">

            <!-- LEFT DESCRIPTION -->
            <div class="md:col-span-2 p-6">

                <h3 class="text-2xl font-bold text-blue-700 mb-3">
                    <?= htmlspecialchars($img['image_title']); ?>
                </h3>

                <p class="text-gray-600 leading-relaxed text-justify">
                    <?= htmlspecialchars($img['image_description']); ?>
                </p>

            </div>

            <!-- RIGHT IMAGE -->
            <div class="p-4">

                <div class="w-full h-48 bg-gray-100 rounded-xl overflow-hidden border shadow-sm">

                    <img
                        src="uploads/<?= htmlspecialchars($img['image_path']); ?>"
                        alt="<?= htmlspecialchars($img['image_title']); ?>"
                        class="w-full h-full object-cover hover:scale-105 transition duration-300">

                </div>

            </div>

        </div>

    <?php endwhile; ?>

</div>

</section>

  <!-- REQUEST MODAL -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-lg w-96 shadow-lg">

        <h2 class="text-2xl font-bold mb-4">
            TV Service Request
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
        value="<?php echo $TV_SERVICE_ID ?>">
    

    <!-- Submit Button -->
    <button
        type="submit"
        name="submit_request"
        class="w-full bg-yellow-500 hover:bg-yellow-400 text-black py-3 rounded-lg font-bold transition duration-300 shadow-md hover:shadow-lg">

        Submit Request

    </button>

</form>

        <button
            onclick="closeModal()"
            class="mt-3 text-red-500 font-semibold"
        >
            Close
        </button>

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

    if (event.target === modal) {
        closeModal();
    }
}
</script>

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