<?php
// gallery.php - Work Gallery Display Page
include('db.php');

$query = "SELECT * FROM gallery ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Work Gallery | Amosi Technical Services</title>

<!-- System CSS
<link rel="stylesheet" href="assets/css/style.css">

<!-- Tailwind -->
<!-- <script src="https://cdn.tailwindcss.com"></script> -->

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"> -->

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

<body class="bg-surface text-on-surface flex">

<!-- Sidebar -->
<?php include('includes/sidebar.php'); ?>

<!-- Main Area -->
<main class="flex-1 ml-64 min-h-screen">

<!-- Header -->
<?php include('includes/header.php'); ?>

<div class="p-6 pt-24">

<!-- Top Action Bar -->
<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-bold">Work Gallery</h2>
<a href="add_gallery.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
+ Add Project
</a>
</div>

<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

<div class="h-52 overflow-hidden">
<img src="uploads/<?php echo $row['image']; ?>" class="w-full h-full object-cover">
</div>

<div class="p-4">
<h3 class="font-semibold text-lg"><?php echo $row['title']; ?></h3>

<p class="text-sm text-gray-500 mt-1">
<?php echo $row['description']; ?>
</p>

<div class="flex justify-between items-center mt-4 text-xs text-gray-400">
<span><?php echo date('d M Y', strtotime($row['uploaded_at'])); ?></span>

<div class="flex gap-2">
<a href="edit_gallery.php?id=<?php echo $row['gallery_id']; ?>" class="text-blue-600">Edit</a>
<a href="delete_gallery.php?id=<?php echo $row['gallery_id']; ?>" class="text-red-600" onclick="return confirm('Delete this item?')">Delete</a>
</div>
</div>

</div>
</div>

<?php } ?>

</div>

</div>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

</main>

</body>
</html>
