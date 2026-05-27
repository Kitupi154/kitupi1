<?php
session_start();
include("../customer/registrations/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../customer/registrations/login1.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: shipment_management.php");
    exit();
}

$shipment_id = $_GET['id'];

/*
|--------------------------------------------------------------------------
| FETCH SHIPMENT
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "
    SELECT * FROM shipments
    WHERE shipment_id='$shipment_id'
");

$shipment = mysqli_fetch_assoc($query);

if(!$shipment){
    die("Shipment not found");
}

/*
|--------------------------------------------------------------------------
| DROPDOWNS
|--------------------------------------------------------------------------
*/

$customersQuery = mysqli_query($conn,"
SELECT c.customer_id, u.full_name
FROM customers c
INNER JOIN users u
ON c.user_id = u.user_id
");

$vesselsQuery = mysqli_query($conn,"
SELECT * FROM vessels
WHERE status='active'
");

$portsQuery = mysqli_query($conn,"
SELECT * FROM ports
");

/*
|--------------------------------------------------------------------------
| UPDATE SHIPMENT
|--------------------------------------------------------------------------
*/

if(isset($_POST['update'])){

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

    $update = mysqli_query($conn,"
        UPDATE shipments SET
        customer_id='$customer_id',
        vessel_id='$vessel_id',
        departure_port_id='$departure_port_id',
        destination_port_id='$destination_port_id',
        cargo_type='$cargo_type',
        container_number='$container_number',
        weight='$weight',
        departure_date='$departure_date',
        estimated_arrival='$estimated_arrival',
        shipment_status='$shipment_status'
        WHERE shipment_id='$shipment_id'
    ");

    if($update){
        header("Location: shipment_management.php?updated=1");
        exit();
    } else {
        echo mysqli_error($conn);
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

<form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-lg">

<!-- CUSTOMER -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Customer Name
</label>

<div class="relative">
<select name="customer_id"
class="w-full h-12 px-md border border-outline-variant rounded-lg bg-white"
required>

<option value="">Select Customer</option>

<?php while($customer = mysqli_fetch_assoc($customersQuery)): ?>
<option value="<?php echo $customer['customer_id']; ?>"
<?php if($shipment['customer_id'] == $customer['customer_id']) echo "selected"; ?>>
    <?php echo $customer['full_name']; ?>
</option>
<?php endwhile; ?>

</select>
</div>
</div>

<!-- CARGO TYPE -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Cargo Type
</label>

<select name="cargo_type"
class="w-full h-12 px-md border border-outline-variant rounded-lg bg-white"
required>

<?php
$types = ['dry_bulk','liquid_bulk','containerized','reefer','ro-ro'];

foreach($types as $type):
?>
<option value="<?php echo $type; ?>"
<?php if($shipment['cargo_type'] == $type) echo "selected"; ?>>
    <?php echo ucfirst(str_replace('_',' ', $type)); ?>
</option>
<?php endforeach; ?>

</select>
</div>

<!-- WEIGHT -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Weight (MT)
</label>

<input type="number" step="0.01" name="weight"
value="<?php echo $shipment['weight']; ?>"
class="w-full h-12 px-md border border-outline-variant rounded-lg" required>
</div>

<!-- CONTAINER NUMBER -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Container Number
</label>

<input type="text" name="container_number"
value="<?php echo $shipment['container_number']; ?>"
class="w-full h-12 px-md border border-outline-variant rounded-lg">
</div>

<!-- VESSEL -->
<div class="flex flex-col gap-xs md:col-span-2">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Vessel
</label>

<select name="vessel_id"
class="w-full h-12 px-md border border-outline-variant rounded-lg"
required>

<?php while($vessel = mysqli_fetch_assoc($vesselsQuery)): ?>
<option value="<?php echo $vessel['vessel_id']; ?>"
<?php if($shipment['vessel_id'] == $vessel['vessel_id']) echo "selected"; ?>>
    <?php echo $vessel['vessel_name']; ?>
</option>
<?php endwhile; ?>

</select>
</div>

<!-- DEPARTURE PORT -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Departure Port
</label>

<select name="departure_port_id"
class="w-full h-12 px-md border border-outline-variant rounded-lg"
required>

<?php while($port = mysqli_fetch_assoc($portsQuery)): ?>
<option value="<?php echo $port['port_id']; ?>"
<?php if($shipment['departure_port_id'] == $port['port_id']) echo "selected"; ?>>
    <?php echo $port['port_name']; ?>
</option>
<?php endwhile; ?>

</select>
</div>

<!-- DESTINATION PORT -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Destination Port
</label>

<select name="destination_port_id"
class="w-full h-12 px-md border border-outline-variant rounded-lg"
required>

<?php mysqli_data_seek($portsQuery, 0); ?>
<?php while($port = mysqli_fetch_assoc($portsQuery)): ?>
<option value="<?php echo $port['port_id']; ?>"
<?php if($shipment['destination_port_id'] == $port['port_id']) echo "selected"; ?>>
    <?php echo $port['port_name']; ?>
</option>
<?php endwhile; ?>

</select>
</div>

<!-- DEPARTURE DATE -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Departure Date
</label>

<input type="date" name="departure_date"
value="<?php echo $shipment['departure_date']; ?>"
class="w-full h-12 px-md border border-outline-variant rounded-lg"
required>
</div>

<!-- ETA -->
<div class="flex flex-col gap-xs">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Estimated Arrival
</label>

<input type="date" name="estimated_arrival"
value="<?php echo $shipment['estimated_arrival']; ?>"
class="w-full h-12 px-md border border-outline-variant rounded-lg"
required>
</div>

<!-- STATUS -->
<div class="flex flex-col gap-xs md:col-span-2">
<label class="font-label-md text-primary font-semibold uppercase tracking-wider">
Shipment Status
</label>

<select name="shipment_status"
class="w-full h-12 px-md border border-outline-variant rounded-lg"
required>

<?php
$statusList = [
'cargo_received',
'verified',
'loaded',
'in_transit',
'arrived_port',
'ready_pickup',
'delivered'
];

foreach($statusList as $status):
?>
<option value="<?php echo $status; ?>"
<?php if($shipment['shipment_status'] == $status) echo "selected"; ?>>
    <?php echo ucfirst(str_replace('_',' ', $status)); ?>
</option>
<?php endforeach; ?>

</select>
</div>

<!-- BUTTONS -->
<div class="md:col-span-2 border-t pt-lg mt-base flex justify-end gap-md">

<button type="button"
onclick="window.location.href='shipment_management.php'"
class="px-xl h-12 border border-primary text-primary rounded-lg font-semibold">
Cancel
</button>

<button type="submit" name="update"
class="px-xl h-12 bg-primary text-white rounded-lg font-semibold">
Update Shipment
</button>

</div>

</form>


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