<?php
session_start();
include("../customer/registrations/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../customer/registrations/login1.php");
    exit();
}

if(isset($_GET['id'])){

    $shipment_id = $_GET['id'];

    mysqli_query($conn,"
        DELETE FROM shipments
        WHERE shipment_id='$shipment_id'
    ");
}

header("Location: shipment_management.php?deleted=1");
exit();
?>