<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("registrations/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GET CUSTOMER ID */
$stmt = $conn->prepare("SELECT customer_id FROM customers WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

if (!$customer) {
    die("Customer profile not found");
}

$customer_id = $customer['customer_id'];

/* FETCH SHIPMENTS */
$stmt = $conn->prepare("
    SELECT 
        s.*,
        v.vessel_name,
        v.vessel_type,
        dp.port_name AS departure_port,
        dt.port_name AS destination_port
    FROM shipments s
    LEFT JOIN vessels v ON s.vessel_id = v.vessel_id
    LEFT JOIN ports dp ON s.departure_port_id = dp.port_id
    LEFT JOIN ports dt ON s.destination_port_id = dt.port_id
    WHERE s.customer_id = ?
    ORDER BY s.created_at DESC
");

$stmt->bind_param("i", $customer_id);
$stmt->execute();
$shipments = $stmt->get_result();

$current_page = basename($_SERVER['PHP_SELF']);

$status_colors = [
    'cargo_received' => 'bg-gray-500',
    'verified' => 'bg-blue-500',
    'loaded' => 'bg-indigo-500',
    'in_transit' => 'bg-yellow-500',
    'arrived_port' => 'bg-purple-500',
    'ready_pickup' => 'bg-orange-500',
    'delivered' => 'bg-green-600'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>My Shipments | ISNIS PORTAL</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

<style>
<style>
body {
    font-family: 'Inter', sans-serif;
    background: #f6f9ff;
}

/* Material Icons */
.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}

/* Table styling */
.table-card {
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

.table-row:hover {
    background: #eef4fd;
    transition: 0.2s;
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #dce3ec;
    border-radius: 10px;
}

/* Glass effect */
.glass-panel {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
</style>
</head>

<body class="bg-background text-on-surface overflow-x-hidden">

<!-- HEADER + SIDEBAR (same as dashboard) -->
<?php include("includes/header.php"); ?>

<?php include("includes/sidebar.php"); ?>
<!-- MAIN CONTENT -->
<main class="pt-24 px-margin-mobile md:ml-[260px] md:px-margin-desktop min-h-screen">

<!-- PAGE HEADER -->
<div class="mb-6">
    <h2 class="text-3xl font-bold text-blue-900">My Shipments</h2>
    <p class="text-sm text-gray-500">Track and monitor all your cargo movements in real time</p>
</div>

<!-- TABLE CARD -->
<div class="bg-white table-card">

    <!-- TABLE HEADER -->
    <div class="flex justify-between items-center px-6 py-4 border-b">
        <h3 class="font-semibold text-blue-900">Shipment Records</h3>
        <span class="text-sm text-gray-500">
            Total Shipments: <?php echo $shipments->num_rows; ?>
        </span>
    </div>

    <div class="overflow-x-auto">

    <table class="w-full text-sm">

        <!-- TABLE HEAD -->
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="p-4 text-left">Tracking</th>
                <th class="p-4 text-left">Cargo</th>
                <th class="p-4 text-left">Route</th>
                <th class="p-4 text-left">Vessel</th>
                <th class="p-4 text-left">Weight</th>
                <th class="p-4 text-left">Departure</th>
                <th class="p-4 text-left">ETA</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-right">Action</th>
            </tr>
        </thead>

        <!-- TABLE BODY -->
        <tbody>

        <?php while($s = $shipments->fetch_assoc()): 
            $status = $s['shipment_status'] ?? 'unknown';
            $color = $status_colors[$status] ?? 'bg-gray-400';
        ?>

        <tr class="border-t table-row">

            <!-- Tracking -->
            <td class="p-4 font-semibold text-blue-700">
                #<?php echo htmlspecialchars($s['tracking_number']); ?>
            </td>

            <!-- Cargo -->
            <td class="p-4">
                <div class="font-medium">
                    <?php echo ucfirst(str_replace('_',' ', $s['cargo_type'])); ?>
                </div>
                <div class="text-xs text-gray-500">
                    <?php echo $s['weight']; ?> MT
                </div>
            </td>

            <!-- Route -->
            <td class="p-4 text-gray-600">
                <?php echo $s['departure_port'] ?? 'N/A'; ?> → <?php echo $s['destination_port'] ?? 'N/A'; ?>
            </td>

            <!-- Vessel -->
            <td class="p-4">
                <div class="font-medium">
                    <?php echo $s['vessel_name'] ?? 'Not assigned'; ?>
                </div>
                <div class="text-xs text-gray-500">
                    <?php echo $s['vessel_type'] ?? '-'; ?>
                </div>
            </td>

            <!-- Weight -->
            <td class="p-4">
                <?php echo $s['weight']; ?> MT
            </td>

            <!-- Departure -->
            <td class="p-4 text-gray-600">
                <?php echo !empty($s['departure_date']) ? date("d M Y", strtotime($s['departure_date'])) : '-'; ?>
            </td>

            <!-- ETA -->
            <td class="p-4 text-gray-600">
                <?php echo !empty($s['estimated_arrival']) ? date("d M Y", strtotime($s['estimated_arrival'])) : '-'; ?>
            </td>

            <!-- STATUS -->
            <td class="p-4">
                <span class="<?php echo $color; ?> text-white text-xs px-3 py-1 rounded-full font-bold">
                    <?php echo strtoupper(str_replace('_',' ', $status)); ?>
                </span>
            </td>

            <!-- ACTION -->
            <td class="p-4 text-right">
                <a href="shipment_details.php?id=<?php echo $s['shipment_id']; ?>"
                   class="text-blue-600 font-semibold hover:underline">
                    View
                </a>
            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>
    </table>

    </div>
</div>

</main>

</body>
</html>