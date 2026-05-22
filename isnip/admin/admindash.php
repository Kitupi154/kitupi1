<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS | Enterprise Maritime Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-secondary": "#ffffff",
                    "tertiary-container": "#004f7f",
                    "surface-container-highest": "#dce3ec",
                    "primary-fixed": "#d7e2ff",
                    "on-background": "#151c22",
                    "on-primary-fixed-variant": "#00458f",
                    "on-error-container": "#93000a",
                    "tertiary-fixed-dim": "#98cbff",
                    "surface-dim": "#d4dbe3",
                    "secondary": "#5d5f5f",
                    "tertiary-fixed": "#cfe5ff",
                    "background": "#f6f9ff",
                    "primary": "#00346f",
                    "outline-variant": "#c2c6d3",
                    "on-surface-variant": "#424751",
                    "on-tertiary": "#ffffff",
                    "surface-tint": "#255dad",
                    "on-secondary-fixed": "#1a1c1c",
                    "error-container": "#ffdad6",
                    "on-primary-container": "#9bbdff",
                    "surface-variant": "#dce3ec",
                    "primary-fixed-dim": "#abc7ff",
                    "secondary-fixed-dim": "#c6c6c7",
                    "surface": "#f6f9ff",
                    "secondary-container": "#dfe0e0",
                    "on-secondary-container": "#616363",
                    "on-primary-fixed": "#001b3f",
                    "secondary-fixed": "#e2e2e2",
                    "surface-container-high": "#e2e9f1",
                    "on-secondary-fixed-variant": "#454747",
                    "surface-bright": "#f6f9ff",
                    "outline": "#737783",
                    "on-surface": "#151c22",
                    "surface-container-low": "#eef4fd",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary-fixed": "#001d33",
                    "tertiary": "#00385c",
                    "inverse-on-surface": "#ebf1fa",
                    "primary-container": "#004a99",
                    "on-tertiary-container": "#82c2ff",
                    "inverse-surface": "#2a3138",
                    "on-error": "#ffffff",
                    "inverse-primary": "#abc7ff",
                    "on-tertiary-fixed-variant": "#004a77",
                    "on-primary": "#ffffff",
                    "error": "#ba1a1a",
                    "surface-container": "#e8eef7"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "margin-mobile": "16px",
                    "lg": "24px",
                    "gutter": "16px",
                    "xs": "4px",
                    "sm": "12px",
                    "base": "8px",
                    "margin-desktop": "32px",
                    "md": "16px",
                    "xl": "32px"
            },
            "fontFamily": {
                    "headline-lg-mobile": ["Inter"],
                    "body-lg": ["Inter"],
                    "headline-sm": ["Inter"],
                    "headline-lg": ["Inter"],
                    "body-sm": ["Inter"],
                    "label-md": ["JetBrains Mono"],
                    "headline-md": ["Inter"],
                    "body-md": ["Inter"],
                    "display-lg": ["Inter"]
            },
            "fontSize": {
                    "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(233, 236, 239, 0.5);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c2c6d3;
            border-radius: 10px;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed overflow-hidden h-screen flex">
<!-- Navigation Drawer (Mandatory Shell) -->
<aside class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-primary dark:bg-primary-container docked left-0 h-full w-[260px] shadow-xl dark:shadow-none bg-gradient-to-b from-primary to-tertiary dark:from-primary-container dark:to-tertiary-container hidden md:flex">
<!-- Brand Header -->
<div class="px-lg mb-xl flex flex-col items-start">
<span class="font-headline-md text-headline-md text-on-primary font-bold tracking-tight">ISNIS NAV</span>
<span class="text-on-primary/60 font-label-md text-label-md mt-xs">FLEET COMMAND CENTER</span>
</div>
<!-- Profile Section -->
<div class="px-lg mb-lg flex items-center gap-md">
<div class="w-12 h-12 rounded-full border-2 border-on-primary/20 overflow-hidden">
<img alt="Operator" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCF1YMG2kgXpmq6Hl2E9HWpXbVbYsITNDu_NUNQ1aWHdYy6OUXcdcjEyRVLI4jWoGu73Bbrn70ff7-qJMN4XrHtVn6Z7EArSHBbI2Sj0pAO4Wmmr3zBx9PadhFRSPh9-v9EMePVni4cpKnw-hVwTMF1-X3EpWsH_SZ-sEN9RC_xCzP9J1k2A70vYZD0M4IZmww_y-StqKfUR2tZOGe1MfGt0HtL6Wfs0_ENeNZLsrKgmHo6DgWzc5LQFxdO9aZpU-XMD5y_dprxNTj4"/>
</div>
<div>
<p class="font-headline-sm text-headline-sm text-on-primary leading-tight">ISNIS Operator</p>
<p class="text-on-primary/70 font-label-md text-label-md">Fleet Command</p>
</div>
</div>

<!-- Navigation Links -->
<nav class="flex-1 space-y-1 overflow-y-auto custom-scrollbar">
<!-- Dashboard Active -->
<div class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md cursor-pointer active:scale-95 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="font-body-md text-body-md">Dashboard</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="groups">groups</span>
<span class="font-body-md text-body-md">Customers</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="local_shipping">local_shipping</span>
<span class="font-body-md text-body-md">Shipments</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
<span class="font-body-md text-body-md">Cargo Management</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="sailing">sailing</span>
<span class="font-body-md text-body-md">Vessel Tracking</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="map">map</span>
<span class="font-body-md text-body-md">Routes &amp; Ports</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="location_on">location_on</span>
<span class="font-body-md text-body-md">GPS Monitoring</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="forum">forum</span>
<span class="font-body-md text-body-md">Messages</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="font-body-md text-body-md">Notifications</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer hover:bg-on-primary/5 transition-all duration-200">
<span class="material-symbols-outlined" data-icon="assessment">assessment</span>
<span class="font-body-md text-body-md">Reports</span>
</div>
</nav>
<!-- Sidebar Footer -->
<div class="mt-auto px-lg pt-lg border-t border-on-primary/10">
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="font-body-md text-body-md">Settings</span>
</div>
<div class="flex items-center gap-sm text-error-container hover:text-on-error-container py-sm cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
<span class="font-body-md text-body-md">Logout</span>
</div>
<p class="text-on-primary/40 font-label-md text-[10px] mt-md">SYSTEM V1.2.4</p>
</div>
</aside>
<!-- Main Content Area -->
<main class="flex-1 flex flex-col md:ml-[260px] overflow-hidden">
<!-- TopAppBar (Mandatory Shell) -->
<header class="fixed top-0 right-0 left-0 md:left-[260px] z-40 bg-surface dark:bg-surface-dim shadow-sm dark:shadow-none border-b border-outline-variant dark:border-outline h-16 flex justify-between items-center px-lg">
<div class="flex items-center gap-md">
<button class="md:hidden text-primary">
<span class="material-symbols-outlined" data-icon="menu">menu</span>
</button>
<h1 class="font-headline-sm text-headline-sm text-primary font-bold">Fleet Overview</h1>
</div>
<div class="flex items-center gap-lg">
<div class="hidden sm:flex items-center bg-surface-container-low px-md py-xs rounded-full border border-outline-variant">
<span class="material-symbols-outlined text-outline text-sm mr-xs" data-icon="search">search</span>
<input class="bg-transparent border-none outline-none text-body-sm font-body-sm text-on-surface placeholder:text-outline w-48" placeholder="Search manifest ID..." type="text"/>
</div>
<div class="flex items-center gap-md">
<div class="relative cursor-pointer">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="notifications">notifications</span>
<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-surface"></span>
</div>
<div class="h-8 w-px bg-outline-variant"></div>
<img alt="User" class="w-8 h-8 rounded-full border border-primary" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBPzBKNerNXXmLILUVLhH2NOmebpn47MU78gNJuk4ymOWhKWcYaWtlZgwfoBPBiNri9Co0-E37CDIS-TIXpwS7Ack2MvwVcAwEdp_ghlggrsTwX5aQh70Nfq56vwpG4WKYE_D0uiPiQU-EarNS05rv9C5vZVZ2s4wQa28S6vmwXDBDscpqyJ27PdVullapsi4IuSmdgKfZ3k4AEGN54XyDr9ENjtfmcxcUtcl_ArNcSDQ8itTIx0HmaD71pNKyqJFA30C1IPtwRrIZ0"/>
</div>
</div>
</header>
<!-- Content Canvas -->
<div class="mt-16 p-lg overflow-y-auto custom-scrollbar space-y-lg bg-background">
<!-- Statistics Bento Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-md">
<!-- Card: Total Shipments -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow group">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-primary bg-primary-fixed p-xs rounded-lg" data-icon="inventory">inventory</span>
<span class="text-on-surface-variant font-label-md text-label-md">+12%</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Total Shipments</p>
<p class="font-headline-md text-headline-md text-primary font-bold">1,248</p>
</div>
</div>
<!-- Card: Active Vessels -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-tertiary bg-tertiary-fixed p-xs rounded-lg" data-icon="sailing">sailing</span>
<span class="text-on-surface-variant font-label-md text-label-md">Operational</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Active Vessels</p>
<p class="font-headline-md text-headline-md text-tertiary font-bold">14</p>
</div>
</div>
<!-- Card: Cargo In Transit -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-primary bg-primary-fixed p-xs rounded-lg" data-icon="local_shipping">local_shipping</span>
<span class="text-on-surface-variant font-label-md text-label-md">Current</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Cargo In Transit</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold">842</p>
</div>
</div>
<!-- Card: Delivered Cargo -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-on-secondary-container bg-secondary-container p-xs rounded-lg" data-icon="task_alt">task_alt</span>
<span class="text-on-surface-variant font-label-md text-label-md">Completed</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Delivered Cargo</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold">364</p>
</div>
</div>
<!-- Card: Pending Deliveries -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-error bg-error-container p-xs rounded-lg" data-icon="schedule">schedule</span>
<span class="text-error font-label-md text-label-md">Attention</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Pending</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold">42</p>
</div>
</div>
<!-- Card: Registered Customers -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-sm">
<span class="material-symbols-outlined text-primary-container bg-primary-fixed p-xs rounded-lg" data-icon="face">face</span>
<span class="text-on-surface-variant font-label-md text-label-md">Total</span>
</div>
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Customers</p>
<p class="font-headline-md text-headline-md text-on-surface font-bold">156</p>
</div>
</div>
</div>
<!-- Analytics & Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
<!-- Shipment Analytics (Bar Chart Visual) -->
<div class="lg:col-span-8 bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">
<div class="flex justify-between items-center mb-xl">
<h2 class="font-headline-sm text-headline-sm text-on-surface">Shipment Analytics</h2>
<div class="flex gap-sm">
<button class="px-md py-1 rounded-full text-label-md font-label-md bg-primary text-on-primary">Monthly</button>
<button class="px-md py-1 rounded-full text-label-md font-label-md bg-surface-container hover:bg-surface-container-high transition-colors">Weekly</button>
</div>
</div>
<!-- Mock Chart Container -->
<div class="h-[300px] flex items-end justify-around gap-md relative">
<!-- Chart Grid Lines -->
<div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
<div class="border-t border-outline-variant/30 w-full"></div>
<div class="border-t border-outline-variant/30 w-full"></div>
<div class="border-t border-outline-variant/30 w-full"></div>
<div class="border-t border-outline-variant/30 w-full"></div>
<div class="border-t border-outline-variant/30 w-full"></div>
</div>
<!-- Bar Groups -->
<div class="flex flex-col items-center gap-xs group w-full max-w-[80px]">
<div class="w-full bg-primary/20 rounded-t-lg h-[60%] group-hover:bg-primary transition-all duration-300 relative">
<span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-[10px] px-2 py-1 rounded hidden group-hover:block">1.1k</span>
</div>
<span class="text-label-md font-label-md text-on-surface-variant text-center">Received</span>
</div>
<div class="flex flex-col items-center gap-xs group w-full max-w-[80px]">
<div class="w-full bg-primary/40 rounded-t-lg h-[85%] group-hover:bg-primary transition-all duration-300 relative">
<span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-[10px] px-2 py-1 rounded hidden group-hover:block">1.4k</span>
</div>
<span class="text-label-md font-label-md text-on-surface-variant text-center">Loaded</span>
</div>
<div class="flex flex-col items-center gap-xs group w-full max-w-[80px]">
<div class="w-full bg-primary/60 rounded-t-lg h-[45%] group-hover:bg-primary transition-all duration-300 relative">
<span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-[10px] px-2 py-1 rounded hidden group-hover:block">0.8k</span>
</div>
<span class="text-label-md font-label-md text-on-surface-variant text-center">In Transit</span>
</div>
<div class="flex flex-col items-center gap-xs group w-full max-w-[80px]">
<div class="w-full bg-primary rounded-t-lg h-[95%] relative">
<span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-[10px] px-2 py-1 rounded hidden group-hover:block">1.6k</span>
</div>
<span class="text-label-md font-label-md text-on-surface-variant text-center">Delivered</span>
</div>
</div>
</div>
<!-- Cargo Delivery Pie Chart & Vessel Activity -->
<div class="lg:col-span-4 space-y-lg">
<!-- Pie Chart Mock -->
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm h-[200px] flex flex-col justify-between">
<h3 class="font-label-md text-label-md text-on-surface-variant uppercase font-bold">Cargo Breakdown</h3>
<div class="flex items-center gap-lg">
<div class="w-24 h-24 rounded-full border-[12px] border-primary border-r-tertiary border-b-primary-fixed border-l-secondary"></div>
<div class="flex-1 space-y-xs">
<div class="flex items-center gap-xs text-body-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-primary"></span> Dry Bulk (45%)</div>
<div class="flex items-center gap-xs text-body-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-tertiary"></span> Liquid (20%)</div>
<div class="flex items-center gap-xs text-body-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-primary-fixed"></span> Container (25%)</div>
<div class="flex items-center gap-xs text-body-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-secondary"></span> Other (10%)</div>
</div>
</div>
</div>
<!-- Vessel Activity Panel -->
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm h-[190px]">
<h3 class="font-label-md text-label-md text-on-surface-variant uppercase font-bold mb-md">Vessel Efficiency</h3>
<div class="space-y-sm">
<div class="space-y-1">
<div class="flex justify-between text-body-sm font-body-sm"><span>Ocean Voyager</span><span>92%</span></div>
<div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
<div class="bg-primary h-full w-[92%]"></div>
</div>
</div>
<div class="space-y-1">
<div class="flex justify-between text-body-sm font-body-sm"><span>Global Swift</span><span>78%</span></div>
<div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
<div class="bg-tertiary h-full w-[78%]"></div>
</div>
</div>
<div class="space-y-1">
<div class="flex justify-between text-body-sm font-body-sm"><span>Arctic Carrier</span><span>45%</span></div>
<div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
<div class="bg-error h-full w-[45%]"></div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Recent Shipments Table & Notifications -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-lg pb-10">
<!-- Table Section -->
<div class="xl:col-span-9 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
<div class="p-lg border-b border-outline-variant flex justify-between items-center">
<h2 class="font-headline-sm text-headline-sm text-on-surface">Live Manifest Tracking</h2>
<button class="text-primary font-label-md text-label-md hover:underline">View All Shipments</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-background">
<tr class="text-on-surface-variant font-label-md text-label-md uppercase tracking-tight">
<th class="py-md px-lg font-bold">Tracking #</th>
<th class="py-md px-lg font-bold">Customer</th>
<th class="py-md px-lg font-bold">Vessel</th>
<th class="py-md px-lg font-bold">Cargo Type</th>
<th class="py-md px-lg font-bold">Destination Port</th>
<th class="py-md px-lg font-bold">ETA</th>
<th class="py-md px-lg font-bold">Status</th>
</tr>
</thead>
<tbody class="text-body-sm font-body-sm divide-y divide-outline-variant/30">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-md px-lg font-label-md">#TK-88210</td>
<td class="py-md px-lg">Nordic Industries</td>
<td class="py-md px-lg">Blue Horizon</td>
<td class="py-md px-lg">Iron Ore</td>
<td class="py-md px-lg">Rotterdam, NL</td>
<td class="py-md px-lg text-on-surface-variant">24 Oct 2023</td>
<td class="py-md px-lg">
<span class="px-sm py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold uppercase">In Transit</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-md px-lg font-label-md">#TK-88211</td>
<td class="py-md px-lg">Global Retail Co.</td>
<td class="py-md px-lg">Pacific Star</td>
<td class="py-md px-lg">Consumer Goods</td>
<td class="py-md px-lg">Singapore, SG</td>
<td class="py-md px-lg text-on-surface-variant">22 Oct 2023</td>
<td class="py-md px-lg">
<span class="px-sm py-1 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase">Loaded</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-md px-lg font-label-md">#TK-88212</td>
<td class="py-md px-lg">Agri-Corp Int.</td>
<td class="py-md px-lg">Atlas Carrier</td>
<td class="py-md px-lg">Wheat Grain</td>
<td class="py-md px-lg">Port Said, EG</td>
<td class="py-md px-lg text-on-surface-variant">21 Oct 2023</td>
<td class="py-md px-lg">
<span class="px-sm py-1 rounded-full bg-error-container text-on-error-container text-[10px] font-bold uppercase">Delayed</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-md px-lg font-label-md">#TK-88213</td>
<td class="py-md px-lg">PetroChem Ltd</td>
<td class="py-md px-lg">Deep Sea One</td>
<td class="py-md px-lg">Crude Oil</td>
<td class="py-md px-lg">Houston, US</td>
<td class="py-md px-lg text-on-surface-variant">28 Oct 2023</td>
<td class="py-md px-lg">
<span class="px-sm py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-bold uppercase">Dispatched</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Notifications Panel -->
<div class="xl:col-span-3 space-y-md">
<div class="bg-surface-container-highest/30 p-lg rounded-xl border border-outline-variant shadow-sm h-full flex flex-col">
<div class="flex items-center justify-between mb-lg">
<h2 class="font-headline-sm text-headline-sm text-on-surface">Critical Logs</h2>
<span class="material-symbols-outlined text-primary cursor-pointer" data-icon="tune">tune</span>
</div>
<div class="space-y-lg flex-1">
<div class="flex gap-md group">
<div class="mt-1 w-2 h-2 rounded-full bg-primary shrink-0 group-hover:scale-125 transition-transform"></div>
<div>
<p class="text-body-sm font-body-sm font-bold text-on-surface">Vessel Departed</p>
<p class="text-body-sm font-body-sm text-on-surface-variant">"Ocean Voyager" cleared Singapore port boundary.</p>
<span class="text-label-md text-label-md text-outline mt-xs block">2 mins ago</span>
</div>
</div>
<div class="flex gap-md group">
<div class="mt-1 w-2 h-2 rounded-full bg-error shrink-0 group-hover:scale-125 transition-transform"></div>
<div>
<p class="text-body-sm font-body-sm font-bold text-on-surface">Shipment Delayed</p>
<p class="text-body-sm font-body-sm text-on-surface-variant">Manifest #TK-88212 held for customs inspection at Port Said.</p>
<span class="text-label-md text-label-md text-outline mt-xs block">45 mins ago</span>
</div>
</div>
<div class="flex gap-md group">
<div class="mt-1 w-2 h-2 rounded-full bg-tertiary-container shrink-0 group-hover:scale-125 transition-transform"></div>
<div>
<p class="text-body-sm font-body-sm font-bold text-on-surface">Cargo Arrived</p>
<p class="text-body-sm font-body-sm text-on-surface-variant">Dry bulk unit #884 reached Rotterdam terminal A4.</p>
<span class="text-label-md text-label-md text-outline mt-xs block">3 hours ago</span>
</div>
</div>
</div>
<button class="w-full mt-lg py-sm bg-surface-container-high hover:bg-surface-container-highest transition-colors rounded-lg font-label-md text-label-md text-on-surface-variant">CLEAR ALL LOGS</button>
</div>
</div>
</div>
</div>
<!-- Floating Action Button (Mandatory logic) -->
<button class="fixed bottom-margin-desktop right-margin-desktop bg-primary-container text-on-primary-container w-14 h-14 rounded-full shadow-xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50">
<span class="material-symbols-outlined text-3xl" data-icon="add">add</span>
</button>
</main>
<!-- Map Tooltip Micro-interaction Script -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animation for stats counters (simulated)
            const stats = document.querySelectorAll('.font-headline-md');
            stats.forEach(stat => {
                stat.style.opacity = '0';
                stat.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    stat.style.transition = 'all 0.6s ease-out';
                    stat.style.opacity = '1';
                    stat.style.transform = 'translateY(0)';
                }, 100);
            });

            // Table hover row highlight
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                   row.querySelector('td:first-child').style.color = 'var(--primary)';
                   row.querySelector('td:first-child').style.fontWeight = '700';
                });
                row.addEventListener('mouseleave', () => {
                   row.querySelector('td:first-child').style.color = '';
                   row.querySelector('td:first-child').style.fontWeight = '';
                });
            });
        });
    </script>
</body></html>