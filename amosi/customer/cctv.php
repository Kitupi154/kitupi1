<?php

include("db.php");

$CCTV_SERVICE_ID = 3;

$success = false;
$error = "";

/* =========================
   HANDLE FORM SUBMISSION
========================= */

if(isset($_POST['submit_request'])){

    $customer_name  = trim($_POST['customer_name'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $location       = trim($_POST['location'] ?? '');
    $request_details= trim($_POST['request_details'] ?? '');
    $service_id     = (int)($_POST['service_id'] ?? 0);

    /* VALIDATION */

    if(
        empty($customer_name) ||
        empty($phone) ||
        empty($request_details)
    ){
        $error = "Please fill all required fields.";
    }

    elseif($service_id <= 0){
        $error = "Invalid service selected.";
    }

    else{

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
            (
                ?, ?, ?, ?, ?, ?,
                'Pending',
                NOW()
            )
        ");

        if(!$stmt){

            $error = "Prepare Failed: " . $conn->error;

        }else{

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

            }else{

                $error = "Execute Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

/* =========================
   FETCH SERVICE DETAILS
========================= */

$serviceQuery = $conn->query("
    SELECT *
    FROM services
    WHERE service_id = $CCTV_SERVICE_ID
");

$service = $serviceQuery->fetch_assoc();

/* =========================
   FETCH CCTV IMAGES
========================= */

$imagesQuery = mysqli_query(
    $conn,
    "SELECT *
     FROM service_images
     WHERE service_id = 3
     ORDER BY image_id ASC"
);
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
    <?php if($success): ?>
<div class="bg-green-600 text-white text-center py-3">
    Request submitted successfully!
</div>
<?php endif; ?>

<?php if($error): ?>
<div class="bg-red-600 text-white text-center py-3">
    <?php echo $error; ?>
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
        CCTV Installation & Security Systems
    </h1>

    <p class="text-2xl mb-2">
        Professional Surveillance & Security Solutions
    </p>

    <p class="text-lg max-w-2xl text-gray-200">
        We provide CCTV installation, configuration, maintenance, and security monitoring
        for homes, offices, and commercial buildings.
    </p>

  <button type="button"
        onclick="openModal()"
        class="bg-yellow-500 text-black px-6 py-3 rounded font-bold hover:bg-yellow-400 transition">
    Request Service
</button>

</div>
</section>


<section class="bg-gray-100 py-12">

<div class="max-w-6xl mx-auto text-center mb-12">

    <h2 class="text-4xl font-bold">
        CCTV Services We Offer
    </h2>

    <p class="text-gray-600 mt-3">
        Professional CCTV installation, maintenance,
        configuration and remote monitoring services.
    </p>

</div>

<?php if($imagesQuery && mysqli_num_rows($imagesQuery) > 0): ?>

<?php
$count = 0;
while($img = mysqli_fetch_assoc($imagesQuery)):
$count++;
?>

<div class="max-w-6xl mx-auto px-6 py-8">

    <div class="grid md:grid-cols-2 gap-10 items-center bg-white rounded-2xl shadow-md overflow-hidden">

        <?php if($count % 2 != 0): ?>

            <!-- TEXT -->
            <div class="p-8">
                <h3 class="text-3xl font-bold text-blue-700 mb-4">
                    <?= htmlspecialchars($img['image_title']); ?>
                </h3>

                <p class="text-gray-600 leading-8 text-justify">
                    <?= htmlspecialchars($img['image_description']); ?>
                </p>
            </div>

            <!-- IMAGE -->
            <div class="p-6 flex justify-center">
                <div class="w-full max-w-md h-64 rounded-xl overflow-hidden shadow-lg">
                    <img src="uploads/<?= htmlspecialchars($img['image_path']); ?>"
                         class="w-full h-full object-cover">
                </div>
            </div>

        <?php else: ?>

            <!-- IMAGE -->
            <div class="p-6 flex justify-center">
                <div class="w-full max-w-md h-64 rounded-xl overflow-hidden shadow-lg">
                    <img src="uploads/<?= htmlspecialchars($img['image_path']); ?>"
                         class="w-full h-full object-cover">
                </div>
            </div>

            <!-- TEXT -->
            <div class="p-8">
                <h3 class="text-3xl font-bold text-blue-700 mb-4">
                    <?= htmlspecialchars($img['image_title']); ?>
                </h3>

                <p class="text-gray-600 leading-8 text-justify">
                    <?= htmlspecialchars($img['image_description']); ?>
                </p>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php endwhile; ?>

<?php else: ?>

<div class="text-center py-20">
    <h3 class="text-2xl font-bold text-gray-500">
        No CCTV Images Found
    </h3>
</div>

<?php endif; ?>


</section>


   <!-- MODAL -->
<div id="modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-xl relative">

        <button type="button"
                onclick="closeModal()"
                class="absolute top-3 right-4 text-xl text-gray-500 hover:text-red-500">
            &times;
        </button>

        <h2 class="text-2xl font-bold mb-4">Request Service</h2>

       
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
        value="<?php echo $CCTV_SERVICE_ID ?>">
    

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
    document.getElementById("modal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("modal").classList.add("hidden");
}

window.onclick = function(e) {
    let modal = document.getElementById("modal");
    if (e.target === modal) {
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