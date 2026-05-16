<?php
include "db.php";

$success = "";
$error = "";

// FETCH SETTINGS
$settingsQuery = mysqli_query($conn, "SELECT * FROM settings LIMIT 1");
$settings = mysqli_fetch_assoc($settingsQuery);

// FETCH AVAILABLE SERVICES
$servicesQuery = mysqli_query(
    $conn,
    "SELECT * FROM services WHERE status='Available' ORDER BY service_name ASC"
);

// HANDLE CONTACT FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_message'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $service_type = mysqli_real_escape_string($conn, $_POST['service_type']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (
        !empty($full_name) &&
        !empty($service_type) &&
        !empty($message)
    ) {

        $insert = mysqli_query($conn, "
            INSERT INTO contact_messages
            (
                full_name,
                phone,
                email,
                service_type,
                message,
                status,
                sent_at
            )
            VALUES
            (
                '$full_name',
                '$phone',
                '$email',
                '$service_type',
                '$message',
                'Unread',
                NOW()
            )
        ");

        if ($insert) {
            $success = "Message sent successfully!";
        } else {
            $error = "Failed to send message.";
        }

    } else {
        $error = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-highest": "#e4e2e4",
                        "on-tertiary-fixed": "#271901",
                        "secondary-fixed-dim": "#62df7d",
                        "inverse-surface": "#303032",
                        "surface-container": "#f0edef",
                        "outline": "#76777d",
                        "background": "#fcf8fa",
                        "inverse-primary": "#bec6e0",
                        "secondary-container": "#7cf994",
                        "secondary": "#006e2d",
                        "on-tertiary-fixed-variant": "#574425",
                        "on-secondary": "#ffffff",
                        "surface-container-low": "#f6f3f5",
                        "tertiary": "#000000",
                        "error": "#ba1a1a",
                        "on-error-container": "#93000a",
                        "error-container": "#ffdad6",
                        "surface-dim": "#dcd9db",
                        "on-primary-fixed": "#131b2e",
                        "on-tertiary": "#ffffff",
                        "primary": "#000000",
                        "surface-tint": "#565e74",
                        "on-tertiary-container": "#98805d",
                        "on-surface": "#1b1b1d",
                        "primary-fixed": "#dae2fd",
                        "on-surface-variant": "#45464d",
                        "on-primary": "#ffffff",
                        "surface-variant": "#e4e2e4",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-container": "#7c839b",
                        "on-secondary-fixed-variant": "#005320",
                        "on-secondary-container": "#007230",
                        "tertiary-fixed-dim": "#dec29a",
                        "surface-container-high": "#eae7e9",
                        "surface": "#fcf8fa",
                        "on-background": "#1b1b1d",
                        "tertiary-container": "#271901",
                        "secondary-fixed": "#7ffc97",
                        "on-error": "#ffffff",
                        "outline-variant": "#c6c6cd",
                        "primary-fixed-dim": "#bec6e0",
                        "on-secondary-fixed": "#002109",
                        "inverse-on-surface": "#f3f0f2",
                        "primary-container": "#131b2e",
                        "tertiary-fixed": "#fcdeb5",
                        "surface-bright": "#fcf8fa",
                        "on-primary-fixed-variant": "#3f465c"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "sm": "12px",
                        "lg": "24px",
                        "md": "16px",
                        "xl": "32px",
                        "base": "4px",
                        "xxl": "48px",
                        "container_max": "1280px",
                        "xs": "8px"
                    },
                    "fontFamily": {
                        "section-title": ["Inter"],
                        "page-title": ["Inter"],
                        "hero-title": ["Inter"],
                        "card-title": ["Inter"],
                        "small-label": ["Inter"],
                        "body-text": ["Inter"]
                    },
                    "fontSize": {
                        "section-title": ["28px", {"lineHeight": "1.3", "fontWeight": "600"}],
                        "page-title": ["36px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "hero-title": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "card-title": ["22px", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "small-label": ["13px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "body-text": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface font-body-text text-on-surface antialiased">
<!-- TopNavBar -->
<div class="bg-gray text-black shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">

        <h1 class="text-xl font-bold tracking-wide">
           MR AMOSI SERVICES TECHNICAL SERVICES
        </h1>

        <div class="flex gap-3 items-center">

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="customer.php">Home</a>

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="satellite.php">services</a>

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="about.php">about us</a>

            <a class="px-4 py-2 rounded-lg bg-white-600 hover:bg-gray-500 transition"
               href="contactus.php">contact us</a>

        </div>
    </div>
<!-- Mobile Menu Toggle (Simplified) -->
<button class="md:hidden material-symbols-outlined text-primary">menu</button>
</nav>
</header>
<main>
<!-- Hero Section -->
<!-- Hero Section -->
<section class="relative min-h-[70vh] flex items-center overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0">
       <img 
    src="https://images.pexels.com/photos/257736/pexels-photo-257736.jpeg"
    class="w-full h-full object-cover"
    alt="Technical installation background"
/>
        />
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Content -->
    <div class="relative max-w-container_max mx-auto px-lg w-full">

        <div class="max-w-3xl text-white space-y-md">

            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                Reliable Technical Services You Can Trust
            </h1>

            <p class="text-lg text-white/80 leading-relaxed">
                We provide professional installation, repair, and maintenance services for satellite systems, CCTV, electrical setups, and home entertainment systems across Dar es Salaam.
            </p>

            <div class="flex flex-wrap gap-3 mt-6">

             

                <a href="satellite.php"
                   class="bg-white/10 hover:bg-white/20 px-6 py-3 rounded-lg font-semibold transition backdrop-blur">
                    View Services
                </a>

            </div>

        </div>

    </div>

</section>
<!-- Contact Cards Section -->
<!-- Contact Cards Section -->
<section class="max-w-container_max mx-auto px-lg -mt-12 relative z-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">

        <!-- Phone Card -->
        <div class="bg-surface-container-lowest p-lg rounded-xl shadow-md border border-outline-variant hover:shadow-lg transition-shadow">
            <div class="bg-secondary-container w-12 h-12 rounded-lg flex items-center justify-center mb-md">
                <span class="material-symbols-outlined text-on-secondary-container">call</span>
            </div>

            <h3 class="font-card-title text-card-title text-primary mb-xs">
                Phone
            </h3>

            <p class="font-body-text text-body-text text-on-surface-variant">
                <?= htmlspecialchars($settings['phone']); ?>
            </p>
        </div>

        <!-- Email Card -->
        <div class="bg-surface-container-lowest p-lg rounded-xl shadow-md border border-outline-variant hover:shadow-lg transition-shadow">
            <div class="bg-secondary-container w-12 h-12 rounded-lg flex items-center justify-center mb-md">
                <span class="material-symbols-outlined text-on-secondary-container">
                    mail
                </span>
            </div>

            <h3 class="font-card-title text-card-title text-primary mb-xs">
                Email
            </h3>

            <p class="font-body-text text-body-text text-on-surface-variant">
                <?= htmlspecialchars($settings['email']); ?>
            </p>
        </div>

        <!-- Location Card -->
        <div class="bg-surface-container-lowest p-lg rounded-xl shadow-md border border-outline-variant hover:shadow-lg transition-shadow">
            <div class="bg-secondary-container w-12 h-12 rounded-lg flex items-center justify-center mb-md">
                <span class="material-symbols-outlined text-on-secondary-container">
                    location_on
                </span>
            </div>

            <h3 class="font-card-title text-card-title text-primary mb-xs">
                Location
            </h3>

            <p class="font-body-text text-body-text text-on-surface-variant">
                <?= htmlspecialchars($settings['location']); ?>
            </p>
        </div>

        <!-- WhatsApp Card -->
        <div class="bg-surface-container-lowest p-lg rounded-xl shadow-md border border-outline-variant hover:shadow-lg transition-shadow">
            <div class="bg-secondary-container w-12 h-12 rounded-lg flex items-center justify-center mb-md">
                <span class="material-symbols-outlined text-on-secondary-container"
                      style="font-variation-settings: 'FILL' 1;">
                    chat
                </span>
            </div>

            <h3 class="font-card-title text-card-title text-primary mb-xs">
                WhatsApp
            </h3>

            <p class="font-body-text text-body-text text-on-surface-variant">
                <?= htmlspecialchars($settings['phone']); ?>
            </p>

            <p class="font-small-label text-small-label text-secondary mt-xs font-bold uppercase tracking-wider">
                Online Now
            </p>
        </div>

    </div>
</section>


<!-- Form and FAQ Section -->
<!-- Form and FAQ Section -->
<section class="max-w-container_max mx-auto px-lg py-xxl">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-xxl items-start">

        <!-- Contact Form -->
        <div class="lg:col-span-7 bg-surface-container-lowest p-xl rounded-xl shadow-md border border-outline-variant">

            <h2 class="font-section-title text-section-title text-primary mb-lg">
                Send us a Message
            </h2>

            <?php if($success): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 border border-green-300">
                <?= $success ?>
            </div>
            <?php endif; ?>

            <?php if($error): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4 border border-red-300">
                <?= $error ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-lg">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">

                    <!-- Full Name -->
                    <div class="space-y-xs">
                        <label class="font-small-label text-small-label text-on-surface-variant uppercase">
                            Full Name
                        </label>

                        <input
                            name="full_name"
                            class="w-full bg-surface-container border border-outline-variant rounded-lg px-md py-sm focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none"
                            placeholder="John Doe"
                            type="text"
                            required
                        />
                    </div>

                    <!-- Email -->
                    <div class="space-y-xs">
                        <label class="font-small-label text-small-label text-on-surface-variant uppercase">
                            Email Address
                        </label>

                        <input
                            name="email"
                            class="w-full bg-surface-container border border-outline-variant rounded-lg px-md py-sm focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none"
                            placeholder="john@example.com"
                            type="email"
                        />
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">

                    <!-- Phone -->
                    <div class="space-y-xs">
                        <label class="font-small-label text-small-label text-on-surface-variant uppercase">
                            Phone Number
                        </label>

                        <input
                            name="phone"
                            class="w-full bg-surface-container border border-outline-variant rounded-lg px-md py-sm focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none"
                            placeholder="+255..."
                            type="tel"
                        />
                    </div>

                    <!-- Service Type -->
                    <div class="space-y-xs">
                        <label class="font-small-label text-small-label text-on-surface-variant uppercase">
                            Service Type
                        </label>

                        <select
                            name="service_type"
                            class="w-full bg-surface-container border border-outline-variant rounded-lg px-md py-sm focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none"
                            required
                        >
                            <option value="">
                                Select Service
                            </option>

                            <?php while($service = mysqli_fetch_assoc($servicesQuery)): ?>
                                <option value="<?= $service['service_name']; ?>">
                                    <?= $service['service_name']; ?>
                                </option>
                            <?php endwhile; ?>

                        </select>
                    </div>

                </div>

                <!-- Message -->
                <div class="space-y-xs">
                    <label class="font-small-label text-small-label text-on-surface-variant uppercase">
                        Your Message
                    </label>

                    <textarea
                        name="message"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-md py-sm focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none resize-none"
                        placeholder="Please describe your technical requirement in detail..."
                        rows="5"
                        required
                    ></textarea>
                </div>

                <!-- Button -->
                <button
                    name="submit_message"
                    type="submit"
                    class="w-full md:w-auto bg-primary-container text-white font-bold py-md px-xl rounded-lg hover:bg-opacity-90 transition-all scale-100 active:scale-95 shadow-md"
                >
                    Submit Inquiry
                </button>

            </form>

        </div>

        <!-- FAQ -->
        <div class="lg:col-span-5 space-y-lg">

            <h2 class="font-section-title text-section-title text-primary">
                Technical FAQs
            </h2>

            <div class="space-y-md">

                <div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
                    <h4 class="font-card-title text-card-title text-primary text-lg mb-xs">
                        What is your response time for emergencies?
                    </h4>

                    <p class="font-body-text text-body-text text-on-surface-variant">
                        We respond quickly to urgent technical service requests.
                    </p>
                </div>

                <div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
                    <h4 class="font-card-title text-card-title text-primary text-lg mb-xs">
                        Do you provide maintenance services?
                    </h4>

                    <p class="font-body-text text-body-text text-on-surface-variant">
                        Yes, we provide installation, repair and maintenance.
                    </p>
                </div>

                <div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
                    <h4 class="font-card-title text-card-title text-primary text-lg mb-xs">
                        Are your technicians experienced?
                    </h4>

                    <p class="font-body-text text-body-text text-on-surface-variant">
                        Yes, our technicians are highly experienced and professional.
                    </p>
                </div>

            </div>

        </div>

    </div>
</section>

  

<!-- Map Section -->
 <!-- Map Section -->
<section class="max-w-container_max mx-auto px-lg pb-xxl">
    
    <h2 class="font-section-title text-section-title text-primary mb-lg">
        Our Location
    </h2>

    <div class="relative w-full h-[400px] rounded-xl overflow-hidden shadow-md border border-outline-variant">

        <iframe
            class="w-full h-full"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=Goba+Matosha+Ward+Dar+es+Salaam+Tanzania&output=embed">
        </iframe>

        <!-- Floating info card -->
        <div class="absolute bottom-4 left-4 bg-white p-4 rounded-xl shadow-lg border">
            <h3 class="font-bold text-primary">MR AMOSI TECHNICAL SERVICES</h3>
            <p class="text-sm text-gray-600">
                Goba – Matosa Ward, Dar es Salaam
            </p>
        </div>

    </div>
</section>


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