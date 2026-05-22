<?php
include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Get user
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
       if ($user['role'] == "customer") {
    header("Location: ../customerdash.php");
} elseif ($user['role'] == "admin") {
    header("Location: ../../admin/admindash.php");
} else {
    header("Location: ../../staff/staffdash.php");
}
exit();
           

        } else {
            echo "<script>
                    alert('Wrong password');
                    window.location='login1.php';
                  </script>";
        }

    } else {
        echo "<script>
                alert('Email not found');
                window.location='login1.php';
              </script>";
    }
}
?>