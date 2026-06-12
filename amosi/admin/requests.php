<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/* UPDATE STATUS */
if(isset($_GET['action']) && isset($_GET['id'])){

    $id = intval($_GET['id']);
    $action = $_GET['action'];

    $allowed = ['Pending','In Progress','Completed','Cancelled'];

    if(in_array($action, $allowed)){
        $stmt = $conn->prepare(
            "UPDATE service_requests
             SET request_status=?
             WHERE request_id=?"
        );
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: requests.php");
    exit();
}
$result = mysqli_query($conn,"
SELECT
    sr.*,
    s.service_name
FROM service_requests sr
LEFT JOIN services s
ON sr.service_id = s.service_id
ORDER BY sr.request_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Requests</title>

<!-- ONLY ONE CSS FILE -->
<!-- <link rel="stylesheet" href="assets/css/style.css"> -->

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
.content-area{
    margin-left:250px;
    margin-top:80px;
    padding:30px;
    min-height:100vh;
}

/* CONTENT AREA */
.content-area{
    margin-left:250px;
    margin-top:80px;
    padding:30px;
    min-height:100vh;
    background:#fcf8fa;
}

/* PAGE HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:30px;
}

.page-header h2{
    font-size:36px;
    font-weight:700;
    color:#1b1b1d;
}

.page-header p{
    color:#76777d;
    margin-top:5px;
}

/* TABLE CARD */
.table-card{
    background:#fff;
    border:1px solid #c6c6cd;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.table-card table{
    width:100%;
    border-collapse:collapse;
}

.table-card thead{
    background:#f0edef;
}

.table-card th{
    padding:18px 20px;
    text-transform:uppercase;
    font-size:12px;
    color:#76777d;
    letter-spacing:.08em;
    text-align:left;
}

.table-card td{
    padding:18px 20px;
    border-top:1px solid #e4e2e4;
}

.table-card tbody tr:hover{
    background:#f8fafc;
}

/* STATUS BADGES */
.badge{
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.pending{
    background:#ececec;
    color:#555;
}

.progress{
    background:#dbeafe;
    color:#1d4ed8;
}

.completed{
    background:#dcfce7;
    color:#15803d;
}

.cancelled{
    background:#fee2e2;
    color:#b91c1c;
}

/* ACTION BUTTONS */
.action-buttons{
    display:flex;
    gap:8px;
}

.btn{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    text-decoration:none;
    transition:.3s;
}

.btn-view{
    background:#f3f4f6;
}

.btn-process{
    background:#dbeafe;
    color:#2563eb;
}

.btn-done{
    background:#dcfce7;
    color:#16a34a;
}

.btn-cancel{
    background:#fee2e2;
    color:#dc2626;
}

.btn:hover{
    transform:translateY(-2px);
}

/* FILTER BAR */
.filter-bar{
    display:flex;
    gap:15px;
    margin-bottom:20px;
}

.filter-bar input{
    flex:1;
    padding:12px 15px;
    border:1px solid #c6c6cd;
    border-radius:10px;
    outline:none;
}

.filter-bar input:focus{
    border-color:#16a34a;
}
/* MODAL */

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
}

.modal-content{
    width:420px;
    max-width:90%;
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
    animation:popup .25s ease;
}

@keyframes popup{
    from{
        transform:scale(.9);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 22px;
    border-bottom:1px solid #eee;
}

.modal-header h3{
    font-size:20px;
    color:#111827;
}

.close-modal{
    font-size:28px;
    cursor:pointer;
    color:#6b7280;
}

.modal-body{
    padding:22px;
}

.detail-row{
    margin-bottom:18px;
}

.detail-row label{
    display:block;
    font-size:12px;
    text-transform:uppercase;
    color:#6b7280;
    margin-bottom:6px;
    font-weight:600;
}

.detail-row span{
    display:block;
    font-size:15px;
    color:#111827;
    font-weight:500;
}

</style>
</head>

<body class="bg-surface text-on-surface flex">

<?php include "includes/sidebar.php"; ?>
<?php include "includes/header.php"; ?>

<main class="content-area">

<div class="page-header">
    <div>
        <h2>Customer Requests</h2>
        <p>Manage and respond to technical service inquiries</p>
    </div>
</div>

<div class="filter-bar">
    <input type="text" placeholder="Search requests...">
</div>

<div class="table-card">

<table>

<thead>
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Phone</th>
    <th>Service</th>
    <th>Status</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>#REQ-<?= $row['request_id'] ?></td>

<td>
    <strong><?= htmlspecialchars($row['customer_name']) ?></strong>
</td>

<td>
    <?= htmlspecialchars($row['phone']) ?>
</td>

<td>
    <?= htmlspecialchars($row['service_name']) ?>
</td>

<td>

<?php
$s = $row['request_status'];

if($s=="Pending"){
    echo "<span class='badge pending'>Pending</span>";
}
elseif($s=="In Progress"){
    echo "<span class='badge progress'>In Progress</span>";
}
elseif($s=="Completed"){
    echo "<span class='badge completed'>Completed</span>";
}
else{
    echo "<span class='badge cancelled'>Cancelled</span>";
}
?>

</td>

<td>
<?= date("d M Y", strtotime($row['requested_at'])) ?>
</td>

<td>

<div class="action-buttons">

<a href="#"
   class="btn btn-view"
 onclick="openModal(
'<?= htmlspecialchars($row['customer_name']) ?>',
'<?= htmlspecialchars($row['phone']) ?>',
'<?= htmlspecialchars($row['service_name']) ?>',
'<?= htmlspecialchars($row['location']) ?>'
)">
   👁
</a>

<a class="btn btn-process"
   title="Mark In Progress"
   href="requests.php?action=In Progress&id=<?= $row['request_id'] ?>">
   ⚙
</a>

<a class="btn btn-done"
   title="Mark Completed"
   href="requests.php?action=Completed&id=<?= $row['request_id'] ?>">
   ✓
</a>

<a class="btn btn-cancel"
   title="Cancel Request"
   onclick="return confirm('Cancel request?')"
   href="requests.php?action=Cancelled&id=<?= $row['request_id'] ?>">
   ✕
</a>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
</div> <!-- table-card -->


<!-- VIEW REQUEST MODAL -->
<div id="viewModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h3>Request Details</h3>

            <span class="close-modal"
                  onclick="closeModal()">&times;</span>
        </div>

        <div class="modal-body">

            <div class="detail-row">
                <label>Customer Name</label>
                <span id="modalName"></span>
            </div>

            <div class="detail-row">
                <label>Phone Number</label>
                <span id="modalPhone"></span>
            </div>

         <div class="detail-row">
    <label>Selected Service</label>
    <span id="modalService"></span>
</div>

            <div class="detail-row">
                <label>Location</label>
                <span id="modalLocation"></span>
            </div>

        </div>

    </div>

</div>
</main>

<script>

function openModal(name, phone, service, location){

    document.getElementById('modalName').innerText = name;
    document.getElementById('modalPhone').innerText = phone;
    document.getElementById('modalService').innerText = service;
    document.getElementById('modalLocation').innerText = location;

    document.getElementById('viewModal').style.display = 'flex';
}

function closeModal(){

    document.getElementById('viewModal').style.display = 'none';
}

window.onclick = function(event){

    const modal = document.getElementById('viewModal');

    if(event.target === modal){
        modal.style.display = 'none';
    }
}
function openModal(name, phone, service, location){

    document.getElementById('modalName').innerText = name;
    document.getElementById('modalPhone').innerText = phone;
    document.getElementById('modalService').innerText = service;
    document.getElementById('modalLocation').innerText = location;

    document.getElementById('viewModal').style.display = 'flex';
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