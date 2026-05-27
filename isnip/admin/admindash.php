<?php
session_start();
include("../customer/registrations/db.php");

/*
|--------------------------------------------------------------------------
| LOGIN & ROLE CHECK
|--------------------------------------------------------------------------
*/

// Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../customer/registrations/login1.php");
    exit();
}

// Allow admin only
if ($_SESSION['role'] != 'admin') {

    // Redirect customers
    if ($_SESSION['role'] == 'customer') {
        header("Location: ../customer/customerdash.php");
        exit();
    }

    // Redirect staff
    if ($_SESSION['role'] == 'staff') {
        header("Location: ../staff/staffdash.php");
        exit();
    }

    // Unknown role
    session_destroy();
    header("Location: ../customer/registrations/login1.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| DASHBOARD COUNTS
|--------------------------------------------------------------------------
*/

// Total customers
$totalCustomers = 0;

$customerQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total 
     FROM users 
     WHERE role='customer'"
);

if ($customerQuery) {
    $customerData = mysqli_fetch_assoc($customerQuery);
    $totalCustomers = $customerData['total'];
}


// Total shipments
$totalShipments = 0;

$shipmentQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total 
     FROM shipments"
);

if ($shipmentQuery) {
    $shipmentData = mysqli_fetch_assoc($shipmentQuery);
    $totalShipments = $shipmentData['total'];
}


// Active vessels
$totalVessels = 0;

$vesselQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM vessels
     WHERE status='active'"
);

if ($vesselQuery) {
    $vesselData = mysqli_fetch_assoc($vesselQuery);
    $totalVessels = $vesselData['total'];
}


// Cargo in transit
$totalTransit = 0;

$transitQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM shipments
     WHERE shipment_status='in_transit'"
);

if ($transitQuery) {
    $transitData = mysqli_fetch_assoc($transitQuery);
    $totalTransit = $transitData['total'];
}


// Delivered cargo
$totalDelivered = 0;

$deliveredQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM shipments
     WHERE shipment_status='delivered'"
);

if ($deliveredQuery) {
    $deliveredData = mysqli_fetch_assoc($deliveredQuery);
    $totalDelivered = $deliveredData['total'];
}


// Pending deliveries
$totalPending = 0;

$pendingQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM deliveries
     WHERE delivery_status='pending'"
);

if ($pendingQuery) {
    $pendingData = mysqli_fetch_assoc($pendingQuery);
    $totalPending = $pendingData['total'];
}


/*
|--------------------------------------------------------------------------
| RECENT SHIPMENTS TABLE
|--------------------------------------------------------------------------
*/

$recentShipments = mysqli_query(
    $conn,
    "SELECT 
        shipments.tracking_number,
        shipments.cargo_type,
        shipments.estimated_arrival,
        shipments.shipment_status,

        users.full_name,

        vessels.vessel_name,

        ports.port_name AS destination_port

    FROM shipments

    LEFT JOIN customers 
        ON shipments.customer_id = customers.customer_id

    LEFT JOIN users
        ON customers.user_id = users.user_id

    LEFT JOIN vessels
        ON shipments.vessel_id = vessels.vessel_id

    LEFT JOIN ports
        ON shipments.destination_port_id = ports.port_id

    ORDER BY shipments.shipment_id DESC
    LIMIT 10"
);


/*
|--------------------------------------------------------------------------
| NOTIFICATIONS / CRITICAL LOGS
|--------------------------------------------------------------------------
*/

$notifications = mysqli_query(
    $conn,
    "SELECT *
     FROM notifications
     ORDER BY created_at DESC
     LIMIT 5"
);

// Shipment Analytics Data (REAL DB)

$receivedQuery = mysqli_query($conn,
"SELECT COUNT(*) as total FROM shipments WHERE shipment_status='cargo_received'");
$received = mysqli_fetch_assoc($receivedQuery)['total'];

$loadedQuery = mysqli_query($conn,
"SELECT COUNT(*) as total FROM shipments WHERE shipment_status='loaded'");
$loaded = mysqli_fetch_assoc($loadedQuery)['total'];

$transitQuery = mysqli_query($conn,
"SELECT COUNT(*) as total FROM shipments WHERE shipment_status='in_transit'");
$inTransit = mysqli_fetch_assoc($transitQuery)['total'];

$deliveredQuery = mysqli_query($conn,
"SELECT COUNT(*) as total FROM shipments WHERE shipment_status='delivered'");
$delivered = mysqli_fetch_assoc($deliveredQuery)['total'];

// total for percentages
$totalShipmentsAll = $received + $loaded + $inTransit + $delivered;


// Cargo breakdown
$cargoStats = [];

$cargoQuery = mysqli_query(
    $conn,
    "SELECT cargo_type, COUNT(*) AS total
     FROM shipments
     GROUP BY cargo_type"
);

$totalCargo = 0;

