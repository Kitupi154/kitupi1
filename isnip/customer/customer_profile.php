<?php
session_start();
include("registrations/db.php");

// Check if customer is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch customer profile data
$query = mysqli_query($conn, "
    SELECT users.*, customers.*
    FROM users
    INNER JOIN customers 
    ON users.user_id = customers.user_id
    WHERE users.user_id = '$user_id'
");

$customer = mysqli_fetch_assoc($query);

// Update profile photo
if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0){

    $upload_dir = "uploads/";

    // Create uploads folder if it doesn't exist
    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES['profile_photo']['name']);
    $target_file = $upload_dir . $file_name;

    // Allowed image types
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if(in_array($file_ext, $allowed)){

        if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)){

            // Save path in database
            mysqli_query($conn, "
                UPDATE users 
                SET profile_photo='$target_file'
                WHERE user_id='$user_id'
            ");

            // Refresh page
            header("Location: customer_profile.php");
            exit();
        }
    }
}
// UPDATE PROFILE DATA
if (isset($_POST['update_profile'])) {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $nationality = $_POST['nationality'];
    $id_number = $_POST['id_number'];
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];

    // users table
    mysqli_query($conn, "
        UPDATE users SET
        full_name='$full_name',
        email='$email',
        phone='$phone'
        WHERE user_id='$user_id'
    ");

    // customers table
    mysqli_query($conn, "
        UPDATE customers SET
        nationality='$nationality',
        id_number='$id_number',
        company_name='$company_name',
        address='$address'
        WHERE user_id='$user_id'
    ");

    header("Location: customer_profile.php");
    exit();
}
?>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<title>ISNIS | Customer Profile Management</title>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff",
                        "tertiary-container": "#004f7f",
                        "surface-container-highest": "#dce3ec",
                        "primary-fixed": "#d7e2ff",
                        "on-background": "#151c22",
                        "on-primary-fixed-variant": "#00458f",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#98cbff",
                        "surface-dim": "#d4dbe3",
                        "secondary": "#5d5f5f",
                        "tertiary-fixed": "#cfe5ff",
                        "background": "#f6f9ff",
                        "primary": "#00346f",
                        "outline-variant": "#c2c6d3",
                        "on-surface-variant": "#424751",
                        "on-tertiary": "#ffffff",
                        "surface-tint": "#255dad",
                        "on-secondary-fixed": "#1a1c1c",
                        "error-container": "#ffdad6",
                        "on-primary-container": "#9bbdff",
                        "surface-variant": "#dce3ec",
                        "primary-fixed-dim": "#abc7ff",
                        "secondary-fixed-dim": "#c6c6c7",
                        "surface": "#f6f9ff",
                        "secondary-container": "#dfe0e0",
                        "on-secondary-container": "#616363",
                        "on-primary-fixed": "#001b3f",
                        "secondary-fixed": "#e2e2e2",
                        "surface-container-high": "#e2e9f1",
                        "on-secondary-fixed-variant": "#454747",
                        "surface-bright": "#f6f9ff",
                        "outline": "#737783",
                        "on-surface": "#151c22",
                        "surface-container-low": "#eef4fd",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#001d33",
                        "tertiary": "#00385c",
                        "inverse-on-surface": "#ebf1fa",
                        "primary-container": "#004a99",
                        "on-tertiary-container": "#82c2ff",
                        "inverse-surface": "#2a3138",
                        "on-error": "#ffffff",
                        "inverse-primary": "#abc7ff",
                        "on-tertiary-fixed-variant": "#004a77",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "surface-container": "#e8eef7"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "16px",
                        "lg": "24px",
                        "gutter": "16px",
                        "xs": "4px",
                        "sm": "12px",
                        "base": "8px",
                        "margin-desktop": "32px",
                        "md": "16px",
                        "xl": "32px"
                    },
                    "fontFamily": {
                        "headline-lg-mobile": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-sm": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "headline-md": ["Inter"],
                        "body-md": ["Inter"],
                        "display-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
<style>
        body { background-color: #f6f9ff; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #dfe0e0; border-radius: 10px; }
        .glass-panel {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.7);
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>

<!-- TopAppBar -->

<body class="font-body-md text-on-surface overflow-x-hidden">

<!-- <?php include("includes/header.php"); ?>

<?php include("includes/sidebar.php"); ?> -->


<main class="lg:ml-[260px] pt-16 min-h-screen px-margin-mobile md:px-margin-desktop py-lg">

<div class="max-w-6xl mx-auto">

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-lg mb-xl">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-primary mb-xs">
            Customer Profile
        </h2>
        <p class="font-body-md text-on-surface-variant">
            Manage your corporate credentials and shipping preferences.
        </p>
    </div>

   <div class="flex gap-sm">

    <button onclick="openModal()" class="flex items-center gap-sm px-lg py-sm border border-primary text-primary rounded-lg">
        <span class="material-symbols-outlined text-sm">edit</span>
        Edit Profile
    </button>

    <button onclick="openModal()" class="flex items-center gap-sm px-lg py-sm bg-primary-container text-on-primary rounded-lg">
        Update Information
    </button>

</div>

<!-- EDIT PROFILE MODAL -->
<div id="profileModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl p-lg relative">

        <!-- CLOSE -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-xl">✖</button>

        <h2 class="text-xl font-bold text-primary mb-md">Edit Profile</h2>

        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-md">

            <input name="full_name" class="input" value="<?php echo $customer['full_name']; ?>" placeholder="Full Name">

            <input name="email" class="input" value="<?php echo $customer['email']; ?>" placeholder="Email">

            <input name="phone" class="input" value="<?php echo $customer['phone']; ?>" placeholder="Phone">

            <input name="nationality" class="input" value="<?php echo $customer['nationality']; ?>" placeholder="Nationality">

            <input name="id_number" class="input" value="<?php echo $customer['id_number']; ?>" placeholder="ID Number">

            <input name="company_name" class="input md:col-span-2" value="<?php echo $customer['company_name']; ?>" placeholder="Company Name">

            <textarea name="address" class="input md:col-span-2" rows="3"><?php echo $customer['address']; ?></textarea>

            <div class="md:col-span-2 flex justify-end gap-sm mt-md">

                <button type="button" onclick="closeModal()" class="px-md py-sm border rounded-lg">
                    Cancel
                </button>

                <button type="submit" name="update_profile" class="px-md py-sm bg-primary text-white rounded-lg">
                    Save Changes
                </button>

            </div>

        </form>

    </div>
</div>

</div>

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-lg">

<!-- LEFT SIDE -->
<div class="md:col-span-4 flex flex-col gap-lg">

    <!-- PROFILE CARD -->
    <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.04)]">

        <div class="flex flex-col items-center text-center mb-lg">

            <!-- PROFILE IMAGE + UPLOAD -->
            <div class="relative mb-md">

                <img
                    class="w-32 h-32 rounded-full object-cover border-4 border-surface shadow-lg"
                    src="<?php echo !empty($customer['profile_photo']) ? $customer['profile_photo'] : 'uploads/default.png'; ?>"
                >

                <form method="POST" enctype="multipart/form-data">

                    <input
                        type="file"
                        name="profile_photo"
                        id="profile_photo_input"
                        class="hidden"
                        accept="image/*"
                        onchange="this.form.submit()"
                    >

                    <button
                        type="button"
                        onclick="document.getElementById('profile_photo_input').click();"
                        class="absolute bottom-1 right-1 bg-primary text-on-primary p-xs rounded-full shadow-lg hover:scale-110 transition-transform"
                    >
                        <span class="material-symbols-outlined text-base">photo_camera</span>
                    </button>

                </form>
            </div>

            <!-- NAME -->
            <h3 class="font-headline-sm text-headline-sm text-primary">
                <?php echo htmlspecialchars($customer['full_name']); ?>
            </h3>

            <!-- ROLE -->
            <p class="font-body-sm text-on-surface-variant font-medium">
                <?php echo ucfirst($customer['role']); ?>
            </p>

        </div>

        <!-- COMPANY + STATUS -->
        <div class="space-y-md">

            <div class="flex items-center gap-md">
                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-sm">apartment</span>
                </div>

                <div>
                    <p class="font-label-md text-outline">COMPANY</p>
                    <p class="font-body-md text-on-surface font-semibold">
                        <?php echo !empty($customer['company_name']) ? $customer['company_name'] : 'Not Set'; ?>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-md">
                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-sm">verified_user</span>
                </div>

                <div>
                    <p class="font-label-md text-outline">ACCOUNT STATUS</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                        <?php echo ucfirst($customer['status']); ?>
                    </span>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- RIGHT SIDE -->
