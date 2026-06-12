<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/* ==========================
   DELETE SERVICE
========================== */

if(isset($_GET['delete'])){

    $service_id = intval($_GET['delete']);

    // get image first
    $q = mysqli_query(
        $conn,
        "SELECT image FROM services WHERE service_id='$service_id'"
    );

    $img = mysqli_fetch_assoc($q);

    if(!empty($img['image'])){
        $path = "uploads/services/" . $img['image'];
        if(file_exists($path)){
            unlink($path);
        }
    }

    mysqli_query(
        $conn,
        "DELETE FROM services WHERE service_id='$service_id'"
    );

    header("Location: services.php");
    exit();
}


/* ==========================
   FETCH SERVICES
========================== */

$services = mysqli_query(
    $conn,
    "SELECT * FROM services ORDER BY service_id DESC"
);

$total_services = mysqli_num_rows($services);

if(isset($_POST['update_service'])){

    $id=$_POST['service_id'];
    $service_name=$_POST['service_name'];
    $service_type=$_POST['service_type'];
    $description=$_POST['description'];
    $price=$_POST['price'];
    $status=$_POST['status'];

    $stmt=$conn->prepare("
        UPDATE services
        SET
        service_name=?,
        service_type=?,
        description=?,
        price=?,
        status=?
        WHERE service_id=?
    ");

    $stmt->bind_param(
        "sssdsi",
        $service_name,
        $service_type,
        $description,
        $price,
        $status,
        $id
    );

    if($stmt->execute()){

        echo "<script>
        alert('Service Updated Successfully');
        window.location='services.php';
        </script>";

        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Services</title>
<!-- 
<link rel="stylesheet" href="assets/css/style.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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


.table-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
}

.table-card table{
    width:100%;
    border-collapse:collapse;
}

.table-card thead{
    background:#f8fafc;
}

.table-card th{
    padding:18px 24px;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:#64748b;
    text-align:left;
}

.table-card td{
    padding:18px 24px;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:25px;
}

.page-header h2{
    font-size:34px;
    font-weight:700;
}

.page-header p{
    color:#64748b;
    margin-top:5px;
}

.add-btn{
    background:#16a34a;
    color:white;
    padding:12px 20px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
}

.add-btn:hover{
    background:#15803d;
}
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.6);
    z-index:9999;
}

.modal-content{
    background:#fff;
    width:600px;
    max-width:95%;
    margin:60px auto;
    padding:25px;
    border-radius:12px;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
}

.close-btn{
    cursor:pointer;
    font-size:25px;
}

.modal input,
.modal textarea,
.modal select{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:8px;
}

