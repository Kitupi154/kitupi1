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
<footer class="bg-black text-white text-center p-6 mt-10">
    <p>© 2026 Amosi Technical Services | TV Division</p>
</footer>

<script>
function openModal(){
    document.getElementById("modal").classList.add("show");
}
function closeModal(){
    document.getElementById("modal").classList.remove("show");
}
</script>

</body>
</html>