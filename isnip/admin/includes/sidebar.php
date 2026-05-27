<!-- Navigation Drawer (Mandatory Shell) -->
<aside class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-primary dark:bg-primary-container docked left-0 h-full w-[260px] shadow-xl dark:shadow-none bg-gradient-to-b from-primary to-tertiary dark:from-primary-container dark:to-tertiary-container hidden md:flex">

    <!-- Brand Header -->
    <div class="px-lg mb-xl flex flex-col items-start">
        <span class="font-headline-md text-headline-md text-on-primary font-bold tracking-tight">
            ISNIS NAV
        </span>

        <span class="text-on-primary/60 font-label-md text-label-md mt-xs">
            FLEET COMMAND CENTER
        </span>
    </div>

    <!-- Profile Section -->
    <div class="px-lg mb-lg flex items-center gap-md">
        <div class="w-12 h-12 rounded-full border-2 border-on-primary/20 overflow-hidden">
            <img alt="Operator"
                 class="w-full h-full object-cover"
                 src="../customer/registrations/<?php echo $_SESSION['profile_photo']; ?>"/>
        </div>

        <div>
            <p class="font-headline-sm text-headline-sm text-on-primary leading-tight">
              <?php echo $_SESSION['full_name']; ?>
            </p>

            <p class="text-on-primary/70 font-label-md text-label-md">
              <?php echo ucfirst($_SESSION['role']); ?>
            </p>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 space-y-1 overflow-y-auto custom-scrollbar">

        <!-- Dashboard -->
        <a href="admindash.php"
           class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md hover:bg-on-primary/10 transition-all duration-200">

            <span class="material-symbols-outlined">
                dashboard
            </span>

            <span class="font-body-md text-body-md">
                Dashboard
            </span>
        </a>

        <!-- Customers -->
        <a href="customers.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                groups
            </span>

            <span class="font-body-md text-body-md">
                Customers
            </span>
        </a>

        <!-- Shipments -->
        <a href="shipment_management.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                local_shipping
            </span>

            <span class="font-body-md text-body-md">
                Shipments
            </span>
        </a>

        <!-- Cargo Management -->
        <a href="cargo.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                inventory_2
            </span>

            <span class="font-body-md text-body-md">
                Cargo Management
            </span>
        </a>

        <!-- Vessel Tracking -->
        <a href="digitalnavigation_mapping.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                sailing
            </span>

            <span class="font-body-md text-body-md">
                Vessel Tracking
            </span>
        </a>



        <!-- GPS Monitoring -->
        <a href="gpsvesseltrack.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                location_on
            </span>

            <span class="font-body-md text-body-md">
                GPS Monitoring
            </span>
        </a>



        <!-- Notifications -->
        <a href="notifications_center.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                notifications
            </span>

            <span class="font-body-md text-body-md">
                Notifications
            </span>
        </a>

        <!-- Reports -->
        <a href="operational_reports.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md hover:bg-on-primary/5 transition-all duration-200">

            <span class="material-symbols-outlined">
                assessment
            </span>

            <span class="font-body-md text-body-md">
                Reports
            </span>
        </a>

    </nav>

    <!-- Sidebar Footer -->
    <div class="mt-auto px-lg pt-lg border-t border-on-primary/10">

        <!-- Settings -->
        <a href="system_settings.php"
           class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm transition-all duration-200">

            <span class="material-symbols-outlined">
                settings
            </span>

            <span class="font-body-md text-body-md">
                Settings
            </span>
        </a>

        <!-- Logout -->
      <a href="../../customer/registrations/logout.php"
   class="flex items-center gap-sm text-error-container hover:text-on-error-container py-sm transition-all duration-200">

    <span class="material-symbols-outlined">
        logout
    </span>

    <span class="font-body-md text-body-md">
        Logout
    </span>
</a>

        <p class="text-on-primary/40 font-label-md text-[10px] mt-md">
            SYSTEM V1.2.4
        </p>

    </div>

</aside>