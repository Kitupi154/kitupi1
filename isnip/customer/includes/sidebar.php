<?php

// Start session safely

/*
Include database safely
*/
include(__DIR__ . "/../registrations/db.php");

// Default values
$full_name = "Guest";
$role = "Visitor";
$photo = "";

// Get logged in user
if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    $query = mysqli_query($conn,
    "SELECT * FROM users WHERE user_id='$user_id'");

    if($query && mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

        $full_name = $user['full_name'];
        $role = $user['role'];
        $photo = $user['profile_photo'];
    }
}
?>
<!-- NavigationDrawer -->
<aside id="sidebar" class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-primary shadow-xl w-[260px] bg-gradient-to-b from-primary to-tertiary transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

    <div class="px-xl mb-xl flex items-center gap-md">
        <div class="w-12 h-12 rounded-lg bg-surface-container-lowest/20 flex items-center justify-center">
            <span class="material-symbols-outlined text-on-primary"
                style="font-variation-settings: 'FILL' 1;">
                sailing
            </span>
        </div>

        <div>
<p class="font-headline-sm text-[14px] text-on-primary truncate">
    <?php echo htmlspecialchars($full_name); ?>
</p>

<p class="font-body-sm text-[11px] text-on-primary/70 capitalize">
    <?php echo htmlspecialchars($role); ?>
</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1">

        <a href="customerdash.php"
            class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md mx-md rounded hover:bg-on-primary/5 transition-all duration-200">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-body-md text-body-md">Dashboard</span>
        </a>

        <a href="shipments.php"
            class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md mx-md rounded hover:bg-on-primary/5 transition-all duration-200">
            <span class="material-symbols-outlined">local_shipping</span>
            <span class="font-body-md text-body-md">Shipments</span>
        </a>

        <a href="vessel tracking.php"
            class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md mx-md rounded hover:bg-on-primary/5 transition-all duration-200">
            <span class="material-symbols-outlined">sailing</span>
            <span class="font-body-md text-body-md">
                Vessel Tracking
            </span>
        </a>

        <a href="customer_profile.php"
            class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md mx-md">
            <span class="material-symbols-outlined"
                style="font-variation-settings: 'FILL' 1;">
                account_circle
            </span>
            <span class="font-body-md text-body-md">
                Profile
            </span>
        </a>

<a href="registrations/logout.php"
   class="flex items-center gap-sm 
   bg-error-container/20 text-error 
   border-l-4 border-error 
   py-sm px-md mx-md rounded-r-lg hover:bg-error-container/40 transition">

    <span class="material-symbols-outlined"
          style="font-variation-settings: 'FILL' 1;">
        logout
    </span>

    <span class="font-body-md text-body-md">
        Logout
    </span>
</a>
  
    </nav>

    <div class="mt-auto px-md pt-xl border-t border-on-primary/10">
        <div class="flex items-center gap-sm px-sm py-md">
            <div class="w-8 h-8 rounded-full bg-tertiary-fixed-dim/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary text-sm">
                    info
                </span>
            </div>

            <span class="font-label-md text-label-md text-on-primary/60">
                V1.2.4
            </span>
        </div>
    </div>

</aside>