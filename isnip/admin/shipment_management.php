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
| FETCH SHIPMENTS FROM DATABASE
|--------------------------------------------------------------------------
*/

$shipmentQuery = mysqli_query($conn, "
    SELECT 
        s.*,
        u.full_name,
        v.vessel_name
    FROM shipments s
    LEFT JOIN customers c ON s.customer_id = c.customer_id
    LEFT JOIN users u ON c.user_id = u.user_id
    LEFT JOIN vessels v ON s.vessel_id = v.vessel_id
    ORDER BY s.shipment_id DESC
");

/*
|--------------------------------------------------------------------------
| DASHBOARD COUNTS
|--------------------------------------------------------------------------
*/

// Total shipments
$totalShipmentsQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM shipments");
$totalShipments = mysqli_fetch_assoc($totalShipmentsQuery)['total'];

// In transit shipments
$inTransitQuery = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM shipments 
    WHERE shipment_status='in_transit'
");
$inTransit = mysqli_fetch_assoc($inTransitQuery)['total'];

// Cargo received / pending
$pendingQuery = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM shipments 
    WHERE shipment_status='cargo_received'
");
$pendingShipments = mysqli_fetch_assoc($pendingQuery)['total'];
?>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Maritime Connect - Shipment Management</title>
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
                        "lg": "0.5rem",
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
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .sidebar-gradient {
            background: linear-gradient(to bottom, #00346f, #00385c);
        }
        .zebra-stripes tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .scroll-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md">


<!-- Sidebar -->
<?php include("includes/sidebar.php"); ?>

<!-- Header -->


<!-- Main Content Canvas -->
<main class="md:pl-[260px] min-h-screen flex flex-col">
<!-- TopAppBar -->
<header class="sticky top-0 z-40 bg-surface flex items-center justify-between px-4 h-16 w-full shadow-sm border-b border-outline-variant">
<?php include("includes/header.php"); ?>
</header>


<!-- Page Content -->
<div class="p-md md:p-xl max-w-[1440px] mx-auto w-full flex flex-col gap-lg">
<!-- Hero Dashboard Stats (Bento Style) -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-md">
<div class="md:col-span-2 bg-white p-lg rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.04)] border border-outline-variant/30 flex items-center gap-lg">
<div class="p-md bg-primary/10 rounded-lg">
<span class="material-symbols-outlined text-primary text-4xl">inventory_2</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md">Active Shipments</p>
<h2 class="font-headline-lg text-headline-lg">
    <?php echo $totalShipments; ?>
</h2>
<p class="text-primary text-xs font-semibold">+12% from last month</p>
</div>
</div>


<div class="bg-white p-lg rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.04)] border border-outline-variant/30">
<p class="text-on-surface-variant font-label-md">In Transit</p>
<h2 class="font-headline-md text-headline-md text-on-surface">
    <?php echo $inTransit; ?>
</h2>
<div class="w-full bg-surface-container h-1 rounded-full mt-md overflow-hidden">
<div class="bg-primary h-full w-3/4"></div>
</div>
</div>

<div class="bg-white p-lg rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.04)] border border-outline-variant/30">
<p class="text-on-surface-variant font-label-md">Pending Customs</p>
<h2 class="font-headline-md text-headline-md text-on-surface">
    <?php echo $pendingShipments; ?>
</h2>
<div class="w-full bg-surface-container h-1 rounded-full mt-md overflow-hidden">
<div class="bg-error h-full w-1/4"></div>
</div>
</div>
</div>



<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-center gap-md">
<div class="relative w-full md:w-96">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
<input class="w-full pl-xl pr-md py-md bg-white border border-outline-variant rounded-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-body-md shadow-sm" placeholder="Search tracking #, vessel, or customer..." type="text"/>
</div>
<div class="flex items-center gap-md w-full md:w-auto">
<button class="flex-1 md:flex-none flex items-center justify-center gap-xs px-lg py-md bg-white border border-outline-variant text-primary font-semibold rounded-lg hover:bg-surface-container-low transition-colors shadow-sm">
<span class="material-symbols-outlined">filter_list</span>
                        Filters
                    </button>
<button>
 <a href="add_shipment.php" class="flex-1 md:flex-none flex items-center justify-center gap-xs px-lg py-md bg-primary-container text-on-primary font-semibold rounded-lg hover:bg-primary transition-all active:scale-95 shadow-lg">
    <span class="material-symbols-outlined">add</span>
    Add Shipment
</a>
                    </button>
</div>
</div>




<!-- Shipment Table Container -->
<div class="bg-white rounded-xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-outline-variant overflow-hidden">
<div class="overflow-x-auto scroll-hide">
<table class="w-full text-left border-collapse zebra-stripes">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant">
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider">Tracking #</th>
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider">Customer</th>
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider">Cargo Type</th>
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider">Vessel Name</th>
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider">Status</th>
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider">ETA</th>
<th class="px-lg py-md font-semibold text-on-surface-variant font-label-md uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>

<!-- table body -->
<tbody class="text-on-surface divide-y divide-outline-variant/30">

<?php if(mysqli_num_rows($shipmentQuery) > 0): ?>

    <?php while($shipment = mysqli_fetch_assoc($shipmentQuery)): ?>

        <tr class="hover:bg-primary-fixed/10 transition-colors">

            <!-- Tracking Number -->
            <td class="px-lg py-md font-label-md text-primary">
                <?php echo htmlspecialchars($shipment['tracking_number']); ?>
            </td>

            <!-- Customer -->
            <td class="px-lg py-md font-semibold">
                <?php echo htmlspecialchars($shipment['full_name'] ?? 'N/A'); ?>
            </td>

            <!-- Cargo Type -->
            <td class="px-lg py-md text-on-surface-variant">
                <?php echo htmlspecialchars($shipment['cargo_type'] ?? 'N/A'); ?>
            </td>

            <!-- Vessel Name -->
            <td class="px-lg py-md flex items-center gap-xs">
                <span class="material-symbols-outlined text-on-surface-variant text-sm">
                    directions_boat
                </span>

                <?php echo htmlspecialchars($shipment['vessel_name'] ?? 'Not Assigned'); ?>
            </td>

            <!-- Status -->
            <td class="px-lg py-md">

                <?php
                $status = $shipment['shipment_status'];

                $statusClass = "bg-gray-100 text-gray-700";

                if($status == 'in_transit'){
                    $statusClass = "bg-green-100 text-green-700";
                } elseif($status == 'cargo_received'){
                    $statusClass = "bg-orange-100 text-orange-700";
                } elseif($status == 'delivered'){
                    $statusClass = "bg-blue-100 text-blue-700";
                } elseif($status == 'arrived_port'){
                    $statusClass = "bg-purple-100 text-purple-700";
                }
                ?>

                <span class="px-sm py-xs <?php echo $statusClass; ?> text-xs font-bold rounded-full uppercase tracking-tighter">
                    <?php echo str_replace('_', ' ', $status); ?>
                </span>
            </td>

            <!-- ETA -->
            <td class="px-lg py-md text-on-surface-variant">

                <?php
                echo !empty($shipment['estimated_arrival']) 
                    ? date("M d, Y", strtotime($shipment['estimated_arrival']))
                    : 'N/A';
                ?>

            </td>

            <!-- Actions -->
      <!-- Actions -->
<td class="px-lg py-md text-right">
    <div class="flex justify-end gap-base">

   

        <!-- Edit -->
        <a href="edit_shipment.php?id=<?php echo $shipment['shipment_id']; ?>"
           class="p-xs hover:bg-surface-container rounded transition-colors text-on-surface-variant"
           title="Edit">

            <span class="material-symbols-outlined">
                edit
            </span>
        </a>

        <!-- Delete -->
        <a href="delete_shipment.php?id=<?php echo $shipment['shipment_id']; ?>"
           onclick="return confirm('Are you sure you want to delete this shipment?')"
           class="p-xs hover:bg-surface-container rounded transition-colors text-error"
           title="Delete">

            <span class="material-symbols-outlined">
                delete
            </span>
        </a>

    </div>
</td>
        </tr>

    <?php endwhile; ?>

<?php else: ?>

<tr>
    <td colspan="7" class="text-center py-8 text-gray-500">
        No shipments found
    </td>
</tr>

<?php endif; ?>

</tbody>
</table>
</div>

<!-- Pagination -->
<div class="px-lg py-md bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
<span class="text-sm text-on-surface-variant">Showing <?php echo mysqli_num_rows($shipmentQuery); ?> shipment(s)</span>
<div class="flex items-center gap-xs">
<button class="p-base hover:bg-surface-container rounded transition-all text-on-surface-variant disabled:opacity-30" disabled="">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="px-md py-xs bg-primary text-on-primary rounded font-bold text-sm">1</button>
<button class="px-md py-xs hover:bg-surface-container rounded text-sm transition-all">2</button>
<button class="px-md py-xs hover:bg-surface-container rounded text-sm transition-all">3</button>
<span class="px-md py-xs">...</span>
<button class="px-md py-xs hover:bg-surface-container rounded text-sm transition-all">321</button>
<button class="p-base hover:bg-surface-container rounded transition-all text-on-surface-variant">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Mini Map Inset (Contextual Depth) -->
<div class="bg-white p-base rounded-xl border border-outline-variant shadow-sm h-64 relative overflow-hidden group">
<div class="absolute inset-0 bg-surface-container-highest animate-pulse" id="map-placeholder">
<img alt="Maritime Logistics Map View" class="w-full h-full object-cover opacity-60 mix-blend-multiply" data-alt="A sophisticated digital global maritime map displayed on a high-tech terminal. The map features illuminated blue and cyan navigation routes connecting major port hubs like Shanghai and Dar es Salaam. Glowing vessel icons are scattered across the oceans, representing real-time traffic data. The lighting is low-key and atmospheric, with a clean corporate technological aesthetic emphasizing data precision." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDVuEICLAbso_EPLNoq3vsTM07ezLWAW3-woR2p4bNM94eNPsHDMtpN1ICmzLD8rDj2cq3WrWy1X7Hblo6Xb3dWgsQ8IpT3UuCCVEHs36T99vNvL50RXVOt0CesTf_ka_noLBru20wE6azmW4VpEAzXm0GwsQb-g_Pw1s1mno4sQFfa01HC8FIDpWWdJ0VFnw8H5xTxl20qmAsKHR47aNBBru2G1j_BkWLS2gd31VkRQN8mTqRBFXSfE_afOJlM-jYxO7JS3UXib1Dh"/>
</div>
<div class="absolute top-md left-md bg-white/90 backdrop-blur-md p-md rounded-lg shadow-lg border border-outline-variant/30 z-10">
<h3 class="font-headline-sm text-headline-sm text-primary">Fleet Tracking</h3>
<p class="text-xs text-on-surface-variant">Active monitoring in the Indian Ocean sector.</p>
</div>
<button class="absolute bottom-md right-md bg-primary-container text-on-primary px-lg py-base rounded-full font-semibold shadow-lg hover:bg-primary transition-all z-10 flex items-center gap-xs">
<span class="material-symbols-outlined">map</span>
                    Expand Monitor
                </button>
</div>
</div>
</main>
<script>
        // Micro-interaction for table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', () => {
                // Future expansion: open detail panel
                console.log('Row clicked');
            });
        });

        // Atmospheric fade-in for data elements
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.grid > div, .bg-white');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                el.style.transition = 'all 0.4s ease-out';
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body></html>