<?php
include("db.php");

$message = "";

if(isset($_POST['upload']))
{
    $service_id = mysqli_real_escape_string(
        $conn,
        $_POST['service_id']
    );

    $image_title = mysqli_real_escape_string(
        $conn,
        $_POST['image_title']
    );

    $image_description = mysqli_real_escape_string(
        $conn,
        $_POST['image_description']
    );

    $total_files = count($_FILES['images']['name']);

    $success_count = 0;

    for($i = 0; $i < $total_files; $i++)
    {
        $image_name = $_FILES['images']['name'][$i];
        $tmp_name   = $_FILES['images']['tmp_name'][$i];
        $error      = $_FILES['images']['error'][$i];

        if($error == 0)
        {
            $new_image_name =
                time() . "_" .
                rand(1000,9999) . "_" .
                basename($image_name);

            $upload_path =
                "../customer/uploads/" .
                $new_image_name;

            if(move_uploaded_file($tmp_name, $upload_path))
            {
                $sql = "INSERT INTO service_images
                (
                    service_id,
                    image_title,
                    image_description,
                    image_path
                )
                VALUES
                (
                    '$service_id',
                    '$image_title',
                    '$image_description',
                    '$new_image_name'
                )";

                if(mysqli_query($conn, $sql))
                {
                    $success_count++;
                }
                else
                {
                    $message =
                    "Database Error: " .
                    mysqli_error($conn);
                }
            }
        }
    }

    if($success_count > 0)
    {
        $message =
        $success_count .
        " image(s) uploaded successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Upload Service Images</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto p-8">

    <!-- HEADER -->
    <div class="bg-black text-white p-6 rounded-2xl shadow-lg mb-6">
        <h1 class="text-3xl font-bold">
            Upload Service Images
        </h1>

        <p class="text-gray-300 mt-2">
            Upload multiple images for
            CCTV, Satellite, and TV Repair
            services.
        </p>
    </div>

    <!-- SUCCESS MESSAGE -->
    <?php if(!empty($message)): ?>

        <div class="bg-green-100
                    border border-green-300
                    text-green-700
                    px-4 py-3
                    rounded-lg
                    mb-5">

            <?= $message; ?>

        </div>

    <?php endif; ?>

    <!-- UPLOAD FORM -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <form method="POST"
              enctype="multipart/form-data">

            <!-- SERVICE -->
            <div class="mb-5">

                <label class="block
                               font-semibold
                               mb-2">

                    Select Service

                </label>

                <select
                    name="service_id"
                    required
                    class="w-full
                           border
                           rounded-xl
                           p-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-blue-500">

                    <option value="">
                        -- Select Service --
                    </option>

                    <?php
                    $services =
                    mysqli_query($conn,
                    "SELECT * FROM services");

                    while($service =
                    mysqli_fetch_assoc($services)):
                    ?>

                    <option value="<?= $service['service_id']; ?>">

                        <?= $service['service_name']; ?>

                    </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <!-- IMAGES -->
            <div class="mb-5">

                <label class="block
                               font-semibold
                               mb-2">

                    Upload Images

                </label>

                <input
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/*"
                    required
                    class="w-full
                           border
                           rounded-xl
                           p-3">

                <small class="text-gray-500">
                    Hold CTRL to select multiple images
                </small>

            </div>
            <!-- IMAGE TITLE -->
<div class="mb-5">

    <label class="block font-semibold mb-2">
        Image Title
    </label>

    <input
        type="text"
        name="image_title"
        required
        placeholder="Example: CCTV Installation"
        class="w-full border rounded-xl p-3">

</div>

<!-- IMAGE DESCRIPTION -->
<div class="mb-5">

    <label class="block font-semibold mb-2">
        Description
    </label>

    <textarea
        name="image_description"
        rows="3"
        required
        placeholder="Describe what this image represents"
        class="w-full border rounded-xl p-3"></textarea>

</div>

            <!-- BUTTON -->
            <button
                type="submit"
                name="upload"
                class="bg-black
                       text-white
                       px-6 py-3
                       rounded-xl
                       hover:bg-gray-800
                       transition">

                Upload Images

            </button>

        </form>

    </div>

    <!-- IMAGE GALLERY -->
    <div class="bg-white
                rounded-2xl
                shadow-lg
                p-8
                mt-8">

        <h2 class="text-2xl
                   font-bold
                   mb-6">

            Uploaded Images

        </h2>

        <div class="grid
                    grid-cols-2
                    md:grid-cols-4
                    gap-5">

            <?php

            $query = mysqli_query($conn,

            "SELECT service_images.*,
                    services.service_name
             FROM service_images
             INNER JOIN services
             ON service_images.service_id =
                services.service_id
             ORDER BY image_id DESC");

            while($image =
            mysqli_fetch_assoc($query)):
            ?>

            <div class="bg-white
                        rounded-xl
                        overflow-hidden
                        shadow
                        border">

                <img
                    src="../customer/uploads/<?= $image['image_path']; ?>"
                    class="w-full
                           h-48
                           object-cover">

                <div class="p-3">

                    <h4 class="font-semibold">

                        <?= $image['service_name']; ?>

                    </h4>

                </div>

            </div>

            <?php endwhile; ?>

        </div>

    </div>

</div>

</body>
</html>