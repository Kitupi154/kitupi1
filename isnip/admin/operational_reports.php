<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS | Advanced Fleet Reporting</title>
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
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(233, 236, 239, 1);
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md overflow-x-hidden">
<!-- Navigation Drawer (Mandatory Component) -->
<aside class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-gradient-to-b from-primary to-tertiary w-[260px] shadow-xl">
<div class="px-lg mb-xl">
<h1 class="font-headline-md text-headline-md text-on-primary font-bold">ISNIS</h1>
<p class="text-on-primary/60 font-label-md text-label-md">Fleet Command</p>
</div>
<nav class="flex-1 space-y-xs">
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200 hover:bg-on-primary/5">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-md">Dashboard</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200 hover:bg-on-primary/5">
<span class="material-symbols-outlined">local_shipping</span>
<span class="font-body-md">Shipments</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200 hover:bg-on-primary/5">
<span class="material-symbols-outlined">sailing</span>
<span class="font-body-md">Vessel Tracking</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200 hover:bg-on-primary/5">
<span class="material-symbols-outlined">map</span>
<span class="font-body-md">Maps</span>
</div>
<!-- Active Navigation: Reports -->
<div class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md cursor-pointer">
<span class="material-symbols-outlined">assessment</span>
<span class="font-body-md">Reports</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200 hover:bg-on-primary/5">
<span class="material-symbols-outlined">forum</span>
<span class="font-body-md">Messages</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200 hover:bg-on-primary/5">
<span class="material-symbols-outlined">notifications</span>
<span class="font-body-md">Notifications</span>
</div>
</nav>
<div class="mt-auto px-lg pt-xl border-t border-on-primary/10">
<div class="flex items-center gap-md">
<img alt="User" class="w-10 h-10 rounded-full bg-on-primary/20 border border-on-primary/20" data-alt="A professional close-up portrait of a maritime logistics operator wearing a smart navy blue corporate uniform. The lighting is bright and technical, reflecting a high-tech control room environment with soft blue glowing screens in the background. The aesthetic is clean, modern, and reliable, conveying expertise and precision." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBn5VpIosNHMpfQ-Zwu-Pw9at5wrrisE8z2uIKW8QJGX-G3rme9njwbCcyRq7gqWBwc1u9IR8u6Fc0isoTP3NXyKPkfcVPFZdx0WFssgpkV0CtrFoVapQmWbW09xPMi8PEGOrUHzQWLKO0Ou9yhxlatcE_9gUN9LML2I1W-UodfanqZMWLKTArAehMTlCNzOHZqb_TP_AX0AEgnXL9DD347a9104xJp78smKRTSBUxp4VDU9VpX_LooSEQTdIFEkKAEjc372287mvHJ"/>
<div>
<p class="font-body-md text-on-primary font-semibold">ISNIS Operator</p>
<p class="text-xs text-on-primary/50">V1.2.4</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="ml-[260px] min-h-screen pb-xl">
<!-- TopAppBar -->
<header class="fixed top-0 left-[260px] right-0 z-40 h-16 bg-surface flex justify-between items-center px-lg border-b border-outline-variant shadow-sm">
<div class="flex items-center gap-md">
<span class="material-symbols-outlined text-primary cursor-pointer">menu</span>
<h2 class="font-headline-sm text-headline-sm font-bold text-primary">Advanced Reporting</h2>
</div>
<div class="flex items-center gap-md">
<div class="flex bg-surface-container-high rounded-lg p-1">
<button class="px-md py-xs text-primary font-label-md text-label-md bg-surface-container-lowest rounded shadow-sm">Live View</button>
<button class="px-md py-xs text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors">History</button>
</div>
<div class="w-px h-6 bg-outline-variant mx-sm"></div>
<button class="flex items-center gap-xs px-md py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:bg-primary-container transition-all active:scale-95">
<span class="material-symbols-outlined text-[18px]">cloud_download</span>
                    Export PDF
                </button>
