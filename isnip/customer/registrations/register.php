<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);

    $role = "customer";
    $status = "active";

    // Check if email exists
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>
                alert('Email already exists!');
                window.location='register.html';
              </script>";
        exit();
    }

    // Upload profile photo
    $profile_photo = "";

    if (!empty($_FILES['profile_photo']['name'])) {

        $folder = "uploads/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES['profile_photo']['name']);
        $target = $folder . $file_name;

        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target);

        $profile_photo = $target;
    }

    // INSERT INTO USERS
    $user_sql = "INSERT INTO users
    (full_name, email, phone, password, role, profile_photo, status)
    VALUES
    ('$full_name', '$email', '$phone', '$password', '$role', '$profile_photo', '$status')";

    if (mysqli_query($conn, $user_sql)) {

        $user_id = mysqli_insert_id($conn);

        // INSERT INTO CUSTOMERS
        $customer_sql = "INSERT INTO customers
        (user_id, address, company_name, id_number, nationality)
        VALUES
        ('$user_id', '$address', '$company_name', '$id_number', '$nationality')";

        if (mysqli_query($conn, $customer_sql)) {

            echo "<script>
                    alert('Registration Successful');
                    window.location='../login.html';
                  </script>";

        } else {
            echo "Customer insert failed: " . mysqli_error($conn);
            exit();
        }

    } else {
        echo "User insert failed: " . mysqli_error($conn);
        exit();
    }
}
?>