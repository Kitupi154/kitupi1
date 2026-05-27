<?php
session_start();

// Remove all session variables
session_unset();

// Destroy session
session_destroy();

// Prevent back button access
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page
header("Location: login1.php");
exit();
?>