<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$current_page =
basename($_SERVER['PHP_SELF']);
?>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <!-- LOGO -->
    <div class="logo-box">

        <div>

            <h2 class="logo-text">
                AMOSI
            </h2>

            <small class="logo-sub">
                Technical Services
            </small>

        </div>

        <!-- TOGGLE BUTTON -->
        <button
        id="toggleSidebar"
        class="toggle-btn">

            ☰

        </button>

    </div>

    <!-- MENU -->
    <ul class="menu">

        <!-- DASHBOARD -->
        <li>

            <a href="admindash.php"
            class="<?=
            ($current_page
            == 'admindash.php')
            ? 'active' : ''
            ?>">

                <span class="icon">
                    📊
                </span>

                <span class="text">
                    Dashboard
                </span>

            </a>

        </li>

        <!-- SERVICES -->
        <li>

            <a href="services.php"
            class="<?=
            ($current_page
            == 'services.php')
            ? 'active' : ''
            ?>">

                <span class="icon">
                    🛠
                </span>

                <span class="text">
                    Services
                </span>

            </a>

        </li>

        <!-- REQUESTS -->
        <li>

            <a href="requests.php"
            class="<?=
            ($current_page
            == 'requests.php')
            ? 'active' : ''
            ?>">

                <span class="icon">
                    📋
                </span>

                <span class="text">
                    Requests
                </span>

            </a>

        </li>

        <!-- CONTACT MESSAGES -->
        <li>

            <a href="messages.php"
            class="<?=
            ($current_page
            == 'messages.php')
            ? 'active' : ''
            ?>">

                <span class="icon">
                    ✉️
                </span>

                <span class="text">
                    Messages
                </span>

            </a>

        </li>

        <!-- GALLERY -->
        <li>

            <a href="gallery.php"
            class="<?=
            ($current_page
            == 'gallery.php')
            ? 'active' : ''
            ?>">

                <span class="icon">
                    🖼
                </span>

                <span class="text">
                    Gallery
                </span>

            </a>

        </li>

     
 
        <!-- SETTINGS -->
        <li>

            <a href="setting.php"
            class="<?=
            ($current_page
            == 'setting.php')
            ? 'active' : ''
            ?>">

                <span class="icon">
                    ⚙️
                </span>

                <span class="text">
                    Settings
                </span>

            </a>

        </li>

    </ul>

    <!-- FOOTER -->
    <div class="sidebar-footer">

        <a href="logout.php">

            <span class="icon">
                🚪
            </span>

            <span class="text">
                Logout
            </span>

        </a>

    </div>

</aside>