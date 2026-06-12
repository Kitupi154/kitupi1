<?php
include "db.php";

$message = "";

if(isset($_POST['register'])){

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password != $confirm_password){

        $message = "Passwords do not match";

    }else{

        $check = mysqli_query($conn,
        "SELECT * FROM admins
        WHERE username='$username'
        OR email='$email'");

        if(mysqli_num_rows($check) > 0){

            $message = "Username or Email already exists";

        }else{

            $hashed_password =
            password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO admins
            (full_name, username, email, password)
            VALUES
            (
                '$full_name',
                '$username',
                '$email',
                '$hashed_password'
            )";

            if(mysqli_query($conn,$query)){

                $message = "Registration Successful";

            }else{

                $message = "Something went wrong";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Register</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#fcf8fa] flex justify-center items-center min-h-screen">

<div class="bg-white shadow-xl rounded-3xl p-8 w-[450px]">

<h1 class="text-3xl font-bold mb-6 text-center">
Admin Registration
</h1>

<?php if($message != ""){ ?>

<div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
    <?php echo $message; ?>
</div>

<?php } ?>

<form method="POST">

<input type="text"
name="full_name"
placeholder="Full Name"
required
class="w-full border p-3 rounded-xl mb-4">

<input type="text"
name="username"
placeholder="Username"
required
class="w-full border p-3 rounded-xl mb-4">

<input type="email"
name="email"
placeholder="Email"
required
class="w-full border p-3 rounded-xl mb-4">

<input type="password"
name="password"
placeholder="Password"
required
class="w-full border p-3 rounded-xl mb-4">

<input type="password"
name="confirm_password"
placeholder="Confirm Password"
required
class="w-full border p-3 rounded-xl mb-6">

<button
type="submit"
name="register"
class="w-full bg-[#131b2e] text-white py-3 rounded-xl">

Register

</button>

</form>

<p class="text-center mt-5">
Already have account?

<a href="login.php" class="text-blue-600">
Login
</a>
</p>

</div>

</body>
</html>