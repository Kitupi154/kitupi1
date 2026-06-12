<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

// ADD SERVICE

if(isset($_POST['add_service'])){

    $service_name =
    mysqli_real_escape_string(
    $conn,
    $_POST['service_name']
    );

    $description =
    mysqli_real_escape_string(
    $conn,
    $_POST['description']
    );

    $price =
    mysqli_real_escape_string(
    $conn,
    $_POST['price']
    );

    $status =
    mysqli_real_escape_string(
    $conn,
    $_POST['status']
    );

    // IMAGE UPLOAD

    $image_name =
    $_FILES['image']['name'];

    $tmp_name =
    $_FILES['image']['tmp_name'];

    $folder =
    "uploads/services/" .
    $image_name;

    move_uploaded_file(
    $tmp_name,
    $folder
    );

    // INSERT QUERY

    $query =

    "INSERT INTO services
    (
    service_name,
    description,
    image,
    price,
    status,
    created_at
    )

    VALUES
    (
    '$service_name',
    '$description',
    '$image_name',
    '$price',
    '$status',
    NOW()
    )";

    $insert =
    mysqli_query(
    $conn,
    $query
    );

    if($insert){

        echo "
        <script>
        alert(
        'Service Added Successfully'
        );

        window.location=
        'services.php';
        </script>
        ";

    }else{

        echo "
        <script>
        alert(
        'Failed to Add Service'
        );
        </script>
        ";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Add Service</title>

<!-- <link rel="stylesheet"
href="assets/css/style.css"> -->

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:#f5f7fa;
}

/* SIDEBAR */

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100%;
    background:#1e293b;
    color:white;
    padding:30px 20px;
}

.logo-area h2{
    font-size:28px;
}

.logo-area p{
    color:#cbd5e1;
    margin-top:5px;
}

.menu{
    margin-top:40px;
    list-style:none;
}

.menu li{
    margin-bottom:10px;
}

.menu li a{
    display:block;
    padding:14px 18px;
    text-decoration:none;
    color:white;
    border-radius:8px;
    transition:.3s;
}

.menu li a:hover,
.menu li a.active{
    background:#16a34a;
}

/* HEADER */

.header{
    margin-left:250px;
    height:80px;
    background:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 40px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.page-title{
    font-size:28px;
}

.admin-info{
    display:flex;
    align-items:center;
    gap:15px;
}

.admin-info img{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}

/* CONTENT */

.content{
    margin-left:250px;
    padding:30px;
}

.cards{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
    border-left:5px solid #16a34a;
}

.card h2{
    font-size:35px;
    margin-top:10px;
}

.card p{
    color:#64748b;
}

/* FOOTER */

.footer{
    margin-left:250px;
    background:white;
    text-align:center;
    padding:20px;
    margin-top:30px;
    color:#64748b;
    border-top:1px solid #ddd;
}

.logout-box{
    position:absolute;
    bottom:30px;
    width:calc(100% - 40px);
}

.logout-box a{
    display:block;
    background:#16a34a;
    color:white;
    text-align:center;
    padding:14px;
    border-radius:8px;
    text-decoration:none;
}

</style>
</head>
<body>

<?php include "includes/sidebar.php"; ?>

<?php include "includes/header.php"; ?>

<div class="content">

    <div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;">

        <div>

            <h2>
                Add New Service
            </h2>

            <p style="
            color:#666;
            margin-top:5px;">

            Create a new technical service

            </p>

        </div>

        <a href="services.php"

        style="
        background:#64748b;
        color:white;
        padding:12px 20px;
        border-radius:8px;">

        Back

        </a>

    </div>

    <!-- FORM CARD -->

    <div class="table-container"
    style="padding:30px;">

        <form
        method="POST"

        enctype=
        "multipart/form-data">

        <!-- SERVICE NAME -->

        <div
        style="
        margin-bottom:20px;">

            <label>
                Service Name
            </label>

            <input
            type="text"

            name=
            "service_name"

            required

            style="
            width:100%;
            padding:14px;
            margin-top:8px;
            border:1px solid #ddd;
            border-radius:8px;">

        </div>

        <!-- DESCRIPTION -->

        <div
        style="
        margin-bottom:20px;">

            <label>
                Description
            </label>

            <textarea

            name=
            "description"

            rows="5"

            required

            style="
            width:100%;
            padding:14px;
            margin-top:8px;
            border:1px solid #ddd;
            border-radius:8px;
            resize:none;"></textarea>

        </div>

        <!-- PRICE -->

        <div
        style="
        margin-bottom:20px;">

            <label>
                Price (TZS)
            </label>

            <input

            type="number"

            name=
            "price"

            required

            style="
            width:100%;
            padding:14px;
            margin-top:8px;
            border:1px solid #ddd;
            border-radius:8px;">

        </div>

        <!-- IMAGE -->

        <div
        style="
        margin-bottom:20px;">

            <label>
                Service Image
            </label>

            <input

            type="file"

            name=
            "image"

            accept=
            "image/*"

            required

            style="
            width:100%;
            padding:14px;
            margin-top:8px;
            border:1px solid #ddd;
            border-radius:8px;">

        </div>

        <!-- STATUS -->

        <div
        style="
        margin-bottom:25px;">

            <label>
                Status
            </label>

            <select

            name=
            "status"

            style="
            width:100%;
            padding:14px;
            margin-top:8px;
            border:1px solid #ddd;
            border-radius:8px;">

                <option
                value="active">

                Active

                </option>

                <option
                value="inactive">

                Inactive

                </option>

            </select>

        </div>

        <!-- BUTTON -->

        <button

        type="submit"

        name=
        "add_service"

        style="
        background:#16a34a;
        color:white;
        border:none;
        padding:14px 25px;
        border-radius:8px;
        cursor:pointer;
        font-size:16px;
        font-weight:600;">

        Add Service

        </button>

        </form>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>