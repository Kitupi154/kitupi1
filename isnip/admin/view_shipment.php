<?php
$shipment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($shipment_id <= 0) {
    die("Invalid shipment ID");
}

$query = mysqli_query($conn, "
SELECT 
    s.*,
    u.full_name,
    v.vessel_name,
    p1.port_name AS departure_port,
    p2.port_name AS destination_port
FROM shipments s
LEFT JOIN customers c ON s.customer_id = c.customer_id
LEFT JOIN users u ON c.user_id = u.user_id
LEFT JOIN vessels v ON s.vessel_id = v.vessel_id
LEFT JOIN ports p1 ON s.departure_port_id = p1.port_id
LEFT JOIN ports p2 ON s.destination_port_id = p2.port_id
WHERE s.shipment_id = $shipment_id
");

if (!$query) {
    die("SQL ERROR: " . mysqli_error($conn));
}

$shipment = mysqli_fetch_assoc($query);

if (!$shipment) {
    die("No shipment found for ID: " . $shipment_id);
}
?>