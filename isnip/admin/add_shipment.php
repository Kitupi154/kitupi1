<?php
session_start();
include("../customer/registrations/db.php");

/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {
    header("Location: ../customer/registrations/login1.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| FETCH DROPDOWN DATA
|--------------------------------------------------------------------------
*/

// Customers
$customersQuery = mysqli_query($conn, "
    SELECT 
        c.customer_id,
        u.full_name
    FROM customers c
    INNER JOIN users u 
    ON c.user_id = u.user_id
");

// Vessels
$vesselsQuery = mysqli_query($conn, "
    SELECT *
    FROM vessels
    WHERE status='active'
");

// Ports
$portsQuery = mysqli_query($conn, "
    SELECT *
    FROM ports
");

/*
|--------------------------------------------------------------------------
| CREATE SHIPMENT
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tracking_number = 'MC-' . rand(100000, 999999);

    $customer_id = $_POST['customer_id'];
    $cargo_type = $_POST['cargo_type'];
    $weight = $_POST['weight'];
    $container_number = $_POST['container_number'];
    $vessel_id = $_POST['vessel_id'];
    $departure_port_id = $_POST['departure_port_id'];
    $destination_port_id = $_POST['destination_port_id'];
    $departure_date = $_POST['departure_date'];
    $estimated_arrival = $_POST['estimated_arrival'];
    $shipment_status = $_POST['shipment_status'];

    $insert = mysqli_query($conn, "
        INSERT INTO shipments (
            tracking_number,
            customer_id,
            vessel_id,
            departure_port_id,
            destination_port_id,
            cargo_type,
            container_number,
            weight,
            departure_date,
            estimated_arrival,
            shipment_status
        )
        VALUES (
            '$tracking_number',
            '$customer_id',
            '$vessel_id',
            '$departure_port_id',
            '$destination_port_id',
            '$cargo_type',
            '$container_number',
            '$weight',
            '$departure_date',
            '$estimated_arrival',
            '$shipment_status'
        )
    ");

if($insert){
    header("Location: shipment_management.php?success=1");
    exit();
} else {
    echo "Database Error: " . mysqli_error($conn);
}
    }

?>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Register New Shipment | MARITIME CONNECT</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary": "#ffffff",
                        "surface-container": "#e8eef7",
                        "primary-fixed": "#d7e2ff",
                        "tertiary-container": "#004f7f",
                        "tertiary-fixed-dim": "#98cbff",
                        "on-secondary-container": "#616363",
                        "surface-tint": "#255dad",
                        "surface-container-high": "#e2e9f1",
                        "on-surface-variant": "#424751",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed": "#1a1c1c",
                        "on-secondary-fixed-variant": "#454747",
                        "on-tertiary-container": "#82c2ff",
                        "surface-bright": "#f6f9ff",
                        "inverse-surface": "#2a3138",
                        "surface": "#f6f9ff",
                        "primary-fixed-dim": "#abc7ff",
                        "on-error": "#ffffff",
                        "on-primary-container": "#9bbdff",
                        "on-tertiary-fixed": "#001d33",
                        "inverse-on-surface": "#ebf1fa",
                        "secondary-fixed": "#e2e2e2",
                        "outline-variant": "#c2c6d3",
                        "secondary-fixed-dim": "#c6c6c7",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#dce3ec",
                        "on-background": "#151c22",
                        "primary-container": "#004a99",
                        "surface-container-low": "#eef4fd",
                        "outline": "#737783",
                        "on-surface": "#151c22",
                        "tertiary": "#00385c",
                        "background": "#f6f9ff",
                        "inverse-primary": "#abc7ff",
                        "tertiary-fixed": "#cfe5ff",
                        "error-container": "#ffdad6",
                        "secondary": "#5d5f5f",
                        "on-primary-fixed-variant": "#00458f",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#d4dbe3",
                        "surface-variant": "#dce3ec",
                        "error": "#ba1a1a",
                        "secondary-container": "#dfe0e0",
                        "on-tertiary-fixed-variant": "#004a77",
                        "primary": "#00346f",
                        "on-primary-fixed": "#001b3f"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.8px",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "16px",
                        "gutter": "16px",
                        "base": "8px",
                        "margin-mobile": "16px",
                        "xl": "32px",
                        "sm": "12px",
                        "xs": "4px",
                        "lg": "24px",
                        "margin-desktop": "32px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Inter"],
                        "headline-sm": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "body-sm": ["Inter"],
                        "display-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f6f9ff;
            font-family: 'Inter', sans-serif;
        }
        .form-input-focus:focus {
            outline: none;
            box-shadow: 0 0 0 2px #004A99;
            border-color: transparent;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="text-on-surface">
<header class="bg-surface dark:bg-surface-dim border-b border-outline-variant dark:border-outline shadow-sm flex items-center justify-between px-4 h-16 w-full z-40 fixed top-0 left-0">
<div class="flex items-center gap-md">
<button class="p-2 hover:bg-surface-container dark:hover:bg-surface-container-high transition-colors rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-primary dark:text-primary-fixed">menu</span>
</button>
<h1 class="font-headline-sm text-headline-sm font-bold tracking-tight text-primary dark:text-primary-fixed">MARITIME CONNECT</h1>
</div>
<div class="flex items-center gap-sm">
<button class="p-2 hover:bg-surface-container transition-colors rounded-full">
<span class="material-symbols-outlined text-on-surface-variant">search</span>
</button>
<div class="h-8 w-8 rounded-full bg-primary-container flex items-center justify-center text-white font-semibold">JD</div>
</div>
</header>
<main class="pt-24 pb-16 px-gutter max-w-5xl mx-auto">
<div class="mb-lg">
<div class="flex items-center gap-xs text-on-surface-variant mb-xs">
<span class="material-symbols-outlined text-[18px]">inventory_2</span>
<span class="font-label-md text-label-md">SHIPMENT MANAGEMENT</span>
</div>
<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Register New Shipment</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Initialize a new cargo transport record in the Maritime Connect global ledger.</p>
</div>
<section class="bg-surface-container-lowest border border-outline-variant shadow-[0_4px_12px_0_rgba(0,0,0,0.04)] rounded-xl p-lg">
<!-- 

form details -->
<form action="" class="grid grid-cols-1 md:grid-cols-2 gap-lg" method="POST">
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">Customer Name</label>
<div class="relative">
<select name="customer_id" class="appearance-none w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white" required>

<option value="">Select Customer</option>

<?php while($customer = mysqli_fetch_assoc($customersQuery)): ?>

<option value="<?php echo $customer['customer_id']; ?>">
    <?php echo $customer['full_name']; ?>
</option>

<?php endwhile; ?>

</select>

<span class="material-symbols-outlined absolute right-md top-1/2 -translate-y-1/2 text-outline">
expand_more
</span>
</div>

</div>

<!-- Cargo Type -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Cargo Type
</label>

<div class="relative">
<select name="cargo_type"
class="appearance-none w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required>

<option disabled selected value="">
Select cargo type
</option>

<option value="dry_bulk">Dry Bulk</option>
<option value="liquid_bulk">Liquid Bulk</option>
<option value="containerized">Containerized</option>
<option value="reefer">Reefer (Refrigerated)</option>
<option value="ro-ro">Ro-Ro (Vehicles)</option>

</select>

<span class="material-symbols-outlined absolute right-md top-1/2 -translate-y-1/2 pointer-events-none text-outline">
expand_more
</span>
</div>
</div>

<!-- Weight -->
<div class="flex flex-col gap-xs md:col-span-1">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Weight (MT)
</label>

<div class="relative">
<input
name="weight"
class="w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
placeholder="0.00"
required
step="0.01"
type="number"
/>

<span class="absolute right-md top-1/2 -translate-y-1/2 text-outline font-label-md text-label-md">
METRIC TONS
</span>
</div>
</div>

<!-- Container Number -->
<div class="flex flex-col gap-xs md:col-span-1">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Container Number
</label>

<input
name="container_number"
class="h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
placeholder="e.g. MSKU1234567"
type="text"
/>
</div>

<!-- Vessel Selection -->
<div class="flex flex-col gap-xs md:col-span-2">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Vessel Selection
</label>

<div class="relative">

<select
name="vessel_id"
class="appearance-none w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required>

<option disabled selected value="">
Search for active vessels...
</option>

<?php while($vessel = mysqli_fetch_assoc($vesselsQuery)): ?>

<option value="<?php echo $vessel['vessel_id']; ?>">
    <?php echo $vessel['vessel_name']; ?>
</option>

<?php endwhile; ?>

</select>

<span class="material-symbols-outlined absolute right-md top-1/2 -translate-y-1/2 pointer-events-none text-outline">
directions_boat
</span>

</div>
</div>

<!-- Departure Port -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Departure Port
</label>

<div class="relative">

<select
name="departure_port_id"
class="appearance-none w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required>

<option disabled selected value="">
Select Departure Port
</option>

<?php while($port = mysqli_fetch_assoc($portsQuery)): ?>

<option value="<?php echo $port['port_id']; ?>">
    <?php echo $port['port_name']; ?>
</option>

<?php endwhile; ?>

</select>

<span class="material-symbols-outlined absolute right-md top-1/2 -translate-y-1/2 pointer-events-none text-outline">
expand_more
</span>

</div>
</div>

<!-- Destination Port -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Destination Port
</label>

<div class="relative">

<select
name="destination_port_id"
class="appearance-none w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required>

<option disabled selected value="">
Select Destination Port
</option>

<?php
mysqli_data_seek($portsQuery, 0);
while($port = mysqli_fetch_assoc($portsQuery)):
?>

<option value="<?php echo $port['port_id']; ?>">
    <?php echo $port['port_name']; ?>
</option>

<?php endwhile; ?>

</select>

<span class="material-symbols-outlined absolute right-md top-1/2 -translate-y-1/2 pointer-events-none text-outline">
expand_more
</span>

</div>
</div>

<!-- Departure Date -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Departure Date
</label>

<input
name="departure_date"
class="h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required
type="date"
/>
</div>

<!-- ETA -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Estimated Arrival (ETA)
</label>

<input
name="estimated_arrival"
class="h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required
type="date"
/>
</div>

<!-- Shipment Status -->
<div class="flex flex-col gap-xs md:col-span-2">
<label class="font-label-md text-label-md text-primary font-semibold uppercase tracking-wider">
Shipment Status
</label>

<div class="relative">

<select
name="shipment_status"
class="appearance-none w-full h-12 px-md border border-outline-variant rounded-lg font-body-md text-body-md form-input-focus transition-all bg-white"
required>

<option value="cargo_received">
Cargo Received
</option>

<option value="verified">
Verified
</option>

<option value="loaded">
Loaded
</option>

<option value="in_transit">
In Transit
</option>

<option value="arrived_port">
Arrived Port
</option>

<option value="ready_pickup">
Ready Pickup
</option>

<option value="delivered">
Delivered
</option>

</select>

<span class="material-symbols-outlined absolute right-md top-1/2 -translate-y-1/2 pointer-events-none text-outline">
assignment
</span>

</div>
</div>

<!-- Buttons -->
<div class="md:col-span-2 border-t border-outline-variant pt-lg mt-base flex flex-col md:flex-row justify-end gap-md">

<button
class="order-2 md:order-1 h-12 px-xl border border-primary text-primary rounded-lg font-body-md font-semibold hover:bg-primary/5 active:scale-95 transition-all"
type="button">
Cancel
</button>

<button
class="order-1 md:order-2 h-12 px-xl bg-[#004A99] text-white rounded-lg font-body-md font-semibold shadow-md hover:bg-primary active:scale-95 transition-all flex items-center justify-center gap-base"
type="submit">

<span class="material-symbols-outlined text-[20px]">
add
</span>

Create Shipment
</button>

</div>
</form>
</section>


<section class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-lg">
<div class="md:col-span-2 rounded-xl overflow-hidden relative min-h-[200px] border border-outline-variant">
<img class="w-full h-full object-cover" data-alt="A cinematic wide shot of a massive cargo ship docked at a modern maritime terminal during the golden hour. The scene is illuminated by warm sunset light reflecting off the glass containers and calm harbor waters. The architectural style is futuristic and high-tech, consistent with a premium corporate logistics brand. The color palette features deep ocean blues and vibrant oranges of the sky." src="https://lh3.googleusercontent.com/aida-public/AB6AXuD1PU5EuUaBtq7fjZh3MNDacRth2-_KHKh-KEb2TcOQ7dbtOAyBdZfiPnGci-g5SYCiY2fOUNXBqrQ_CZxGTHQlqrLdoo7QrYbjwbHIh6xDSXJpDwnsUvy_A0JxUB-vl-raWbkenDm35q7vKUdzGhaP_WvXhdnLlm-fMLTGUKrdBXRflFrFfBsfB5dZNbT6oQsaCij_UDsmudFmxp5F7ppuyNpGKfbzxObsX-V8NVERLUVgSjj1Fq_8mkSjIyZV6JIRfQEUeT1um-jq"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-lg">
<h4 class="text-white font-headline-sm">Global Tracking Network</h4>
<p class="text-on-primary/80 font-body-sm max-w-md">Real-time telemetry and satellite monitoring enabled for all new registrations.</p>
</div>
</div>
<div class="bg-surface-container p-lg rounded-xl flex flex-col justify-center border border-outline-variant">
<div class="w-12 h-12 rounded-full bg-primary-container/10 flex items-center justify-center mb-md">
<span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
</div>
<h4 class="font-headline-sm text-on-surface mb-xs">Safety First</h4>
<p class="font-body-sm text-on-surface-variant">Every shipment is automatically insured under the Maritime Connect Standard Liability Agreement.</p>
</div>
</section>
</main>
<script>
const inputs = document.querySelectorAll('input, select');

inputs.forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.querySelector('label')
        ?.classList.add('text-primary-container');
    });

    input.addEventListener('blur', () => {
        input.parentElement.querySelector('label')
        ?.classList.remove('text-primary-container');
    });
});
</script>
</body></html>