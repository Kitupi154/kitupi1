<?php

if ($_SESSION['role'] != "super_admin") {

    echo "
    <div style='padding:20px;font-family:Arial'>
        <h2>Access Denied</h2>
        <p>You are not authorized to access this page.</p>
    </div>
    ";

    exit();
}
?>