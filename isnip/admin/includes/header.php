<!-- TopAppBar -->
<header class="fixed top-0 right-0 left-0 md:left-[260px] z-40 bg-surface dark:bg-surface-dim shadow-sm dark:shadow-none border-b border-outline-variant dark:border-outline h-16 flex justify-between items-center px-lg">

<div class="flex items-center gap-md">
    <button class="md:hidden text-primary">
        <span class="material-symbols-outlined">menu</span>
    </button>

    <h1 class="font-headline-sm text-headline-sm text-primary font-bold">
       <?php echo ucfirst($_SESSION['role']); ?>
    </h1>
</div>

<div class="flex items-center gap-lg">

    <div class="hidden sm:flex items-center bg-surface-container-low px-md py-xs rounded-full border border-outline-variant">

        <span class="material-symbols-outlined text-outline text-sm mr-xs">
            search
        </span>

        <input class="bg-transparent border-none outline-none text-body-sm font-body-sm text-on-surface placeholder:text-outline w-48"
            placeholder="Search manifest ID..."
            type="text"/>
    </div>

    <div class="flex items-center gap-md">

        <div class="relative cursor-pointer">
            <span class="material-symbols-outlined text-on-surface-variant">
                notifications
            </span>

            <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-surface"></span>
        </div>

        <div class="h-8 w-px bg-outline-variant"></div>

        <img alt="User"
            class="w-8 h-8 rounded-full border border-primary"
            src="../customer/registrations/<?php echo $_SESSION['profile_photo']; ?>"/>
    </div>

</div>

</header>