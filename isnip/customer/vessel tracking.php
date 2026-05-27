<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("registrations/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS PORTAL - Live Vessel Tracking</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-primary": "#abc7ff",
                    "secondary-fixed-dim": "#c6c6c7",
                    "surface": "#f6f9ff",
                    "secondary-fixed": "#e2e2e2",
                    "on-error": "#ffffff",
                    "error": "#ba1a1a",
                    "primary-fixed-dim": "#abc7ff",
                    "tertiary-fixed-dim": "#98cbff",
                    "surface-container-high": "#e2e9f1",
                    "primary-fixed": "#d7e2ff",
                    "outline": "#737783",
                    "tertiary-fixed": "#cfe5ff",
                    "inverse-on-surface": "#ebf1fa",
                    "inverse-surface": "#2a3138",
                    "on-surface": "#151c22",
                    "on-secondary-fixed": "#1a1c1c",
                    "tertiary-container": "#004f7f",
                    "surface-bright": "#f6f9ff",
                    "on-primary": "#ffffff",
                    "background": "#f6f9ff",
                    "primary": "#00346f",
                    "surface-container-lowest": "#ffffff",
                    "surface-tint": "#255dad",
                    "on-secondary-fixed-variant": "#454747",
                    "tertiary": "#00385c",
                    "surface-variant": "#dce3ec",
                    "on-primary-fixed-variant": "#00458f",
                    "secondary-container": "#dfe0e0",
                    "primary-container": "#004a99",
                    "on-secondary-container": "#616363",
                    "on-primary-fixed": "#001b3f",
                    "on-tertiary-container": "#82c2ff",
                    "error-container": "#ffdad6",
                    "on-primary-container": "#9bbdff",
                    "on-tertiary-fixed-variant": "#004a77",
                    "outline-variant": "#c2c6d3",
                    "on-tertiary-fixed": "#001d33",
                    "surface-container-low": "#eef4fd",
                    "on-background": "#151c22",
                    "secondary": "#5d5f5f",
                    "on-error-container": "#93000a",
                    "surface-container": "#e8eef7",
                    "on-tertiary": "#ffffff",
                    "on-surface-variant": "#424751",
                    "surface-container-highest": "#dce3ec",
                    "on-secondary": "#ffffff",
                    "surface-dim": "#d4dbe3"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "margin-desktop": "32px",
                    "margin-mobile": "16px",
                    "base": "8px",
                    "gutter": "16px",
                    "xl": "32px",
                    "sm": "12px",
                    "md": "16px",
                    "lg": "24px",
                    "xs": "4px"
            },
            "fontFamily": {
                    "headline-lg": ["Inter"],
                    "label-md": ["JetBrains Mono"],
                    "display-lg": ["Inter"],
                    "body-sm": ["Inter"],
                    "headline-sm": ["Inter"],
                    "headline-md": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "body-md": ["Inter"],
                    "body-lg": ["Inter"]
            },
            "fontSize": {
                    "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .vessel-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
        }
        .map-gradient-overlay {
            background: linear-gradient(to bottom, rgba(21, 28, 34, 0.4) 0%, transparent 15%, transparent 85%, rgba(21, 28, 34, 0.4) 100%);
            pointer-events: none;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-surface font-body-md text-on-surface antialiased overflow-hidden h-screen flex flex-col">
<!-- TopAppBar Shell -->
<header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-margin-mobile md:px-margin-desktop h-16 bg-surface dark:bg-inverse-surface shadow-sm">

    <!-- LEFT LOGO -->
    <div class="flex items-center gap-base">
        <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim">
            anchor
        </span>

        <h1 class="text-headline-sm font-headline-sm font-bold text-primary dark:text-inverse-primary tracking-tight">
            ISNIS PORTAL
        </h1>
    </div>

    <!-- CENTER NAV -->
    <nav class="hidden md:flex items-center gap-lg">

        <!-- Dashboard -->
        <a href="customerdash.php"
           class="px-3 py-1 rounded-lg font-label-md transition-all
           <?php echo ($current_page == 'customerdash.php') ? 
           'bg-primary text-white' : 
           'text-on-surface-variant hover:bg-surface-variant'; ?>">
            <span class="material-symbols-outlined text-sm">dashboard</span>
            Dashboard
        </a>

        <!-- Shipments -->
        <a href="shipments.php"
           class="px-3 py-1 rounded-lg font-label-md transition-all
           <?php echo ($current_page == 'shipments.php') ? 
           'bg-primary text-white' : 
           'text-on-surface-variant hover:bg-surface-variant'; ?>">
            <span class="material-symbols-outlined text-sm">local_shipping</span>
            Shipments
        </a>

        <!-- Tracking -->
        <a href="vessel tracking.php"
           class="px-3 py-1 rounded-lg font-label-md transition-all
           <?php echo ($current_page == 'tracking.php') ? 
           'bg-primary text-white' : 
           'text-on-surface-variant hover:bg-surface-variant'; ?>">
            <span class="material-symbols-outlined text-sm">sailing</span>
            Tracking
        </a>

        <!-- Profile -->
        <a href="customer_profile.php"
           class="px-3 py-1 rounded-lg font-label-md transition-all
           <?php echo ($current_page == 'customer_profile.php') ? 
           'bg-primary text-white' : 
           'text-on-surface-variant hover:bg-surface-variant'; ?>">
            <span class="material-symbols-outlined text-sm">account_circle</span>
            Profile
        </a>

    </nav>

    <!-- RIGHT SIDE -->
    <div class="flex items-center gap-lg">

        <span class="material-symbols-outlined text-on-surface-variant cursor-pointer">
            notifications
        </span>

        <span class="material-symbols-outlined text-on-surface-variant cursor-pointer">
            account_circle
        </span>

    </div>

</header>

<!-- Main Content Canvas (Map) -->
<main class="flex-grow relative mt-16 pb-20 md:pb-0">
<!-- Interactive Map Container -->
<div class="absolute inset-0 w-full h-full bg-[#e8eef7]">
<!-- Map Image Placeholder with detailed data-alt -->
<img class="w-full h-full object-cover grayscale-[20%] contrast-[110%]" data-alt="A high-fidelity satellite view of the vast, deep blue Indian Ocean under clear daylight. A digital navigational route line in glowing primary blue stretches from the top right towards the bottom left, connecting Shanghai to Dar es Salaam. Minimalist digital map textures with subtle latitude and longitude grid lines in light gray provide a professional maritime logistics aesthetic. The scene is bright and clinical, reflecting a high-tech tracking interface." data-location="Indian Ocean" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtHol3sHw_qQKsZmSa_qKFum6xy2IWvfgt3c7zn_QhR9abGHV55ksiNhmgIvbFqRpvvSNP4iH9wOXsXGiauocrY-sGLeq3XCHjdMCkxsW2btWM9JgmP60-ld_6iVBmlvzaCHas6QydqpuzwZl5XpMfyiCCVD2rEWGljz-laiRu-ktagJ7LASS6OjyGwtVn5NtXniW77gu4Ottft_shWAw5W754tWRBDLT3Fp-fyxGshErnbJCTsqXH3dOnvxxEuBNEedzgo09ax1kN"/>
<div class="absolute inset-0 map-gradient-overlay"></div>
<!-- Route Line SVG Layer -->
<svg class="absolute inset-0 w-full h-full pointer-events-none opacity-60" preserveaspectratio="none">
<path d="M1200,100 Q800,400 400,700" fill="transparent" stroke="#004A99" stroke-dasharray="12,8" stroke-width="4"></path>
</svg>
<!-- Vessel Marker (MV Oceanic) -->
<div class="absolute top-[48%] left-[45%] -translate-x-1/2 -translate-y-1/2 z-10 group">
<div class="vessel-pulse absolute -inset-4 bg-primary/20 rounded-full blur-sm"></div>
<div class="relative bg-white p-1 rounded-full shadow-lg border-2 border-primary cursor-pointer transition-transform hover:scale-110">
<span class="material-symbols-outlined text-primary block" style="font-variation-settings: 'FILL' 1;">directions_boat</span>
</div>
<!-- Label Tooltip -->
<div class="absolute top-full mt-2 left-1/2 -translate-x-1/2 bg-surface p-2 rounded-lg shadow-md border border-outline-variant min-w-[120px] backdrop-blur-md bg-surface/90">
<p class="text-label-md font-label-md text-primary font-bold uppercase">MV Oceanic</p>
<p class="text-[10px] text-on-surface-variant leading-tight">En Route: Dar es Salaam</p>
</div>
</div>
<!-- Map Controls (Floating) -->
<div class="absolute right-margin-desktop top-margin-desktop flex flex-col gap-sm">
<div class="bg-white/90 backdrop-blur-md shadow-lg rounded-xl flex flex-col border border-outline-variant overflow-hidden">
<button class="p-3 hover:bg-surface-variant transition-colors text-primary border-b border-outline-variant"><span class="material-symbols-outlined">add</span></button>
<button class="p-3 hover:bg-surface-variant transition-colors text-primary border-b border-outline-variant"><span class="material-symbols-outlined">remove</span></button>
<button class="p-3 hover:bg-surface-variant transition-colors text-primary"><span class="material-symbols-outlined">my_location</span></button>
</div>
<div class="bg-white/90 backdrop-blur-md shadow-lg rounded-xl flex flex-col border border-outline-variant overflow-hidden">
<button class="p-3 hover:bg-surface-variant transition-colors text-primary"><span class="material-symbols-outlined">layers</span></button>
</div>
</div>
<!-- Vessel Telemetry Panel (Bento-style Overlay) -->
<div class="absolute bottom-margin-desktop left-margin-desktop w-full max-w-sm md:max-w-md pointer-events-none">
<div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-2xl border border-white/50 p-6 pointer-events-auto flex flex-col gap-lg">
<div class="flex justify-between items-start">
<div>
<div class="flex items-center gap-xs mb-1">
<span class="w-2 h-2 rounded-full bg-[#00A36C] vessel-pulse"></span>
<span class="text-label-md font-label-md text-[#00A36C] uppercase tracking-wider">Live Status</span>
</div>
<h2 class="text-headline-md font-headline-md text-primary">MV Oceanic</h2>
<p class="text-body-sm text-on-surface-variant">IMO: 9334850 | MMSI: 235061000</p>
</div>
<button class="text-primary font-headline-sm"><span class="material-symbols-outlined">fullscreen</span></button>
</div>
<!-- Telemetry Grid -->
<div class="grid grid-cols-2 gap-gutter">
<div class="bg-surface-container-low p-3 rounded-xl border border-outline-variant/30">
<p class="text-label-md font-label-md text-on-surface-variant/70 uppercase">Speed</p>
<p class="text-headline-sm font-headline-sm text-primary">18.4 <span class="text-body-sm font-normal">knots</span></p>
</div>
<div class="bg-surface-container-low p-3 rounded-xl border border-outline-variant/30">
<p class="text-label-md font-label-md text-on-surface-variant/70 uppercase">Heading</p>
<p class="text-headline-sm font-headline-sm text-primary">242° <span class="text-body-sm font-normal">SW</span></p>
</div>
<div class="col-span-2 bg-primary-container/10 p-3 rounded-xl border border-primary-container/20">
<p class="text-label-md font-label-md text-primary/70 uppercase">GPS Coordinates</p>
<p class="text-body-md font-label-md text-primary font-bold">06° 48' 22" S / 39° 16' 10" E</p>
</div>
</div>
<!-- Voyage Progress -->
<div class="flex flex-col gap-base">
<div class="flex justify-between text-body-sm">
<span class="font-bold text-on-surface">Shanghai</span>
<span class="text-on-surface-variant">Dar es Salaam</span>
</div>
<div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full" style="width: 65%;"></div>
</div>
<div class="flex justify-between text-label-md font-label-md text-on-surface-variant">
<span>Started: Oct 12</span>
<span>ETA: Oct 28</span>
</div>
</div>
<!-- CTA -->
<button class="w-full bg-primary hover:bg-primary-container text-white py-3 px-6 rounded-xl font-headline-sm transition-all flex items-center justify-center gap-base active:scale-[0.98]">
<span class="material-symbols-outlined">inventory_2</span>
                        View Full Manifest
                    </button>
</div>
</div>
</div>
</main>
<!-- BottomNavBar Shell (Mobile Only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 py-3 bg-surface dark:bg-inverse-surface shadow-[0_-4px_12px_rgba(0,0,0,0.04)] rounded-t-xl">
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant px-4 py-1 hover:text-primary transition-all">
<span class="material-symbols-outlined">dashboard</span>
<span class="text-label-md font-label-md">Dashboard</span>
</button>
<button class="flex flex-col items-center justify-center bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary rounded-full px-4 py-1 scale-95 transition-transform duration-200">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">location_on</span>
<span class="text-label-md font-label-md">Tracking</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant px-4 py-1 hover:text-primary transition-all">
<span class="material-symbols-outlined">inventory_2</span>
<span class="text-label-md font-label-md">Manifest</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant px-4 py-1 hover:text-primary transition-all">
<span class="material-symbols-outlined">notifications</span>
<span class="text-label-md font-label-md">Alerts</span>
</button>
</nav>
<script>
        // Simple micro-interaction for the manifest button
        document.querySelector('button.bg-primary').addEventListener('click', () => {
            console.log('Opening full manifest view...');
            // In a real app, this would route or open a modal
        });

        // Hover effect for coordinates to copy
        const coordBox = document.querySelector('.col-span-2');
        coordBox.addEventListener('mouseenter', () => {
            coordBox.classList.add('cursor-pointer');
            coordBox.style.backgroundColor = 'rgba(0, 74, 153, 0.2)';
        });
        coordBox.addEventListener('mouseleave', () => {
            coordBox.style.backgroundColor = 'rgba(0, 74, 153, 0.1)';
        });
    </script>
</body></html>