while ($row = mysqli_fetch_assoc($cargoQuery)) {

    $cargoStats[] = $row;
    $totalCargo += $row['total'];
}

// Vessel efficiency
$vesselEfficiency = mysqli_query(
    $conn,
    "SELECT
        vessels.vessel_name,
        COUNT(shipments.shipment_id) AS shipment_count
     FROM vessels
     LEFT JOIN shipments
        ON vessels.vessel_id = shipments.vessel_id
     GROUP BY vessels.vessel_id
     ORDER BY shipment_count DESC
     LIMIT 3"
);

?>



<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS | Enterprise Maritime Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(233, 236, 239, 0.5);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c2c6d3;
            border-radius: 10px;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>


<body class="bg-background text-on-surface font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed overflow-hidden h-screen flex">

    <!-- Sidebar -->
    <?php include("includes/sidebar.php"); ?>

    <!-- Main Content -->
    <main class="flex-1 md:ml-[260px] h-screen overflow-hidden flex flex-col">

        <!-- Header -->
        <?php include("includes/header.php"); ?>

        <!-- Page Content -->
        <div class="flex-1 mt-16 overflow-y-auto custom-scrollbar bg-background p-lg space-y-lg">

            <!-- Statistics Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-md">

                <!-- Your cards remain here -->
<!-- Card: Total Shipments -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow group">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-primary bg-primary-fixed p-xs rounded-lg" data-icon="inventory">inventory</span>
<span class="text-on-surface-variant font-label-md text-label-md">+12%</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Total Shipments</p>
<p class="font-headline-md text-headline-md text-primary font-bold">
<?php echo $totalShipments; ?>
</p>
</div>
</div>
<!-- Card: Active Vessels -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-tertiary bg-tertiary-fixed p-xs rounded-lg" data-icon="sailing">sailing</span>
<span class="text-on-surface-variant font-label-md text-label-md">Operational</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Active Vessels</p>
<p class="font-headline-md text-headline-md text-tertiary font-bold"><?php echo $totalVessels; ?></p>
</div>
</div>
<!-- Card: Cargo In Transit -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-primary bg-primary-fixed p-xs rounded-lg" data-icon="local_shipping">local_shipping</span>
<span class="text-on-surface-variant font-label-md text-label-md">Current</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Cargo In Transit</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold"><?php echo $totalTransit; ?></p>
</div>
</div>
<!-- Card: Delivered Cargo -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-on-secondary-container bg-secondary-container p-xs rounded-lg" data-icon="task_alt">task_alt</span>
<span class="text-on-surface-variant font-label-md text-label-md">Completed</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Delivered Cargo</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold"><?php echo $totalDelivered; ?></p>
</div>
</div>
<!-- Card: Pending Deliveries -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-error bg-error-container p-xs rounded-lg" data-icon="schedule">schedule</span>
<span class="text-error font-label-md text-label-md">Attention</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Pending</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold"><?php echo $totalPending; ?></p>
</div>
</div>
<!-- Card: Registered Customers -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-primary-container bg-primary-fixed p-xs rounded-lg" data-icon="face">face</span>
<span class="text-on-surface-variant font-label-md text-label-md">Total</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Customers</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold"><?php echo $totalCustomers; ?></p>
</div>
</div>
</div>