</div>
</header>
<!-- Content Area -->
<div class="pt-24 px-lg max-w-[1600px] mx-auto">
<!-- Statistics Widgets Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-xl">
<!-- Stat Card 1 -->
<div class="glass-card p-lg rounded-xl flex items-start justify-between">
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-base">Active Shipments</p>
<h3 class="font-headline-lg text-headline-lg text-primary">1,284</h3>
<div class="mt-sm flex items-center gap-xs text-green-600 font-label-md text-label-md">
<span class="material-symbols-outlined text-[16px]">trending_up</span>
<span>+12.5% vs last month</span>
</div>
</div>
<div class="p-sm bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">local_shipping</span>
</div>
</div>
<!-- Stat Card 2 -->
<div class="glass-card p-lg rounded-xl flex items-start justify-between">
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-base">Vessels En Route</p>
<h3 class="font-headline-lg text-headline-lg text-primary">82</h3>
<div class="mt-sm flex items-center gap-xs text-primary font-label-md text-label-md">
<span class="material-symbols-outlined text-[16px]">schedule</span>
<span>98% On Schedule</span>
</div>
</div>
<div class="p-sm bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">sailing</span>
</div>
</div>
<!-- Stat Card 3 -->
<div class="glass-card p-lg rounded-xl flex items-start justify-between">
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-base">Total Cargo Vol.</p>
<h3 class="font-headline-lg text-headline-lg text-primary">45.2k<span class="text-headline-sm">T</span></h3>
<div class="mt-sm flex items-center gap-xs text-error font-label-md text-label-md">
<span class="material-symbols-outlined text-[16px]">trending_down</span>
<span>-2.4% vs capacity</span>
</div>
</div>
<div class="p-sm bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">inventory_2</span>
</div>
</div>
<!-- Stat Card 4 -->
<div class="glass-card p-lg rounded-xl flex items-start justify-between">
<div>
<p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-base">Customer Satisfaction</p>
<h3 class="font-headline-lg text-headline-lg text-primary">4.92</h3>
<div class="mt-sm flex items-center gap-xs text-green-600 font-label-md text-label-md">
<span class="material-symbols-outlined text-[16px]">stars</span>
<span>Top tier performance</span>
</div>
</div>
<div class="p-sm bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">group</span>
</div>
</div>
</div>
<!-- Bento Dashboard Grid -->
<div class="bento-grid">
<!-- Main Analytics Chart (8 Columns) -->
<div class="col-span-12 lg:col-span-8 glass-card p-lg rounded-xl flex flex-col">
<div class="flex justify-between items-center mb-xl">
<div>
<h4 class="font-headline-sm text-headline-sm text-primary">Global Shipment Performance</h4>
<p class="text-on-surface-variant text-body-sm">Daily operational volume and delivery efficiency.</p>
</div>
<div class="flex gap-sm">
<select class="bg-surface-container-low border-none rounded-lg font-label-md text-label-md text-on-surface-variant focus:ring-2 focus:ring-primary">
<option>Last 30 Days</option>
<option>Last 6 Months</option>
</select>
<button class="p-2 hover:bg-surface-container-high rounded-full transition-colors">
<span class="material-symbols-outlined">more_vert</span>
</button>
</div>
</div>
<!-- Chart Placeholder -->
<div class="flex-1 w-full min-h-[300px] relative flex items-end justify-between px-md pb-md gap-sm">
<!-- Simulated Chart Bars -->
<div class="w-full h-[60%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[80%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<div class="w-full h-[75%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[60%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<div class="w-full h-[90%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[85%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<div class="w-full h-[65%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[40%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<div class="w-full h-[80%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[70%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<div class="w-full h-[100%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[90%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<div class="w-full h-[55%] bg-primary-container/20 rounded-t-lg relative group">
<div class="absolute inset-x-0 bottom-0 bg-primary h-[50%] rounded-t-lg group-hover:bg-primary-container transition-all"></div>
</div>
<!-- Axis Labels -->
<div class="absolute -bottom-8 inset-x-0 flex justify-between font-label-md text-label-md text-on-surface-variant">
<span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SAT</span><span>SUN</span>
</div>
</div>
</div>
<!-- Vessel Distribution (4 Columns) -->
<div class="col-span-12 lg:col-span-4 glass-card p-lg rounded-xl flex flex-col">
<h4 class="font-headline-sm text-headline-sm text-primary mb-xl">Vessel Status</h4>
<div class="flex-1 flex flex-col gap-lg justify-center">
<div class="relative w-48 h-48 mx-auto">
<!-- SVG Donut Chart Mock -->
<svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
<path class="text-surface-container-highest stroke-current" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-width="3"></path>
<path class="text-primary stroke-current" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-dasharray="75, 100" stroke-width="3"></path>
<path class="text-tertiary stroke-current" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-dasharray="15, 100" stroke-dashoffset="-75" stroke-width="3"></path>
</svg>
<div class="absolute inset-0 flex flex-col items-center justify-center">
<span class="font-headline-lg text-headline-lg text-primary">82</span>
<span class="font-label-md text-label-md text-on-surface-variant uppercase">Total</span>
</div>
</div>
<div class="space-y-sm">
<div class="flex justify-between items-center">
<div class="flex items-center gap-sm">
<div class="w-3 h-3 rounded-full bg-primary"></div>
<span class="font-body-md">In Transit</span>
</div>
<span class="font-label-md font-bold">62 (75%)</span>
</div>
<div class="flex justify-between items-center">
<div class="flex items-center gap-sm">
<div class="w-3 h-3 rounded-full bg-tertiary"></div>
<span class="font-body-md">At Port</span>
</div>
<span class="font-label-md font-bold">12 (15%)</span>
</div>
<div class="flex justify-between items-center">
<div class="flex items-center gap-sm">
<div class="w-3 h-3 rounded-full bg-surface-container-highest"></div>
<span class="font-body-md">Maintenance</span>
</div>
<span class="font-label-md font-bold">8 (10%)</span>
</div>
</div>
</div>
</div>
<!-- Delivery Performance Table (12 Columns) -->
<div class="col-span-12 glass-card rounded-xl overflow-hidden">
<div class="px-lg py-md bg-surface-container-low flex justify-between items-center border-b border-outline-variant">
<h4 class="font-headline-sm text-headline-sm text-primary">Recent Shipments &amp; Cargo Logs</h4>
<div class="flex gap-md">
<button class="flex items-center gap-xs px-md py-2 border border-primary text-primary rounded-lg font-label-md text-label-md hover:bg-primary/5 transition-all">
<span class="material-symbols-outlined text-[18px]">filter_list</span>
                                Filter
                            </button>
<button class="flex items-center gap-xs px-md py-2 bg-secondary-container text-on-secondary-container rounded-lg font-label-md text-label-md hover:opacity-90 transition-all">
<span class="material-symbols-outlined text-[18px]">ios_share</span>
                                Export Excel
                            </button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider border-b border-outline-variant bg-surface-container-lowest/50">
<th class="px-lg py-md">Vessel ID</th>
<th class="px-lg py-md">Shipment Ref</th>
<th class="px-lg py-md">Customer</th>
<th class="px-lg py-md">Cargo Type</th>
<th class="px-lg py-md">Status</th>
<th class="px-lg py-md text-right">ETA / Time</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/50">
<tr class="hover:bg-primary/5 transition-colors cursor-pointer group">
<td class="px-lg py-md font-label-md">VSL-2941</td>
<td class="px-lg py-md font-semibold">SHP-A7821-B</td>
<td class="px-lg py-md">Global Logistics Co.</td>
<td class="px-lg py-md"><span class="px-sm py-1 bg-tertiary-fixed text-on-tertiary-fixed rounded-full text-xs font-bold">Hazardous</span></td>
<td class="px-lg py-md">
<div class="flex items-center gap-xs text-green-600">
<span class="w-2 h-2 rounded-full bg-green-600 animate-pulse"></span>
<span class="font-label-md">ON_TIME</span>
</div>
</td>
<td class="px-lg py-md text-right font-label-md">2h 14m</td>
</tr>
<tr class="bg-surface-container-lowest/30 hover:bg-primary/5 transition-colors cursor-pointer">
<td class="px-lg py-md font-label-md">VSL-1029</td>
<td class="px-lg py-md font-semibold">SHP-C4409-Z</td>
<td class="px-lg py-md">TechPort Systems</td>
<td class="px-lg py-md"><span class="px-sm py-1 bg-primary-fixed text-on-primary-fixed rounded-full text-xs font-bold">Standard</span></td>
<td class="px-lg py-md">
<div class="flex items-center gap-xs text-orange-600">
<span class="w-2 h-2 rounded-full bg-orange-600"></span>
<span class="font-label-md">DELAYED</span>
</div>
</td>
<td class="px-lg py-md text-right font-label-md">14h 45m</td>
</tr>
<tr class="hover:bg-primary/5 transition-colors cursor-pointer">
<td class="px-lg py-md font-label-md">VSL-8832</td>
<td class="px-lg py-md font-semibold">SHP-L0032-M</td>
<td class="px-lg py-md">Oceanic Retail Ltd.</td>
<td class="px-lg py-md"><span class="px-sm py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-bold">Perishable</span></td>
<td class="px-lg py-md">
<div class="flex items-center gap-xs text-green-600">
<span class="w-2 h-2 rounded-full bg-green-600"></span>
<span class="font-label-md">ON_TIME</span>
</div>
</td>
<td class="px-lg py-md text-right font-label-md">32h 10m</td>
</tr>
<tr class="bg-surface-container-lowest/30 hover:bg-primary/5 transition-colors cursor-pointer">
<td class="px-lg py-md font-label-md">VSL-5521</td>
<td class="px-lg py-md font-semibold">SHP-K9912-F</td>
<td class="px-lg py-md">Nordic Iron Works</td>
<td class="px-lg py-md"><span class="px-sm py-1 bg-primary-fixed text-on-primary-fixed rounded-full text-xs font-bold">Heavy</span></td>
<td class="px-lg py-md">
<div class="flex items-center gap-xs text-primary">
<span class="w-2 h-2 rounded-full bg-primary"></span>
<span class="font-label-md">IN_PORT</span>
</div>
</td>
<td class="px-lg py-md text-right font-label-md">COMPLETED</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Custom Insights (6 Columns) -->
<div class="col-span-12 lg:col-span-6 glass-card p-lg rounded-xl flex flex-col">
<div class="flex justify-between items-center mb-lg">
<h4 class="font-headline-sm text-headline-sm text-primary">Route Efficiency</h4>
<span class="material-symbols-outlined text-primary cursor-help">info</span>
</div>
<div class="flex items-center gap-xl">
<div class="w-1/2 p-lg bg-primary rounded-xl text-on-primary">
<p class="font-label-md uppercase opacity-70 mb-base">Fuel Optimization</p>
<h5 class="text-display-lg font-bold">94%</h5>
<p class="text-body-sm opacity-80 mt-sm">AI-driven routes saved 12,400L this week.</p>
</div>
<div class="w-1/2 space-y-md">
<div>
<div class="flex justify-between text-body-sm mb-xs">
<span>North Atlantic</span>
<span class="font-bold">88%</span>
</div>
<div class="w-full bg-surface-container-high h-2 rounded-full">
<div class="bg-primary h-full rounded-full" style="width: 88%"></div>
</div>
</div>
<div>
<div class="flex justify-between text-body-sm mb-xs">
<span>Pacific South</span>
<span class="font-bold">72%</span>
</div>
<div class="w-full bg-surface-container-high h-2 rounded-full">
<div class="bg-primary h-full rounded-full" style="width: 72%"></div>
</div>
</div>
<div>
<div class="flex justify-between text-body-sm mb-xs">
<span>Mediterranean</span>
<span class="font-bold">96%</span>
</div>
<div class="w-full bg-surface-container-high h-2 rounded-full">
<div class="bg-primary h-full rounded-full" style="width: 96%"></div>
</div>
</div>
</div>
</div>
</div>
<!-- Map Overview (6 Columns) -->
<div class="col-span-12 lg:col-span-6 rounded-xl overflow-hidden glass-card relative h-[320px]">
<div class="absolute top-md left-md z-10 px-md py-2 bg-surface-container-lowest/90 backdrop-blur rounded-lg shadow-sm">
<span class="font-label-md text-label-md text-primary font-bold">Global Fleet Distribution</span>
</div>
<img alt="Fleet Map" class="w-full h-full object-cover" data-alt="A highly detailed and technical global navigation map focusing on maritime routes across the Atlantic and Pacific oceans. The map uses a sophisticated dark-mode aesthetic with deep navy blues and glowing cyan lines indicating vessel trajectories. Floating UI elements like coordinate callouts and tiny vessel icons with data labels are rendered with a glassmorphism style, suggesting a high-end command center interface. The overall atmosphere is professional, tech-forward, and precise." data-location="Global" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAS1svPeKccX5SjOcgcdSh9gyMDe0J7J062WbjkdULL44VZF1TAQM-36xeZ5Moyjbg2bDt04rdiS2OqvHnGiqxqqUEXFpa1ha57EgFQwBw3eOi9ET5poigpkzPc3KEYR0nP4mzRVbnabtDqXcpHK7t0vusytGdpm8AbmddLVKRpZvu_PUyVWOrdRd9lMPb5nMXQHHcmnxFNr-uP2Ch-_8gXFzbStSmO8BGxZwEiYas-ITvb5hhIKv51EmQDMAFMY9UQq4Q58pJRjkNe"/>
<div class="absolute bottom-md right-md z-10 flex flex-col gap-sm">
<button class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-md flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-all">
<span class="material-symbols-outlined">add</span>
</button>
<button class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-md flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-all">
<span class="material-symbols-outlined">remove</span>
</button>
</div>
</div>
</div>
</div>
<!-- Floating Action Button -->
<button class="fixed bottom-lg right-lg w-14 h-14 bg-primary text-on-primary rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-90 transition-all z-50 group">
<span class="material-symbols-outlined text-[28px]">add</span>
<span class="absolute right-16 bg-primary text-on-primary px-md py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">New Report</span>
</button>
</main>
<script>
        // Micro-interaction for Stat Cards hover
        const cards = document.querySelectorAll('.glass-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.transition = 'all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                card.classList.add('shadow-lg');
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.classList.remove('shadow-lg');
            });
        });

        // Simulating some live data changes
        setInterval(() => {
            const pulse = document.querySelector('.animate-pulse');
            if(pulse) {
                // Keep the vibe alive
            }
        }, 2000);
    </script>
</body></html>