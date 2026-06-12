<?php
include('db.php');

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$image);

    $query = "INSERT INTO gallery (title, image, description, uploaded_at)
              VALUES ('$title', '$image', '$description', NOW())";

    mysqli_query($conn, $query);

    header("Location: gallery.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Project | Gallery</title>

<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-surface text-on-surface flex">

<?php include('includes/sidebar.php'); ?>

<main class="flex-1 ml-64 min-h-screen">

<?php include('includes/header.php'); ?>

<div class="p-6 pt-24 max-w-3xl mx-auto">

<h2 class="text-2xl font-bold mb-6">Add New Project</h2>

<form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow space-y-4">

<!-- Title -->
<div>
<label class="block text-sm font-medium">Title</label>
<input type="text" name="title" required class="w-full border p-2 rounded-lg">
</div>

<!-- Description -->
<div>
<label class="block text-sm font-medium">Description</label>
<textarea name="description" rows="5" class="w-full border p-2 rounded-lg"></textarea>
</div>

<!-- Image -->
<div>
<label class="block text-sm font-medium">Image</label>
<input type="file" name="image" required class="w-full border p-2 rounded-lg">
</div>

<!-- Buttons -->
<div class="flex justify-end gap-3">
<a href="gallery.php" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</a>
<button type="submit" name="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">
Save Project
</button>
</div>

</form>

</div>

<?php include('includes/footer.php'); ?>

</main>

</body>
</html>
