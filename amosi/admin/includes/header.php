<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include_once "db.php";

/* COUNT UNREAD MESSAGES */
$msgQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM contact_messages
     WHERE status='Unread'"
);

$msgCount = mysqli_fetch_assoc($msgQuery)['total'] ?? 0;

/* COUNT PENDING REQUESTS */
$reqQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM service_requests
     WHERE request_status='Pending'"
);

$reqCount = mysqli_fetch_assoc($reqQuery)['total'] ?? 0;

/* TOTAL NOTIFICATIONS */
$totalNotifications = $msgCount + $reqCount;
?>

<style>

/* HEADER */
.header{
    margin-left:250px;
    height:80px;
    background:#ffffff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 30px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    position:sticky;
    top:0;
    z-index:999;
}

.header-left h2{
    font-size:24px;
    color:#1e293b;
}

.header-left p{
    font-size:14px;
    color:#64748b;
    margin-top:3px;
}

/* RIGHT SIDE */
.header-right{
    display:flex;
    align-items:center;
    gap:20px;
}

/* NOTIFICATION */
.notification-box{
    position:relative;
    cursor:pointer;
}

.notification-icon{
    font-size:26px;
    transition:.3s;
}

.notification-icon:hover{
    transform:scale(1.1);
}

.notification-badge{
    position:absolute;
    top:-8px;
    right:-8px;
    background:#dc2626;
    color:white;
    min-width:20px;
    height:20px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:bold;
}

/* DROPDOWN */
.notification-dropdown{
    position:absolute;
    right:0;
    top:45px;
    width:320px;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
    display:none;
}

.notification-box:hover .notification-dropdown{
    display:block;
}

.notification-header{
    background:#f8fafc;
    padding:15px;
    font-weight:600;
    border-bottom:1px solid #eee;
}

.notification-item{
    padding:15px;
    border-bottom:1px solid #eee;
}

.notification-item:last-child{
    border-bottom:none;
}

.notification-item:hover{
    background:#f8fafc;
}

.notification-item a{
    text-decoration:none;
    color:#1e293b;
    display:block;
}

.notification-item strong{
    color:#16a34a;
}

/* ADMIN */
.admin-box{
    display:flex;
    align-items:center;
    gap:12px;
}

.admin-box img{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #e5e7eb;
}

.admin-box h4{
    font-size:15px;
    color:#1e293b;
}

.admin-box p{
    color:#64748b;
    font-size:13px;
}

</style>

<header class="header">

    <div class="header-left">

        <h2>Dashboard</h2>

        <p>
            Welcome back,
            <?= htmlspecialchars($_SESSION['full_name']); ?>
        </p>

    </div>

    <div class="header-right">

        <!-- NOTIFICATION BELL -->
        <div class="notification-box">

            <span class="notification-icon">🔔</span>

            <?php if($totalNotifications > 0){ ?>
                <span class="notification-badge">
                    <?= $totalNotifications ?>
                </span>
            <?php } ?>

            <div class="notification-dropdown">

                <div class="notification-header">
                    Notifications
                </div>

                <div class="notification-item">
                    <a href="messages.php">
                        <strong><?= $msgCount ?></strong>
                        unread customer message(s)
                    </a>
                </div>

                <div class="notification-item">
                    <a href="requests.php">
                        <strong><?= $reqCount ?></strong>
                        pending service request(s)
                    </a>
                </div>

            </div>

        </div>

        <!-- ADMIN PROFILE -->
        <div class="admin-box">

            <img
            src="uploads/<?=
            !empty($_SESSION['profile_image'])
            ? htmlspecialchars($_SESSION['profile_image'])
            : 'default.png';
            ?>"
            alt="Profile">

            <div>

                <h4>
                    <?= htmlspecialchars($_SESSION['full_name']); ?>
                </h4>

                <p>
                    <?= htmlspecialchars(ucfirst($_SESSION['role'])); ?>
                </p>

            </div>

        </div>

    </div>

</header>