<div class="md:col-span-8 flex flex-col gap-lg">

    <!-- GENERAL INFO -->
    <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.04)]">

        <h3 class="font-headline-sm text-headline-sm text-primary mb-lg">
            General Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">

            <input class="input" readonly value="<?php echo $customer['full_name']; ?>">
            <input class="input" readonly value="<?php echo $customer['email']; ?>">
            <input class="input" readonly value="<?php echo $customer['phone']; ?>">
            <input class="input" readonly value="<?php echo $customer['nationality']; ?>">
            <input class="input" readonly value="<?php echo $customer['id_number']; ?>">

            <div class="md:col-span-2">
                <textarea class="w-full px-md py-sm border border-outline-variant rounded-lg" rows="2" readonly><?php echo $customer['address']; ?></textarea>
            </div>

        </div>
    </div>

    <!-- SHIPMENT HISTORY (UNCHANGED UI) -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.04)] overflow-hidden">

        <div class="p-lg border-b border-outline-variant flex justify-between items-center">
            <h3 class="font-headline-sm text-headline-sm text-primary">
                Recent Shipment History
            </h3>
            <button class="text-primary font-body-sm font-semibold hover:underline">
                View All Records
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="px-lg py-md">VESSEL / ID</th>
                        <th class="px-lg py-md">DESTINATION</th>
                        <th class="px-lg py-md">STATUS</th>
                        <th class="px-lg py-md text-right">DATE</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- STATIC UI KEPT AS YOU HAD IT -->
                    <tr>
                        <td class="px-lg py-md">Atlantic Voyager</td>
                        <td class="px-lg py-md">Rotterdam</td>
                        <td class="px-lg py-md">DELIVERED</td>
                        <td class="px-lg py-md text-right">Oct 12</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

</div>
</div>
</main>
<script>
        // Simple micro-interaction for form focus states and transitions
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('focus', () => {
                el.parentElement.classList.add('scale-[1.01]');
            });
            el.addEventListener('blur', () => {
                el.parentElement.classList.remove('scale-[1.01]');
            });
        });

        // Mobile Menu Toggle logic
        const menuBtn = document.querySelector('header .material-symbols-outlined');
        const sidebar = document.querySelector('aside');
        
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

    <script>
function openModal() {
    document.getElementById('profileModal').classList.remove('hidden');
    document.getElementById('profileModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.getElementById('profileModal').classList.remove('flex');
}
</script>
</body></html>