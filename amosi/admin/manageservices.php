<?php
session_start();
include "db.php";

/*
|--------------------------------------------------------------------------
| AJAX UPDATE SERVICE
|--------------------------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] == 'update') {

    $id          = (int)$_POST['service_id'];
    $name        = mysqli_real_escape_string($conn, $_POST['service_name']);
    $type        = mysqli_real_escape_string($conn, $_POST['service_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = (float)$_POST['price'];
    $status      = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "
        UPDATE services
        SET
            service_name='$name',
            service_type='$type',
            description='$description',
            price='$price',
            status='$status'
        WHERE service_id='$id'
    ";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo mysqli_error($conn);
    }

    exit();
}


/*
|--------------------------------------------------------------------------
| AJAX DELETE SERVICE
|--------------------------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id = (int)$_GET['id'];

    // Get image first
    $imgQuery = mysqli_query(
        $conn,
        "SELECT image FROM services WHERE service_id='$id'"
    );

    if ($imgQuery && mysqli_num_rows($imgQuery) > 0) {

        $imgData = mysqli_fetch_assoc($imgQuery);

        if (!empty($imgData['image'])) {

            $path = "uploads/services/" . $imgData['image'];

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    $delete = mysqli_query(
        $conn,
        "DELETE FROM services WHERE service_id='$id'"
    );

    if ($delete) {
        echo "deleted";
    } else {
        echo mysqli_error($conn);
    }

    exit();
}


/*
|--------------------------------------------------------------------------
| FETCH SERVICES
|--------------------------------------------------------------------------
*/
$services = mysqli_query(
    $conn,
    "SELECT * FROM services ORDER BY service_id DESC"
);

if (!$services) {
    die("Query Error: " . mysqli_error($conn));
}

$total_services = mysqli_num_rows($services);