<!-- Analytics & Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">

    <!-- LEFT SIDE: Shipment Analytics -->
    <div class="lg:col-span-8 bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">

        <div class="flex justify-between items-center mb-xl">
            <h2 class="font-headline-sm text-headline-sm text-on-surface">Shipment Analytics</h2>

            <div class="flex gap-sm">
                <button class="px-md py-1 rounded-full text-label-md bg-primary text-on-primary">
                    Monthly
                </button>
                <button class="px-md py-1 rounded-full text-label-md bg-surface-container">
                    Weekly
                </button>
            </div>
        </div>

        <!-- BAR CHART -->
        <div class="h-[300px] flex items-end justify-around gap-md relative">

            <!-- grid lines -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                <div class="border-t border-outline-variant/30"></div>
                <div class="border-t border-outline-variant/30"></div>
                <div class="border-t border-outline-variant/30"></div>
                <div class="border-t border-outline-variant/30"></div>
            </div>

            <!-- Received -->
            <div class="flex flex-col items-center gap-xs w-full max-w-[80px]">
                <?php $p = ($totalShipmentsAll > 0) ? ($received/$totalShipmentsAll)*100 : 0; ?>
                <div class="w-full bg-primary/20 rounded-t-lg h-[<?php echo $p; ?>%]"></div>
                <span class="text-xs"><?php echo $received; ?></span>
                <span class="text-label-md">Received</span>
            </div>

            <!-- Loaded -->
            <div class="flex flex-col items-center gap-xs w-full max-w-[80px]">
                <?php $p = ($totalShipmentsAll > 0) ? ($loaded/$totalShipmentsAll)*100 : 0; ?>
                <div class="w-full bg-primary/40 rounded-t-lg h-[<?php echo $p; ?>%]"></div>
                <span class="text-xs"><?php echo $loaded; ?></span>
                <span class="text-label-md">Loaded</span>
            </div>

            <!-- In Transit -->
            <div class="flex flex-col items-center gap-xs w-full max-w-[80px]">
                <?php $p = ($totalShipmentsAll > 0) ? ($inTransit/$totalShipmentsAll)*100 : 0; ?>
                <div class="w-full bg-primary/60 rounded-t-lg h-[<?php echo $p; ?>%]"></div>
                <span class="text-xs"><?php echo $inTransit; ?></span>
                <span class="text-label-md">Transit</span>
            </div>

            <!-- Delivered -->
            <div class="flex flex-col items-center gap-xs w-full max-w-[80px]">
                <?php $p = ($totalShipmentsAll > 0) ? ($delivered/$totalShipmentsAll)*100 : 0; ?>
                <div class="w-full bg-primary rounded-t-lg h-[<?php echo $p; ?>%]"></div>
                <span class="text-xs"><?php echo $delivered; ?></span>
                <span class="text-label-md">Delivered</span>
            </div>

        </div>
    </div>

    <!-- RIGHT SIDE: Cargo + Vessel + Notifications -->
    <div class="lg:col-span-4 space-y-lg">

        <!-- Cargo Breakdown -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">

            <h3 class="font-label-md uppercase font-bold mb-md">Cargo Breakdown</h3>

            <div class="space-y-xs">

                <?php if(!empty($cargoStats)): ?>
                    <?php foreach($cargoStats as $cargo):
                        $percentage = ($totalCargo > 0)
                            ? round(($cargo['total'] / $totalCargo) * 100)
                            : 0;
                    ?>
                        <div class="flex justify-between text-sm">
                            <span><?php echo $cargo['cargo_type']; ?></span>
                            <span><?php echo $percentage; ?>%</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-400">No cargo data</p>
                <?php endif; ?>

            </div>
        </div>

        <!-- Vessel Efficiency -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">

            <h3 class="font-label-md uppercase font-bold mb-md">Vessel Efficiency</h3>

            <div class="space-y-sm">

                <?php if(mysqli_num_rows($vesselEfficiency) > 0): ?>
                    <?php while($vessel = mysqli_fetch_assoc($vesselEfficiency)):
                        $efficiency = min($vessel['shipment_count'] * 10, 100);
                    ?>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span><?php echo $vessel['vessel_name']; ?></span>
                                <span><?php echo $efficiency; ?>%</span>
                            </div>

                            <div class="w-full bg-gray-200 h-2 rounded">
                                <div class="bg-primary h-2 rounded" style="width:<?php echo $efficiency; ?>%"></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-400">No vessel data</p>
                <?php endif; ?>

            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">

            <h3 class="font-label-md uppercase font-bold mb-md">Notifications</h3>

            <div class="space-y-md">

                <?php if(mysqli_num_rows($notifications) > 0): ?>
                    <?php while($note = mysqli_fetch_assoc($notifications)): ?>
                        <div>
                            <p class="font-bold text-sm"><?php echo $note['title']; ?></p>
                            <p class="text-sm text-gray-500"><?php echo $note['message']; ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-400">No notifications</p>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<!-- Notifications Panel
<div class="space-y-lg flex-1">

<?php if(mysqli_num_rows($notifications) > 0): ?>

<?php while($note = mysqli_fetch_assoc($notifications)): ?>

<div class="flex gap-md group">

<div class="mt-1 w-2 h-2 rounded-full bg-primary shrink-0"></div>

<div>
<p class="text-body-sm font-body-sm font-bold text-on-surface">
<?php echo $note['title']; ?>
</p>

<p class="text-body-sm font-body-sm text-on-surface-variant">
<?php echo $note['message']; ?>
</p>

<span class="text-label-md text-outline mt-xs block">
<?php echo $note['created_at']; ?>
</span>
</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p class="text-outline text-sm">
No notifications found
</p>

<?php endif; ?>

</div> -->



<!-- Map Tooltip Micro-interaction Script -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animation for stats counters (simulated)
            const stats = document.querySelectorAll('.font-headline-md');
            stats.forEach(stat => {
                stat.style.opacity = '0';
                stat.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    stat.style.transition = 'all 0.6s ease-out';
                    stat.style.opacity = '1';
                    stat.style.transform = 'translateY(0)';
                }, 100);
            });

            // Table hover row highlight
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                   row.querySelector('td:first-child').style.color = 'var(--primary)';
                   row.querySelector('td:first-child').style.fontWeight = '700';
                });
                row.addEventListener('mouseleave', () => {
                   row.querySelector('td:first-child').style.color = '';
                   row.querySelector('td:first-child').style.fontWeight = '';
                });
            });
        });
    </script>
</body></html>