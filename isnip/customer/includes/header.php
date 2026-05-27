<!-- TopAppBar -->
<header class="fixed top-0 left-0 w-full z-40 flex justify-between items-center px-lg h-16 bg-surface shadow-sm border-b border-outline-variant">

    <div class="flex items-center gap-md">

        <span id="menuBtn"
            class="material-symbols-outlined text-primary cursor-pointer active:opacity-80">
            menu
        </span>

        <h1 class="font-headline-md text-headline-md font-bold text-primary">
            ISNIS Navigation
        </h1>
    </div>

    <div class="flex items-center gap-md">

        <nav class="hidden md:flex gap-lg">
            <span class="font-label-md text-label-md text-on-surface-variant cursor-pointer hover:bg-surface-container-high transition-colors px-2 py-1 rounded">
                DASHBOARD
            </span>

            <span class="font-label-md text-label-md text-primary font-bold cursor-pointer hover:bg-surface-container-high transition-colors px-2 py-1 rounded">
                PROFILE
            </span>
        </nav>

        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-container cursor-pointer">

           <img
                  class="w-10 h-10 rounded-full border-2 border-on-primary/20"
                 src="<?php echo !empty($photo) ? $photo : 'uploads/default.png'; ?>"
                alt="Profile Photo">
        </div>

    </div>

</header>