<?php
include("db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $message = "Email already exists!";
    } else {

        $sql = "INSERT INTO users (full_name, email, phone, password, role)
                VALUES ('$full_name', '$email', '$phone', '$password', 'admin')";

        if (mysqli_query($conn, $sql)) {
            header("Location: admindash.php");
            exit();
        } else {
            $message = "Error creating admin account!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Registration</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-2xl rounded-2xl w-full max-w-lg p-8">

    <h2 class="text-3xl font-bold text-blue-900 mb-2">
        Admin Registration
    </h2>

    <p class="text-gray-500 mb-6">
        Create a new system administrator account
    </p>

    <?php if ($message != ""): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <input type="text" name="full_name" required
            placeholder="Full Name"
            class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-700">

        <input type="email" name="email" required
            placeholder="Email"
            class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-700">

        <input type="text" name="phone" required
            placeholder="Phone"
            class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-700">

        <input type="password" name="password" required
            placeholder="Password"
            class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-700">

        <button type="submit"
            class="w-full bg-blue-900 text-white py-3 rounded-lg font-bold hover:bg-blue-700">

            Create Admin Account
        </button>

    </form>

</div>

</body>
</html>