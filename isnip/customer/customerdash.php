<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS Customer Portal Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #dce3ec;
            border-radius: 10px;
        }
        .vessel-pulse {
            position: relative;
        }
        .vessel-pulse::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background: #004A99;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(3); opacity: 0; }
        }
    </style>
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
                        "headline-sm": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "headline-md": ["Inter"],
                        "body-md": ["Inter"],
                        "display-lg": ["Inter"]
                    },
                    "fontSize": {
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
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md overflow-x-hidden">
<!-- Top Navigation Bar -->
<nav class="fixed top-0 left-0 w-full z-40 flex justify-between items-center px-lg h-16 bg-surface dark:bg-surface-dim shadow-sm dark:shadow-none border-b border-outline-variant dark:border-outline">
<div class="flex items-center gap-md">
<span class="material-symbols-outlined text-primary dark:text-primary-fixed cursor-pointer">menu</span>
<h1 class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">ISNIS Navigation</h1>
</div>
<div class="flex items-center gap-lg">
<div class="hidden md:flex items-center gap-md">
<span class="font-label-md text-label-md text-primary dark:text-primary-fixed font-bold cursor-pointer">Dashboard</span>
<span class="font-label-md text-label-md text-on-surface-variant dark:text-outline hover:bg-surface-container-high dark:hover:bg-surface-container transition-colors py-1 px-2 rounded cursor-pointer">Shipments</span>
<span class="font-label-md text-label-md text-on-surface-variant dark:text-outline hover:bg-surface-container-high dark:hover:bg-surface-container transition-colors py-1 px-2 rounded cursor-pointer">Analytics</span>
</div>
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant p-2 hover:bg-surface-container rounded-full cursor-pointer">notifications</span>
<img alt="User profile photo" class="w-8 h-8 rounded-full border border-outline-variant cursor-pointer" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPXHc7OlkkyZmQg7L5-q91KaY4upJkC8UAZljAV3EgeXgHkg0rHwODpQRkA3b9seCGXwYkJG1AduTVfO5Vr1iLlRDn7yFnQ0SlxTIWgiImmnRSxv8HLVEOCAh7O1PMXcQSrWpP6wBCH-yrTn59YtdAW_Tz2yZERNclt7j_NaIVNJx6vPSc4mVNUJTyMFJZVKjzT2SwnklmsGxDZo-TZpQuhbfxa70phaeei_HxcTcBCsFYpC4_Bpt7QJGftOOBxI3uk4aIkOa77PRt"/>
</div>
</div>
</nav>
<!-- Sidebar Navigation -->
<aside class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-gradient-to-b from-primary to-tertiary dark:from-primary-container dark:to-tertiary-container shadow-xl dark:shadow-none w-[260px] hidden md:flex">
<div class="px-lg mb-xl">
<h2 class="font-headline-md text-headline-md text-on-primary">ISNIS</h2>
<div class="mt-sm flex items-center gap-sm">
<img alt="Vessel Operator" class="w-10 h-10 rounded-full border-2 border-on-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCw1zcyLHGBiCJEG8bwzPWHbZTASQM0axnTyAKIZ6EzqSXBArxRoBxtbEgHhx4RtF864erT8G0SZTt73Ctg4rNoidDshlhfvPsjzAPFmuA0PW8Zy6jF6xfTDE_4t48fCDX9L_zxP4Ham02zE9PKfw8HxFSVbOiR8w2VRT1auWaBj7768SzIHs4aQtiNhpjVwAiBAww5y1FxpM3A9CrtHBuqW8cD2ih1qc5yDJ0tHCNt38vEqu7OT9Skf528L3268jJhQXLDGHfd_Qjo"/>
<div class="overflow-hidden">
<p class="font-headline-sm text-[14px] text-on-primary truncate">ISNIS Operator</p>
<p class="font-body-sm text-[11px] text-on-primary/70">Fleet Command</p>
</div>
</div>
</div>
<nav class="flex-1 space-y-1">
<div class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md cursor-pointer">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-md text-body-md">Dashboard</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary hover:bg-on-primary/5 py-sm px-md transition-all duration-200 cursor-pointer">
<span class="material-symbols-outlined">local_shipping</span>
<span class="font-body-md text-body-md">Shipments</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary hover:bg-on-primary/5 py-sm px-md transition-all duration-200 cursor-pointer">
<span class="material-symbols-outlined">sailing</span>
<span class="font-body-md text-body-md">Vessel Tracking</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary hover:bg-on-primary/5 py-sm px-md transition-all duration-200 cursor-pointer">
<span class="material-symbols-outlined">map</span>
<span class="font-body-md text-body-md">Maps</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary hover:bg-on-primary/5 py-sm px-md transition-all duration-200 cursor-pointer">
<span class="material-symbols-outlined">forum</span>
<span class="font-body-md text-body-md">Messages</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary hover:bg-on-primary/5 py-sm px-md transition-all duration-200 cursor-pointer">
<span class="material-symbols-outlined">assessment</span>
<span class="font-body-md text-body-md">Reports</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary hover:bg-on-primary/5 py-sm px-md transition-all duration-200 cursor-pointer">
<span class="material-symbols-outlined">settings</span>
<span class="font-body-md text-body-md">Settings</span>
</div>
</nav>
<div class="mt-auto px-md pt-md border-t border-on-primary/10">
<p class="text-[10px] text-on-primary/50 tracking-widest font-label-md">V1.2.4</p>
</div>
</aside>
<!-- Main Content Wrapper -->
<main class="pt-24 pb-12 px-margin-mobile md:ml-[260px] md:px-margin-desktop min-h-screen">
<!-- Welcome Header -->
<header class="mb-lg">
<h2 class="font-headline-lg text-headline-lg text-primary">Customer Portal Dashboard</h2>
<p class="text-on-surface-variant font-body-md">Managing your global logistics with high-tech precision.</p>
</header>
<!-- KPI Cards Grid -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-md mb-xl">
<div class="bg-surface-container-lowest p-lg rounded-xl shadow-sm border border-outline-variant flex items-center justify-between group hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase">Total Shipments</p>
<h3 class="font-headline-lg text-headline-lg text-primary">1,284</h3>
</div>
<div class="w-12 h-12 bg-primary-fixed rounded-lg flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-[32px]">inventory_2</span>
</div>
</div>
<div class="bg-surface-container-lowest p-lg rounded-xl shadow-sm border border-outline-variant flex items-center justify-between group hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase">In Transit Cargo</p>
<h3 class="font-headline-lg text-headline-lg text-primary">452</h3>
</div>
<div class="w-12 h-12 bg-tertiary-fixed rounded-lg flex items-center justify-center text-tertiary">
<span class="material-symbols-outlined text-[32px]">local_shipping</span>
</div>
</div>
<div class="bg-surface-container-lowest p-lg rounded-xl shadow-sm border border-outline-variant flex items-center justify-between group hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase">Delivered Cargo</p>
<h3 class="font-headline-lg text-headline-lg text-primary">832</h3>
</div>
<div class="w-12 h-12 bg-secondary-fixed-dim rounded-lg flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-[32px]">check_circle</span>
</div>
</div>
</section>
<!-- Bento Layout: Map, Tracking & Progress -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-lg mb-xl">
<!-- Tracking Search & Status (Bento Column 1) -->
<div class="lg:col-span-4 flex flex-col gap-lg">
<!-- Search Card -->
<div class="bg-primary-container text-on-primary p-lg rounded-xl shadow-lg">
<h4 class="font-headline-sm text-headline-sm mb-md flex items-center gap-sm">
<span class="material-symbols-outlined">search</span> Track Shipment
                    </h4>
<div class="space-y-sm">
<label class="font-label-md text-[11px] uppercase tracking-wider opacity-80">Enter Tracking Number</label>
<div class="relative">
<input class="w-full bg-surface-container-lowest/10 border border-white/20 rounded-lg py-3 px-md text-on-primary placeholder:text-on-primary/50 focus:ring-2 focus:ring-white/50 focus:outline-none font-label-md" placeholder="e.g. SN-8849-Z" type="text"/>
<button class="absolute right-2 top-1.5 bg-on-primary text-primary px-3 py-1.5 rounded-md font-label-md text-[12px] font-bold hover:bg-primary-fixed transition-colors">GO</button>
</div>
</div>
</div>
<!-- Active Shipment Detail (Focused) -->
<div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm flex-1">
<div class="flex justify-between items-start mb-lg">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">Active Cargo</p>
<h4 class="font-headline-sm text-headline-sm text-primary">SN-8849-Z</h4>
</div>
<span class="bg-tertiary-fixed text-tertiary-container px-3 py-1 rounded-full font-label-md text-[10px] font-bold">IN TRANSIT</span>
</div>
<div class="space-y-md">
<div class="flex justify-between items-center pb-sm border-b border-outline-variant/30">
<span class="text-on-surface-variant text-body-sm">ETA</span>
<span class="font-bold text-primary">Oct 14, 2024</span>
</div>
<div class="flex justify-between items-center pb-sm border-b border-outline-variant/30">
<span class="text-on-surface-variant text-body-sm">Status</span>
<span class="font-bold text-primary">Approaching Port</span>
</div>
<div class="flex justify-between items-center">
<span class="text-on-surface-variant text-body-sm">Last Ping</span>
<span class="font-bold text-primary">2 mins ago</span>
</div>
</div>
<!-- Shipment Progress Timeline -->
<div class="mt-xl relative">
<div class="absolute left-[15px] top-2 bottom-2 w-0.5 bg-outline-variant"></div>
<div class="space-y-lg relative">
<div class="flex gap-md">
<div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center z-10">
<span class="material-symbols-outlined text-[16px] text-on-primary">anchor</span>
</div>
<div>
<p class="font-headline-sm text-[14px] text-primary">Departed Port</p>
<p class="text-[12px] text-on-surface-variant">Singapore, Oct 01</p>
</div>
</div>
<div class="flex gap-md">
<div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center z-10">
<span class="material-symbols-outlined text-[16px] text-on-primary">sailing</span>
</div>
<div>
<p class="font-headline-sm text-[14px] text-primary">High Seas Transit</p>
<p class="text-[12px] text-on-surface-variant">Indian Ocean, Oct 08</p>
</div>
</div>
<div class="flex gap-md">
<div class="w-8 h-8 rounded-full bg-surface-container-highest border-2 border-primary flex items-center justify-center z-10">
<span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
</div>
<div>
<p class="font-headline-sm text-[14px] text-primary font-bold">Current Location</p>
<p class="text-[12px] text-on-surface-variant">Near Port Sudan</p>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Mini GPS Vessel Tracking Map (Bento Column 2) -->
<div class="lg:col-span-8 bg-surface-container p-sm rounded-xl border border-outline-variant min-h-[500px] relative overflow-hidden group">
<div class="absolute inset-sm rounded-lg overflow-hidden z-0">
<img class="w-full h-full object-cover brightness-50 contrast-125" data-alt="A highly detailed satellite navigation map of a major international shipping port with digital overlays. The visual style is inspired by futuristic logistics dashboards, featuring high-contrast blue maritime paths and glowing digital icons representing active cargo ships. The lighting is low-key with a cool, corporate tech atmosphere. Data nodes and geometric vessel icons are scattered across the dark blue ocean surface, suggesting advanced fleet tracking technology." data-location="Port Sudan" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDD8gwQwlM0YeW8BY0atkNEbXOu8pIi1pcnaHrryTpF_IA55LMPeT3-AVjp05JL2fCEwHMCkN3R3eGB6PtpBy63AsV8H6fwI6GSZ0q_yWri-VszoZIpnlRdMKsetCBtFJ0zKRVldbFx0oOu9qbMvJxGcIz40DRurpLOaQeVVHReyhTCJt06zi2uS68DX93urnGcgNQmPaqaOPecdPVInJwCF5oaw1hz7oQ5Y3W4lf7fPmWo0xce0Fnz3_r7QulI9MHEKF-8qfAeSF5k"/>
</div>
<!-- Map Overlays -->
<div class="absolute top-md left-md z-10 glass-panel p-md rounded-lg border border-white/30 shadow-lg">
<h5 class="font-headline-sm text-[16px] text-primary flex items-center gap-sm">
<span class="material-symbols-outlined">satellite_alt</span> Live Tracking
                    </h5>
<p class="text-[12px] text-on-surface-variant">Vessel: Blue Horizon VII</p>
</div>
<div class="absolute top-md right-md z-10 flex flex-col gap-sm">
<button class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-md flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-colors">
<span class="material-symbols-outlined">add</span>
</button>
<button class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-md flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-colors">
<span class="material-symbols-outlined">remove</span>
</button>
<button class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-md flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-colors">
<span class="material-symbols-outlined">my_location</span>
</button>
</div>
<!-- GPS Marker -->
<div class="absolute top-1/2 left-1/3 transform -translate-x-1/2 -translate-y-1/2 z-10">
<div class="vessel-pulse"></div>
<div class="mt-4 glass-panel px-3 py-1 rounded text-[10px] font-bold text-primary border border-white/40">
                        Blue Horizon VII
                    </div>
</div>
<!-- Map Stats Bar -->
<div class="absolute bottom-md left-md right-md z-10 flex justify-between gap-md overflow-x-auto no-scrollbar">
<div class="flex-1 glass-panel p-sm rounded-lg border border-white/30 min-w-[120px]">
<p class="text-[10px] uppercase opacity-70">Speed</p>
<p class="font-bold text-primary">18.4 knots</p>
</div>
<div class="flex-1 glass-panel p-sm rounded-lg border border-white/30 min-w-[120px]">
<p class="text-[10px] uppercase opacity-70">Course</p>
<p class="font-bold text-primary">312° NW</p>
</div>
<div class="flex-1 glass-panel p-sm rounded-lg border border-white/30 min-w-[120px]">
<p class="text-[10px] uppercase opacity-70">Draft</p>
<p class="font-bold text-primary">14.2 m</p>
</div>
<div class="flex-1 glass-panel p-sm rounded-lg border border-white/30 min-w-[120px]">
<p class="text-[10px] uppercase opacity-70">Humidity</p>
<p class="font-bold text-primary">62% (Cargo)</p>
</div>
</div>
</div>
</section>
<!-- Cargo Tracking Table & Notifications -->
<section class="grid grid-cols-1 xl:grid-cols-4 gap-lg">
<!-- Table Section -->
<div class="xl:col-span-3 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden flex flex-col">
<div class="p-lg border-b border-outline-variant flex justify-between items-center">
<h4 class="font-headline-sm text-headline-sm text-primary">Cargo Tracking Manifest</h4>
<button class="text-primary font-label-md hover:underline flex items-center gap-xs">
                        View Detailed Log <span class="material-symbols-outlined text-[18px]">open_in_new</span>
</button>
</div>
<div class="overflow-x-auto">
<table class="w-full border-collapse">
<thead class="bg-surface-container text-on-surface-variant font-label-md text-left">
<tr>
<th class="px-lg py-sm">Tracking Number</th>
<th class="px-lg py-sm">Cargo Type</th>
<th class="px-lg py-sm">Vessel Name</th>
<th class="px-lg py-sm">Current Status</th>
<th class="px-lg py-sm">ETA</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/30 font-body-sm text-on-surface">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-label-md font-bold text-primary">SN-8849-Z</td>
<td class="px-lg py-md">Electronics (Bulk)</td>
<td class="px-lg py-md italic">Blue Horizon VII</td>
<td class="px-lg py-md">
<span class="flex items-center gap-sm">
<span class="w-2 h-2 rounded-full bg-tertiary"></span> In Transit
                                    </span>
</td>
<td class="px-lg py-md">Oct 14, 2024</td>
</tr>
<tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-label-md font-bold text-primary">SN-9012-K</td>
<td class="px-lg py-md">Textiles</td>
<td class="px-lg py-md italic">Pacific Mariner</td>
<td class="px-lg py-md">
<span class="flex items-center gap-sm">
<span class="w-2 h-2 rounded-full bg-secondary"></span> Processing
                                    </span>
</td>
<td class="px-lg py-md">Oct 21, 2024</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-label-md font-bold text-primary">SN-7721-B</td>
<td class="px-lg py-md">Automotive Parts</td>
<td class="px-lg py-md italic">Atlantic Star</td>
<td class="px-lg py-md">
<span class="flex items-center gap-sm">
<span class="w-2 h-2 rounded-full bg-error"></span> Delayed
                                    </span>
</td>
<td class="px-lg py-md">Oct 18, 2024</td>
</tr>
<tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-label-md font-bold text-primary">SN-4432-M</td>
<td class="px-lg py-md">Perishables</td>
<td class="px-lg py-md italic">Northern Express</td>
<td class="px-lg py-md">
<span class="flex items-center gap-sm">
<span class="w-2 h-2 rounded-full bg-tertiary"></span> In Transit
                                    </span>
</td>
<td class="px-lg py-md">Oct 15, 2024</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Notifications Panel -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-lg flex flex-col max-h-[400px]">
<div class="flex justify-between items-center mb-md">
<h4 class="font-headline-sm text-[18px] text-primary">Recent Alerts</h4>
<span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full">3 NEW</span>
</div>
<div class="flex-1 overflow-y-auto space-y-md pr-1">
<div class="p-sm bg-error-container/20 rounded-lg border-l-4 border-error">
<p class="font-bold text-error text-[13px]">Vessel Delay Alert</p>
<p class="text-[11px] text-on-surface-variant">SN-7721-B delayed by 48h due to weather conditions in Atlantic North.</p>
<p class="text-[10px] mt-1 text-on-surface-variant opacity-60">15 mins ago</p>
</div>
<div class="p-sm bg-tertiary-fixed/20 rounded-lg border-l-4 border-tertiary">
<p class="font-bold text-tertiary text-[13px]">Document Verified</p>
<p class="text-[11px] text-on-surface-variant">Customs clearance completed for SN-9012-K at Singapore terminal.</p>
<p class="text-[10px] mt-1 text-on-surface-variant opacity-60">2 hours ago</p>
</div>
<div class="p-sm bg-surface-container-high rounded-lg border-l-4 border-outline">
<p class="font-bold text-on-surface text-[13px]">ETA Update</p>
<p class="text-[11px] text-on-surface-variant">SN-4432-M improved ETA by 4 hours. Optimal wind conditions.</p>
<p class="text-[10px] mt-1 text-on-surface-variant opacity-60">5 hours ago</p>
</div>
<div class="p-sm bg-surface-container-high rounded-lg border-l-4 border-outline">
<p class="font-bold text-on-surface text-[13px]">System Maintenance</p>
<p class="text-[11px] text-on-surface-variant">Portal will undergo brief scheduled maintenance at 02:00 UTC.</p>
<p class="text-[10px] mt-1 text-on-surface-variant opacity-60">Yesterday</p>
</div>
</div>
<button class="w-full mt-md py-2 border border-outline-variant rounded-lg font-label-md text-primary hover:bg-primary-container hover:text-on-primary transition-all">Clear All Notifications</button>
</div>
</section>
</main>
<!-- Floating Action Button (Supressed on details/transactions, shown here for dashboard context) -->
<button class="fixed bottom-lg right-lg w-14 h-14 bg-primary text-on-primary rounded-full shadow-xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 group">
<span class="material-symbols-outlined text-[28px]">add</span>
<span class="absolute right-16 bg-primary text-on-primary px-3 py-1 rounded-lg text-[12px] whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">New Shipment</span>
</button>
<script>
        // Simple interactive demo logic
        document.querySelectorAll('tr').forEach(row => {
            row.addEventListener('click', () => {
                const trackingNum = row.cells[0]?.innerText;
                if (trackingNum) {
                    const searchInput = document.querySelector('input[type="text"]');
                    searchInput.value = trackingNum;
                    searchInput.classList.add('ring-2', 'ring-primary-fixed');
                    setTimeout(() => searchInput.classList.remove('ring-2', 'ring-primary-fixed'), 800);
                }
            });
        });

        // Atmospheric parallax/hover effect for the map container
        const mapContainer = document.querySelector('.group');
        const mapImage = mapContainer.querySelector('img');
        mapContainer.addEventListener('mousemove', (e) => {
            const rect = mapContainer.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width;
            const y = (e.clientY - rect.top) / rect.height;
            mapImage.style.transform = `scale(1.05) translate(${(x - 0.5) * 10}px, ${(y - 0.5) * 10}px)`;
        });
        mapContainer.addEventListener('mouseleave', () => {
            mapImage.style.transform = `scale(1) translate(0, 0)`;
        });
    </script>
</body></html>