.save-btn{
    background:#16a34a;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}


</style>

</head>
<body>

<?php include "includes/sidebar.php"; ?>
<?php include "includes/header.php"; ?>

<div class="content">

    <!-- HEADER -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">

        <div>
            <h2>Services</h2>
            <p style="color:#666;">Manage all technical services</p>
        </div>

        <!-- ADD BUTTON (LINKED TO SEPARATE PAGE) -->
        <a href="add_service.php"
           style="background:#16a34a;color:white;padding:12px 18px;border-radius:8px;text-decoration:none;">
           <i class="fas fa-plus"></i> Add Service
        </a>

    </div>

    <!-- STATS -->
    <div class="cards">

        <div class="card">
            <p>Total Services</p>
            <h2><?= $total_services ?></h2>
        </div>

    </div>

    <br>

    <div class="table-card">
    <div class="overflow-x-auto">

        <!-- TABLE HERE -->

    <!-- TABLE -->
    <div class="table-container">

        <table>

          <thead>
<tr>
    <th>Image</th>
    <th>Service Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($services)){ ?>

<tr>

    <!-- IMAGE -->
    <td>

        <div style="width:70px;height:50px;border-radius:8px;overflow:hidden;border:1px solid #ddd;">

            <?php if(!empty($row['image'])){ ?>

                <img
                    src="uploads/services/<?= htmlspecialchars($row['image']) ?>"
                    style="width:100%;height:100%;object-fit:cover;">

            <?php } else { ?>

                <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:11px;color:#888;">
                    No Image
                </div>

            <?php } ?>

        </div>

    </td>

    <!-- SERVICE NAME -->
    <td>

        <strong>
            <?= htmlspecialchars($row['service_name']) ?>
        </strong>

        <br>

        <small style="color:#777;">
            <?= substr(htmlspecialchars($row['description']),0,60) ?>...
        </small>

    </td>

    <!-- CATEGORY -->
    <td>

        <span style="
            background:#f1f5f9;
            padding:6px 12px;
            border-radius:6px;
            font-size:12px;
            font-weight:600;
        ">
            <?= htmlspecialchars($row['service_type']) ?>
        </span>

    </td>

    <!-- PRICE -->
    <td>

        <strong style="color:#16a34a;">
            TZS <?= number_format($row['price']) ?>
        </strong>

    </td>

    <!-- STATUS -->
    <td>

        <?php if($row['status']=='Available'){ ?>

            <span style="
                background:#dcfce7;
                color:#15803d;
                padding:6px 12px;
                border-radius:20px;
                font-size:12px;
                font-weight:600;
            ">
                Available
            </span>

        <?php } else { ?>

            <span style="
                background:#fee2e2;
                color:#b91c1c;
                padding:6px 12px;
                border-radius:20px;
                font-size:12px;
                font-weight:600;
            ">
                Unavailable
            </span>

        <?php } ?>

    </td>

    <!-- ACTIONS -->
    <td>

        <div style="display:flex;gap:10px;">

          <button
onclick="openEditModal(
'<?= $row['service_id'] ?>',
'<?= htmlspecialchars($row['service_name'],ENT_QUOTES) ?>',
'<?= htmlspecialchars($row['service_type'],ENT_QUOTES) ?>',
'<?= htmlspecialchars($row['description'],ENT_QUOTES) ?>',
'<?= $row['price'] ?>',
'<?= $row['status'] ?>'
)"
class="p-2 rounded hover:bg-green-100 text-green-700 transition">

<i class="fas fa-edit"></i>

</button>

<!-- EDIT MODAL -->

<div id="editModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <h3>Edit Service</h3>

            <span onclick="closeEditModal()" class="close-btn">
                &times;
            </span>

        </div>

       <form method="POST">

            <input type="hidden" id="service_id" name="service_id">

            <label>Service Name</label>
            <input type="text" id="service_name" name="service_name">

            <label>Category</label>
            <select id="service_type" name="service_type">
                <option value="TV">TV</option>
                <option value="CCTV">CCTV</option>
                <option value="SATELLITE">SATELLITE</option>
            </select>

<input type="hidden"
       name="update_service"
       value="1">

            <label>Description</label>
            <textarea id="description" name="description"></textarea>

            <label>Price</label>
            <input type="number" step="0.01" id="price" name="price">

            <label>Status</label>
            <select id="status" name="status">
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>

            <button type="submit" class="save-btn">
                Update Service
            </button>

        </form>

    </div>

</div>
            <a href="services.php?delete=<?= $row['service_id'] ?>"
               onclick="return confirm('Delete this service?')"
               style="
               color:#dc2626;
               font-size:18px;
               ">
                <i class="fas fa-trash"></i>
            </a>

        </div>

    </td>

</tr>

<?php } ?>

</tbody>
        </table>

    </div>

</div>


<script>

function openEditModal(
id,
name,
type,
description,
price,
status
){

    document.getElementById('service_id').value=id;
    document.getElementById('service_name').value=name;
    document.getElementById('service_type').value=type;
    document.getElementById('description').value=description;
    document.getElementById('price').value=price;
    document.getElementById('status').value=status;

    document.getElementById('editModal').style.display='block';
}

function closeEditModal(){

    document.getElementById('editModal').style.display='none';
}

</script>
<script>
setInterval(function(){
    location.reload();
},30000);
</script>

<?php include "includes/footer.php"; ?>

</body>
</html>
    </div>
</div>