?>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Manage Services | Mr Amosi Technical Services</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-background": "#1b1b1d",
                    "secondary-fixed-dim": "#62df7d",
                    "on-tertiary-container": "#98805d",
                    "on-primary-container": "#7c839b",
                    "error-container": "#ffdad6",
                    "on-secondary": "#ffffff",
                    "surface-container-highest": "#e4e2e4",
                    "on-primary": "#ffffff",
                    "primary-fixed": "#dae2fd",
                    "surface-variant": "#e4e2e4",
                    "surface-bright": "#fcf8fa",
                    "inverse-surface": "#303032",
                    "outline-variant": "#c6c6cd",
                    "inverse-primary": "#bec6e0",
                    "on-primary-fixed-variant": "#3f465c",
                    "surface": "#fcf8fa",
                    "background": "#fcf8fa",
                    "primary-fixed-dim": "#bec6e0",
                    "tertiary-container": "#271901",
                    "on-error": "#ffffff",
                    "surface-tint": "#565e74",
                    "tertiary-fixed": "#fcdeb5",
                    "primary-container": "#131b2e",
                    "primary": "#000000",
                    "on-primary-fixed": "#131b2e",
                    "secondary-fixed": "#7ffc97",
                    "surface-container-high": "#eae7e9",
                    "on-secondary-fixed": "#002109",
                    "tertiary-fixed-dim": "#dec29a",
                    "on-tertiary-fixed-variant": "#574425",
                    "outline": "#76777d",
                    "tertiary": "#000000",
                    "secondary": "#006e2d",
                    "surface-dim": "#dcd9db",
                    "on-surface": "#1b1b1d",
                    "on-secondary-container": "#007230",
                    "error": "#ba1a1a",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "secondary-container": "#7cf994",
                    "inverse-on-surface": "#f3f0f2",
                    "on-tertiary-fixed": "#271901",
                    "on-secondary-fixed-variant": "#005320",
                    "on-surface-variant": "#45464d",
                    "on-error-container": "#93000a",
                    "surface-container-low": "#f6f3f5",
                    "surface-container": "#f0edef"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "12px",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "sm": "12px",
                    "xxl": "48px",
                    "container_max": "1280px",
                    "gutter": "24px",
                    "lg": "24px",
                    "md": "16px",
                    "base": "4px",
                    "xl": "32px",
                    "xs": "8px"
            },
            "fontFamily": {
                    "card-title": ["Inter"],
                    "page-title": ["Inter"],
                    "small-label": ["Inter"],
                    "body-text": ["Inter"],
                    "section-title": ["Inter"],
                    "hero-title": ["Inter"]
            },
            "fontSize": {
                    "card-title": ["22px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "page-title": ["36px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "small-label": ["13px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "body-text": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "section-title": ["28px", {"lineHeight": "1.3", "fontWeight": "600"}],
                    "hero-title": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .custom-shadow { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        .hover-shadow:hover { box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
    </style>
</head>
<body class="bg-background text-on-surface">
<!-- Sidebar Layout Container -->
<div class="flex min-h-screen">
<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-primary-container dark:bg-on-background flex flex-col gap-sm p-md shadow-xl z-40">
<div class="mb-xxl px-md">
<h1 class="font-card-title text-card-title font-bold text-on-primary">Admin Panel</h1>
<p class="font-small-label text-small-label text-on-primary-container opacity-80 uppercase tracking-widest mt-base">Technical Services</p>
</div>
<nav class="flex flex-col gap-xs flex-grow">
<a class="text-on-primary-container dark:text-on-primary-fixed-variant opacity-80 px-md py-sm font-small-label text-small-label flex items-center gap-md hover:bg-primary-fixed-dim hover:text-primary-container transition-all rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                    Dashboard
                </a>
<a class="bg-secondary dark:bg-secondary-container text-on-secondary dark:text-on-secondary-container rounded-lg px-md py-sm font-small-label text-small-label flex items-center gap-md transition-all scale-100 hover:scale-105 active:scale-95" href="#">
<span class="material-symbols-outlined" data-icon="build">build</span>
                    Services
                </a>
<a class="text-on-primary-container dark:text-on-primary-fixed-variant opacity-80 px-md py-sm font-small-label text-small-label flex items-center gap-md hover:bg-primary-fixed-dim hover:text-primary-container transition-all rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="assignment_late">assignment_late</span>
                    Requests
                </a>
<a class="text-on-primary-container dark:text-on-primary-fixed-variant opacity-80 px-md py-sm font-small-label text-small-label flex items-center gap-md hover:bg-primary-fixed-dim hover:text-primary-container transition-all rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="analytics">analytics</span>
                    Reports
                </a>
<a class="text-on-primary-container dark:text-on-primary-fixed-variant opacity-80 px-md py-sm font-small-label text-small-label flex items-center gap-md hover:bg-primary-fixed-dim hover:text-primary-container transition-all rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="group">group</span>
                    Users
                </a>
<a class="text-on-primary-container dark:text-on-primary-fixed-variant opacity-80 px-md py-sm font-small-label text-small-label flex items-center gap-md hover:bg-primary-fixed-dim hover:text-primary-container transition-all rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
                    Settings
                </a>
</nav>
<div class="mt-auto px-md py-lg border-t border-on-primary-container/20">
<button class="w-full flex items-center justify-center gap-xs bg-secondary text-on-secondary py-sm rounded-lg font-small-label hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined" data-icon="add">add</span>
                    New Service
                </button>
</div>
</aside>


<!-- Main Canvas -->
<main class="ml-64 flex-1 flex flex-col min-h-screen">
<!-- Top Bar Section -->
<header class="h-20 bg-surface px-xl flex items-center justify-between border-b border-outline-variant sticky top-0 z-30">
<div class="flex-1 max-w-xl">
<div class="relative group">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-secondary transition-colors" data-icon="search">search</span>
<input class="w-full pl-12 pr-md py-sm border border-outline rounded-lg bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all font-body-text text-body-text" placeholder="Search for technical services, categories, or price..." type="text"/>
</div>
</div>
<div class="flex items-center gap-lg">
<button class="p-xs text-on-surface-variant hover:bg-surface-variant rounded-full transition-colors relative">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
</button>
<div class="h-10 w-10 rounded-full overflow-hidden border border-outline-variant">
<img alt="Admin Avatar" data-alt="A professional headshot of a senior technical administrator in a minimalist office setting. He is wearing a dark polo shirt, looking confident and approachable. The lighting is crisp and natural, with a blurred modern architectural background, emphasizing a corporate and high-end technical environment." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6m2JfJTfSCW-LqVC72Bo7d_CgxO-3PrWNTGJD1Z04l8NlnsqlLK73YTt8zB6gD87usu8mC_HH3Z0BMvdZk02okVEc658uV6SDYfviHBGIT7uuCxMlVAk4EZNACJ8EChxeah1GEXEXKXY67fNTvWE59Wlx_vFkqUoEdXUOTmcLQjlIB_nO5uQyI23c12zWk9pJZV4Kd8IFXwfNLTkoMUufZHWm7-aVAU7xZ-VTQzjxlK49dIe_tf233DtBaz3QEZC9ejxjXlJ7lTZk"/>
</div>
</div>
</header>
<!-- Content Area -->
<section class="p-xl space-y-xl">
<!-- Header Actions -->
<div class="flex justify-between items-end">
<div>
<h2 class="font-page-title text-page-title text-primary">Manage Services</h2>
<p class="font-body-text text-body-text text-on-surface-variant mt-xs">Update and organize your technical service offerings.</p>
</div>
<button>    <a href="add_service.php"
           style="background:#16a34a;color:white;padding:12px 18px;border-radius:8px;text-decoration:none;">
           <i class="fas fa-plus"></i> Add Service
        </a>
                    </button>
       
</div>

<!-- Services Data Table Card -->
<div class="bg-surface-container-lowest rounded-lg border border-outline-variant custom-shadow overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container border-b border-outline-variant">
<th class="px-xl py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Image</th>
<th class="px-xl py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Service Name</th>
<th class="px-xl py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Category</th>
<th class="px-xl py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Price</th>
<th class="px-xl py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Status</th>
<th class="px-xl py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>


<tbody class="divide-y divide-outline-variant font-body-text text-body-text">

<?php while($service = mysqli_fetch_assoc($services)) { ?>

<tr class="hover:bg-surface-container-low transition-colors">

    <!-- IMAGE -->
    <td class="px-xl py-md">
        <div class="w-16 h-12 rounded-lg overflow-hidden border border-outline-variant bg-surface-variant">

            <?php if(!empty($service['image'])) { ?>
                <img
                    src="../uploads/services/<?php echo htmlspecialchars($service['image']); ?>"
                    alt="<?php echo htmlspecialchars($service['service_name']); ?>"
                    class="w-full h-full object-cover">
            <?php } else { ?>
                <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">
                    No Image
                </div>
            <?php } ?>

        </div>
    </td>

    <!-- SERVICE NAME -->
    <td class="px-xl py-md">
        <span class="font-semibold text-on-surface">
            <?php echo htmlspecialchars($service['service_name']); ?>
        </span>

        <div class="text-[12px] text-on-surface-variant">
            <?php echo htmlspecialchars(substr($service['description'], 0, 50)); ?>...
        </div>
    </td>

    <!-- CATEGORY -->
    <td class="px-xl py-md">
        <span class="px-sm py-1 bg-surface-container-highest rounded text-on-surface-variant font-medium text-xs">
            <?php echo htmlspecialchars($service['service_type']); ?>
        </span>
    </td>

    <!-- PRICE -->
    <td class="px-xl py-md font-medium text-primary">
        TZS <?php echo number_format($service['price'], 2); ?>
    </td>

    <!-- STATUS -->
    <td class="px-xl py-md">

        <?php
        $status = strtolower($service['status']);

        if($status == 'available'){
            echo '
            <span class="inline-flex items-center gap-1 px-sm py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-secondary"></span>
                Available
            </span>';
        } else {
            echo '
            <span class="inline-flex items-center gap-1 px-sm py-1 bg-error-container text-on-error-container rounded-full text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-error"></span>
                Unavailable
            </span>';
        }
        ?>

    </td>

    <!-- ACTIONS -->
    <td class="px-xl py-md text-right">
    <div class="flex justify-end gap-sm">

        <button
            onclick="openEditModal(
                '<?php echo $service['service_id']; ?>',
                '<?php echo htmlspecialchars($service['service_name'], ENT_QUOTES); ?>',
                '<?php echo htmlspecialchars($service['service_type'], ENT_QUOTES); ?>',
                '<?php echo htmlspecialchars($service['description'], ENT_QUOTES); ?>',
                '<?php echo $service['price']; ?>',
                '<?php echo $service['status']; ?>'
            )"
            class="p-xs hover:bg-secondary-container hover:text-secondary rounded transition-all">

            <span class="material-symbols-outlined text-[20px]">
                edit
            </span>

        </button>

        <button
            onclick="deleteService(<?php echo $service['service_id']; ?>)"
            class="p-xs hover:bg-error-container hover:text-error rounded transition-all">

            <span class="material-symbols-outlined text-[20px]">
                delete
            </span>

        </button>

    </div>
</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>



<!-- Table Footer Pagination -->
<div class="px-xl py-md bg-surface-container flex items-center justify-between border-t border-outline-variant">
<span class="font-small-label text-small-label text-on-surface-variant">Showing 1 to 4 of 24 services</span>
<div class="flex gap-xs">
<button class="px-md py-1 border border-outline rounded-md font-small-label text-on-surface hover:bg-surface-container-lowest transition-colors">Previous</button>
<button class="px-md py-1 border border-outline bg-secondary text-on-secondary rounded-md font-small-label">1</button>
<button class="px-md py-1 border border-outline rounded-md font-small-label text-on-surface hover:bg-surface-container-lowest transition-colors">2</button>
<button class="px-md py-1 border border-outline rounded-md font-small-label text-on-surface hover:bg-surface-container-lowest transition-colors">3</button>
<button class="px-md py-1 border border-outline rounded-md font-small-label text-on-surface hover:bg-surface-container-lowest transition-colors">Next</button>
</div>
</div>
</div>

<!-- EDIT MODAL -->
<div
    id="editModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl w-full max-w-2xl p-6">

        <div class="flex justify-between items-center mb-5">

            <h3 class="text-xl font-bold">
                Edit Service
            </h3>

            <button onclick="closeEditModal()">
                ✕
            </button>

        </div>

        <form id="editForm">

            <input type="hidden" name="service_id" id="service_id">

            <div class="mb-4">

                <label>Service Name</label>

                <input
                    type="text"
                    name="service_name"
                    id="service_name"
                    class="w-full border p-2 rounded">

            </div>

            <div class="mb-4">

                <label>Service Type</label>

                <input
                    type="text"
                    name="service_type"
                    id="service_type"
                    class="w-full border p-2 rounded">

            </div>

            <div class="mb-4">

                <label>Description</label>

                <textarea
                    name="description"
                    id="description"
                    class="w-full border p-2 rounded"></textarea>

            </div>

            <div class="mb-4">

                <label>Price</label>

                <input
                    type="number"
                    step="0.01"
                    name="price"
                    id="price"
                    class="w-full border p-2 rounded">

            </div>

            <div class="mb-4">

                <label>Status</label>

                <select
                    name="status"
                    id="status"
                    class="w-full border p-2 rounded">

                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>

                </select>

            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded">

                Save Changes

            </button>

        </form>

    </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const editForm = document.getElementById("editForm");

    if(editForm){

        editForm.addEventListener("submit", function(e){

            e.preventDefault();

            const formData = new FormData(this);

            fetch("services.php?action=update", {
                method: "POST",
                body: formData
            })
            .then(response => {

                if(!response.ok){
                    throw new Error("Network response was not OK");
                }

                return response.text();
            })
            .then(data => {

                console.log("Update Response:", data);

                data = data.trim();

                if(data === "success"){

                    alert("Service updated successfully");

                    closeEditModal();

                    location.reload();

                }else{

                    alert("Update failed:\n" + data);

                }

            })
            .catch(error => {

                console.error(error);

                alert("Error updating service.");

            });

        });

    }

});
</script>

<script>
function deleteService(id){

    if(!confirm("Are you sure you want to delete this service?")){
        return;
    }

    fetch("services.php?action=delete&id=" + id, {
        method: "GET"
    })
    .then(response => {

        if(!response.ok){
            throw new Error("Network response was not OK");
        }

        return response.text();
    })
    .then(data => {

        console.log("Delete Response:", data);

        data = data.trim();

        if(data === "deleted"){

            alert("Service deleted successfully");

            location.reload();

        }else{

            alert("Delete failed:\n" + data);

        }

    })
    .catch(error => {

        console.error(error);

        alert("Error deleting service.");

    });

}
</script>

<!-- Footer Component -->
<footer class="w-full py-xxl bg-surface-container-high dark:bg-surface-container-highest border-t border-outline-variant">
<div class="max-w-container_max mx-auto px-lg grid grid-cols-1 md:grid-cols-4 gap-xl">
<div class="col-span-1 md:col-span-1">
<h3 class="font-card-title text-card-title font-bold text-primary mb-md">Mr Amosi</h3>
<p class="font-body-text text-body-text text-on-surface-variant">Expert technical solutions for premium commercial and residential properties.</p>
</div>
<div>
<h4 class="font-small-label text-small-label uppercase tracking-widest text-primary font-bold mb-md">Links</h4>
<ul class="space-y-sm">
<li><a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Home</a></li>
<li><a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Services</a></li>
<li><a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">About</a></li>
</ul>
</div>
<div>
<h4 class="font-small-label text-small-label uppercase tracking-widest text-primary font-bold mb-md">Support</h4>
<ul class="space-y-sm">
<li><a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Privacy Policy</a></li>
<li><a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Terms of Service</a></li>
<li><a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Help Center</a></li>
</ul>
</div>
<div>
<h4 class="font-small-label text-small-label uppercase tracking-widest text-primary font-bold mb-md">Copyright</h4>
<p class="font-body-text text-body-text text-on-surface-variant">© 2024 Mr Amosi Technical Services. All rights reserved.</p>
</div>
</div>
</footer>
</section>
</main>
</div>
</body></html>