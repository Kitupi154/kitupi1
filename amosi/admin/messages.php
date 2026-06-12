<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/* ACTIONS */
if(isset($_GET['read'])){
    $id = $_GET['read'];
    mysqli_query($conn, "UPDATE contact_messages SET status='Read' WHERE message_id='$id'");
    header("Location: messages.php");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM contact_messages WHERE message_id='$id'");
    header("Location: messages.php");
}

/* FETCH MESSAGES */
$messages = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY sent_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Messages</title>
<!-- 
<link rel="stylesheet" href="assets/css/style.css"> -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<!-- <style>
body{font-family:Inter,sans-serif;}
</style> -->

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

.messages-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.messages-table{
    width:100%;
    border-collapse:collapse;
}

.messages-table th{
    background:#f8fafc;
    padding:18px;
    text-align:left;
    color:#64748b;
    font-size:12px;
    text-transform:uppercase;
}

.messages-table td{
    padding:18px;
    border-top:1px solid #eee;
}

.messages-table tr:hover{
    background:#f8fafc;
}

.unread-row{
    background:#eff6ff;
}

.sender-info{
    display:flex;
    flex-direction:column;
}

.sender-info small{
    color:#888;
}

.message-preview{
    display:flex;
    gap:8px;
}

.subject{
    font-weight:600;
}

.preview{
    color:#777;
}

.badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.unread{
    background:#fee2e2;
    color:#dc2626;
}

.read{
    background:#dcfce7;
    color:#15803d;
}

.replied{
    background:#dbeafe;
    color:#2563eb;
}

.action-buttons{
    display:flex;
    gap:10px;
}

.btn-view,
.btn-read,
.btn-delete{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    text-decoration:none;
    border:none;
    cursor:pointer;
}

.btn-view{
    background:#f3f4f6;
}

.btn-read{
    background:#dcfce7;
}

.btn-delete{
    background:#fee2e2;
}

/* MODAL */

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.5);
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-content{
    background:#fff;
    width:500px;
    max-width:95%;
    border-radius:16px;
    overflow:hidden;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
    border-bottom:1px solid #eee;
}

.close-btn{
    font-size:30px;
    cursor:pointer;
}

.modal-body{
    padding:20px;
}

.modal-body p{
    margin-bottom:12px;
    line-height:1.6;
}

</style>
</head>

<body>

<?php include "includes/sidebar.php"; ?>
<?php include "includes/header.php"; ?>

<div class="content">

<!-- PAGE TITLE -->
<div style="margin-bottom:20px;">
    <h2>Customer Messages</h2>
    <p style="color:#666;">All incoming customer requests and inquiries</p>
</div>

<!-- TABLE --><div class="messages-card">

<table class="messages-table">

<thead>
<tr>
    <th>Name</th>
  <th>Service</th>
<th>Message</th>>
    <th>Status</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($messages)) { ?>

<tr class="<?= ($row['status'] == 'Unread') ? 'unread-row' : '' ?>">

    <!-- CUSTOMER -->
    <td>
        <div class="sender-info">
            <strong><?= htmlspecialchars($row['full_name']) ?></strong>
            <small><?= htmlspecialchars($row['phone']) ?></small>
        </div>
    </td>

    <!-- SERVICE + PREVIEW -->
  <!-- SERVICE -->
<td>
    <strong>
        <?= htmlspecialchars($row['service_type']) ?>
    </strong>
</td>

<!-- MESSAGE -->
<td style="max-width:350px;">

    <?= strlen($row['message']) > 80
        ? htmlspecialchars(substr($row['message'],0,80))."..."
        : htmlspecialchars($row['message']) ?>

</td>

    <!-- STATUS -->
    <td>

        <?php if($row['status'] == "Unread"){ ?>

            <span class="badge unread">Unread</span>

        <?php } else { ?>

            <span class="badge read">Read</span>

        <?php } ?>

    </td>

    <!-- DATE -->
    <td>
        <?= date("d M Y h:i A", strtotime($row['sent_at'])) ?>
    </td>

    <!-- ACTIONS -->
    <td>

        <div class="action-buttons">

            <!-- VIEW -->

            <button
            class="btn-view"
            onclick="showMessage(
            '<?= htmlspecialchars(addslashes($row['full_name'])) ?>',
            '<?= htmlspecialchars(addslashes($row['phone'])) ?>',
            '<?= htmlspecialchars(addslashes($row['email'])) ?>',
            '<?= htmlspecialchars(addslashes($row['service_type'])) ?>',
            `<?= addslashes($row['message']) ?>`
            )">
            👁
            </button>

            <!-- MARK AS READ -->

            <a href="?read=<?= $row['message_id'] ?>" class="btn-read">
                ✔
            </a>

            <!-- DELETE -->

            <a
            href="?delete=<?= $row['message_id'] ?>"
            class="btn-delete"
            onclick="return confirm('Delete this message?')">
            🗑
            </a>

        </div>

    </td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
<div id="messageModal" class="modal">

<div class="modal-content">

<div class="modal-header">
    <h3>Customer Message</h3>

    <span class="close-btn"
    onclick="closeMessage()">
    &times;
    </span>
</div>
<div class="modal-body">

    <p>
        <strong>Customer Name:</strong><br>
        <span id="modalName"></span>
    </p>

    <p>
        <strong>Phone Number:</strong><br>
        <span id="modalPhone"></span>
    </p>

    <p>
        <strong>Email Address:</strong><br>
        <span id="modalEmail"></span>
    </p>

    <p>
        <strong>Service Requested:</strong><br>
        <span id="modalService"></span>
    </p>

    <hr style="margin:15px 0;">

    <p>
        <strong>Customer Message:</strong>
    </p>

    <p id="modalMessage"></p>

</div>

</div>

</div>

<script>

function showMessage(name, phone, email, service, message){

    document.getElementById("modalName").innerText = name;
    document.getElementById("modalPhone").innerText = phone;
    document.getElementById("modalEmail").innerText = email;
    document.getElementById("modalService").innerText = service;
    document.getElementById("modalMessage").innerText = message;

    document.getElementById("messageModal").style.display = "flex";
}

function closeMessage(){
    document.getElementById("messageModal").style.display = "none";
}

window.onclick = function(event){

    let modal = document.getElementById("messageModal");

    if(event.target == modal){
        modal.style.display = "none";
    }
}

</script>

<script>
setInterval(function(){
    location.reload();
},30000);
</script>

</body>
</html>