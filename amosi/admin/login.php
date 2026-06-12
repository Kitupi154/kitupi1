<?php
session_start();
include "db.php";

$message = "";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = $_POST['password'];

    $query = mysqli_query($conn,
    "SELECT * FROM admins
    WHERE username='$username'
    OR email='$username'");

    if(mysqli_num_rows($query) > 0){

        $admin = mysqli_fetch_assoc($query);

        if(password_verify(
            $password,
            $admin['password']
        )){

            $_SESSION['admin_id']
            = $admin['admin_id'];

            $_SESSION['full_name']
            = $admin['full_name'];

            $_SESSION['username']
            = $admin['username'];

            $_SESSION['email']
            = $admin['email'];

            $_SESSION['role']
            = $admin['role'];

            $_SESSION['profile_image']
            = $admin['profile_image'];

            header("Location: admindash.php");
            exit();

        }else{

            $message = "Incorrect Password";
        }

    }else{

        $message = "Admin Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#fcf8fa] flex justify-center items-center min-h-screen">

<div class="bg-white shadow-xl rounded-3xl p-8 w-[450px]">

<h1 class="text-3xl font-bold mb-6 text-center">
Admin Login
</h1>

<?php if($message != ""){ ?>

<div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
    <?php echo $message; ?>
</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username or Email"
required
class="w-full border p-3 rounded-xl mb-4">

<input
type="password"
name="password"
placeholder="Password"
required
class="w-full border p-3 rounded-xl mb-6">

<button
type="submit"
name="login"
class="w-full bg-[#131b2e] text-white py-3 rounded-xl">

Login

</button>

</form>

<p class="text-center mt-5">

No account?

<a href="adminreg.php"
class="text-blue-600">

Register

</a>

</p>

</div>

</body>
</html>