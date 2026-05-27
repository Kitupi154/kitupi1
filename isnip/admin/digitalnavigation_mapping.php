<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS - Fleet Command &amp; Route Monitoring</title>
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
        }
        .map-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .route-path {
            stroke-dasharray: 8;
            animation: dash 20s linear infinite;
        }
        @keyframes dash {
            to { stroke-dashoffset: -100; }
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c2c6d3; border-radius: 10px; }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md selection:bg-primary/20">
<!-- Navigation Drawer -->
<aside class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-gradient-to-b from-primary to-tertiary shadow-xl w-[260px] hidden md:flex">
<div class="px-lg mb-xl">
<h1 class="font-headline-md text-headline-md text-on-primary font-bold tracking-tight">ISNIS</h1>
<p class="text-on-primary/60 font-label-md text-label-md mt-1 uppercase tracking-widest">Fleet Command</p>
</div>
<nav class="flex-1 space-y-1">
<!-- Active: Vessel Tracking -->
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-md text-body-md">Dashboard</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">local_shipping</span>
<span class="font-body-md text-body-md">Shipments</span>
</div>
<div class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">sailing</span>
<span class="font-body-md text-body-md">Vessel Tracking</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">map</span>
<span class="font-body-md text-body-md">Maps</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">forum</span>
<span class="font-body-md text-body-md">Messages</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">notifications</span>
<span class="font-body-md text-body-md">Notifications</span>
</div>
<div class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md cursor-pointer transition-all duration-200">
<span class="material-symbols-outlined">assessment</span>
<span class="font-body-md text-body-md">Reports</span>
</div>
</nav>
<div class="mt-auto px-lg pt-xl border-t border-white/10">
<div class="flex items-center gap-md">
<img alt="Operator" class="w-10 h-10 rounded-full border-2 border-white/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_69zHvcDXb1-jBFtBZdMjvuotRa6IgmTrFGb_0k5aeEl_S_Gesh5gQKZ2F0xxebhosnCiZ3_-54Qe0B22HO98cN1roVy-blHxLwcGNhwla6Qpf-WuK6YxhKPq4cIisov4cJXtEt_mltxefmjqB1lwzq4iAX0qv2aW27Op7xq3h2MuLkBZ4SNcC5MOB8sJbhj0_MaJtn-RHFTpftdTEtGx5YAeXs7Woiuyemr6RjR-4InnfiCRLu1DpyKaIFrvMJDCsOoTdCoEGt2e"/>
<div class="flex flex-col">
<span class="text-on-primary font-bold text-body-sm">Cpt. Elias Vance</span>
<span class="text-on-primary/60 text-[10px] uppercase font-bold tracking-tighter">V1.2.4 Active</span>
</div>
</div>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="md:ml-[260px] min-h-screen relative flex flex-col">
<!-- Top App Bar -->
<header class="h-16 px-lg bg-surface border-b border-outline-variant flex justify-between items-center sticky top-0 z-40">
<div class="flex items-center gap-md">
<span class="material-symbols-outlined md:hidden text-primary">menu</span>
<h2 class="font-headline-sm text-headline-sm text-primary font-bold">Route Monitoring</h2>
</div>
<div class="flex items-center gap-lg">
<div class="hidden lg:flex items-center gap-sm bg-surface-container-low px-md py-xs rounded-full border border-outline-variant">
<span class="material-symbols-outlined text-outline text-sm">search</span>
<input class="bg-transparent border-none focus:ring-0 text-body-sm w-48 py-1" placeholder="Search Vessel or Port..." type="text"/>
</div>
<div class="flex items-center gap-sm">
<div class="relative cursor-pointer hover:bg-surface-container-high p-2 rounded-full transition-colors">
<span class="material-symbols-outlined text-on-surface-variant">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border border-surface"></span>
</div>
<div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container cursor-pointer transition-colors hover:bg-primary-container/80">
<span class="material-symbols-outlined">person</span>
</div>
</div>
</div>
</header>
<!-- Dashboard Content -->
<div class="flex-1 p-md lg:p-lg grid grid-cols-12 gap-gutter">
<!-- Map Container (Large) -->
<section class="col-span-12 lg:col-span-8 xl:col-span-9 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant relative overflow-hidden min-h-[500px]">
<!-- Interactive Map Placeholder -->
<div class="absolute inset-0 z-0 bg-[#E3F2FD]">
<img class="w-full h-full object-cover opacity-80" data-alt="A highly detailed, professional maritime navigation map shown on a large digital display. The map features stylized global continents in deep navy blue with glowing cyan sea shipping routes connecting major ports like Singapore, Rotterdam, and New York. Tiny animated vessel icons traverse the dashed route lines, and subtle data overlays display real-time coordinates and speed in a high-tech, minimal UI style consistent with a modern logistics command center." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQ2ja_D6miJWbnKdnfmJNk7ycrU74BxOwN0UGn4IxTZ4-9B1-x-5btTeyF6hGHfajQRf_3yS0N3wDgEfxZHqPpTOBV0TRTQhaYpaeitFXB-PNxwXkhhgGJukEjuCiOU_vG3j8f1_lD13OZc8Vg--b35I-hlOmUxSIjhoHqKvntzgDKDpkETPqHVqCzMDePDztXFFXXZ9OWcZGnLMRmsQhQNNouJBFCYcR7UPXJ11SszpFD1xRiBKxlMgf8QbMX_Ve9vaaiJWoq4bxD"/>
<!-- SVG Overlay for Routes -->
<svg class="absolute inset-0 w-full h-full pointer-events-none" viewbox="0 0 1000 600">
<path class="route-path" d="M200,300 Q400,200 600,350 T850,250" fill="none" stroke="#004A99" stroke-width="2"></path>
<path class="route-path opacity-40" d="M150,150 Q300,100 500,200 T700,400" fill="none" stroke="#004A99" stroke-width="2"></path>
<!-- Port Markers -->
<g class="cursor-pointer pointer-events-auto">
<circle cx="200" cy="300" fill="#00346f" r="6" stroke="white" stroke-width="2"></circle>
<text fill="#00346f" font-family="Inter" font-size="10" font-weight="600" x="210" y="305">PORT OF DAR ES SALAAM</text>
</g>
<g class="cursor-pointer pointer-events-auto">
<circle cx="850" cy="250" fill="#ba1a1a" r="6" stroke="white" stroke-width="2"></circle>
<text fill="#ba1a1a" font-family="Inter" font-size="10" font-weight="600" text-anchor="end" x="810" y="240">DEST: PORT OF SHANGHAI</text>
</g>
</svg>
</div>
<!-- Map Floating Controls -->
<div class="absolute top-md right-md flex flex-col gap-xs">
<button class="map-glass w-10 h-10 flex items-center justify-center rounded-lg shadow-sm hover:bg-white transition-colors">
<span class="material-symbols-outlined text-primary">add</span>
</button>
<button class="map-glass w-10 h-10 flex items-center justify-center rounded-lg shadow-sm hover:bg-white transition-colors">
<span class="material-symbols-outlined text-primary">remove</span>
</button>
<div class="h-xs"></div>
<button class="map-glass w-10 h-10 flex items-center justify-center rounded-lg shadow-sm hover:bg-white transition-colors">
<span class="material-symbols-outlined text-primary">layers</span>
</button>
</div>
<!-- Route Status Overlay (Bottom Left) -->
<div class="absolute bottom-md left-md map-glass p-md rounded-xl shadow-lg border border-white/50 max-w-sm">
<div class="flex items-center gap-sm mb-sm">
<div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
<span class="font-label-md text-label-md text-primary font-bold">VESSEL EN ROUTE: MAERSK INTEGRITY</span>
</div>
<div class="grid grid-cols-2 gap-md">
<div>
<p class="text-[10px] text-outline uppercase font-bold">Speed</p>
<p class="font-headline-sm text-headline-sm text-primary">18.4 kn</p>
</div>
<div>
<p class="text-[10px] text-outline uppercase font-bold">ETA</p>
<p class="font-headline-sm text-headline-sm text-primary">14 APR, 09:00</p>
</div>
</div>
<div class="mt-md bg-primary-container/10 h-1 rounded-full overflow-hidden">
<div class="bg-primary-container h-full w-[65%]"></div>
</div>
</div>
</section>
<!-- Sidebar Info Panel (Right) -->
<aside class="col-span-12 lg:col-span-4 xl:col-span-3 space-y-gutter flex flex-col">
<!-- Weather Widget -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm flex items-center justify-between">
<div>
<p class="text-label-md font-label-md text-outline">CURRENT WEATHER - ZONE 4</p>
<h4 class="font-headline-sm text-headline-sm text-primary">Heavy Swells</h4>
<div class="flex items-center gap-base mt-xs">
<span class="material-symbols-outlined text-tertiary text-base">air</span>
<span class="text-body-sm">WNW 24kts</span>
</div>
</div>
<div class="text-right">
<span class="material-symbols-outlined text-4xl text-primary-container" style="font-variation-settings: 'FILL' 1;">thunderstorm</span>
<p class="font-bold text-primary">7.4m Wave</p>
</div>
</div>
<!-- Navigation Alerts Section -->
<div class="flex-1 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm flex flex-col overflow-hidden">
<div class="p-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
<h3 class="font-headline-sm text-headline-sm text-primary">Navigation Alerts</h3>
<span class="bg-error text-on-error text-[10px] px-2 py-0.5 rounded-full font-bold">3 CRITICAL</span>
</div>
<div class="flex-1 overflow-y-auto custom-scrollbar p-md space-y-sm">
<!-- Alert Item -->
<div class="p-sm bg-error-container/20 rounded-lg border-l-4 border-error">
<div class="flex justify-between items-start mb-xs">
<span class="font-bold text-error text-body-sm">Traffic Congestion</span>
<span class="text-[10px] text-outline">14:22</span>
</div>
<p class="text-body-sm text-on-surface-variant leading-tight">Port of Dar Es Salaam reporting 12hr delay for Berths 4-6 due to infrastructure repairs.</p>
</div>
<!-- Alert Item -->
<div class="p-sm bg-surface-container-high rounded-lg border-l-4 border-primary">
<div class="flex justify-between items-start mb-xs">
<span class="font-bold text-primary text-body-sm">Route Optimization</span>
<span class="text-[10px] text-outline">12:05</span>
</div>
<p class="text-body-sm text-on-surface-variant leading-tight">New favorable current identified on Indian Ocean Route B. Suggest adjusting bearing 12° North.</p>
</div>
<!-- Alert Item -->
<div class="p-sm bg-surface-container-high rounded-lg border-l-4 border-outline">
<div class="flex justify-between items-start mb-xs">
<span class="font-bold text-on-surface text-body-sm">Scheduled Maintenance</span>
<span class="text-[10px] text-outline">09:15</span>
</div>
<p class="text-body-sm text-on-surface-variant leading-tight">M.V. Galaxy Horizon due for dry-dock inspection in 48 hours at Singapore Shipyard.</p>
</div>
<!-- Alert Item -->
<div class="p-sm bg-surface-container-high rounded-lg border-l-4 border-outline">
<div class="flex justify-between items-start mb-xs">
<span class="font-bold text-on-surface text-body-sm">Document Update</span>
<span class="text-[10px] text-outline">Yesterday</span>
</div>
<p class="text-body-sm text-on-surface-variant leading-tight">Manifest updated for Vessel CSCL-900. Cargo volume increased by 450 TEU.</p>
</div>
</div>
<div class="p-md border-t border-outline-variant">
<button class="w-full py-sm bg-primary text-on-primary rounded-lg font-bold hover:bg-primary/90 transition-all active:scale-95 text-body-md">ACKNOWLEDGE ALL</button>
</div>
</div>
</aside>
<!-- Bottom Analytics Bar -->
<section class="col-span-12 grid grid-cols-1 md:grid-cols-4 gap-gutter">
<!-- Data Point 1 -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm">
<div class="flex items-center gap-sm mb-xs">
<span class="material-symbols-outlined text-primary">database</span>
<span class="text-label-md font-label-md text-outline uppercase tracking-wider">Total Volume</span>
</div>
<div class="flex items-end gap-sm">
<span class="font-display-lg text-display-lg text-primary">50,000</span>
<span class="font-bold text-primary pb-base">TEU</span>
<span class="text-green-600 text-body-sm pb-base font-bold flex items-center"><span class="material-symbols-outlined text-sm">trending_up</span> 12%</span>
</div>
</div>
<!-- Data Point 2 -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm">
<div class="flex items-center gap-sm mb-xs">
<span class="material-symbols-outlined text-primary">timer</span>
<span class="text-label-md font-label-md text-outline uppercase tracking-wider">Avg. Transit Time</span>
</div>
<div class="flex items-end gap-sm">
<span class="font-display-lg text-display-lg text-primary">21.4</span>
<span class="font-bold text-primary pb-base">DAYS</span>
<span class="text-red-500 text-body-sm pb-base font-bold flex items-center"><span class="material-symbols-outlined text-sm">trending_down</span> 2d</span>
</div>
</div>
<!-- Data Point 3 -->
<div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant shadow-sm">
<div class="flex items-center gap-sm mb-xs">
<span class="material-symbols-outlined text-primary">gas_meter</span>
<span class="text-label-md font-label-md text-outline uppercase tracking-wider">Fuel Efficiency</span>
</div>
<div class="flex items-end gap-sm">
<span class="font-display-lg text-display-lg text-primary">94</span>
<span class="font-bold text-primary pb-base">%</span>
<span class="text-green-600 text-body-sm pb-base font-bold flex items-center"><span class="material-symbols-outlined text-sm">verified</span> OPTIMAL</span>
</div>
</div>
<!-- Data Point 4 -->
<div class="bg-primary text-on-primary p-md rounded-xl shadow-lg relative overflow-hidden group">
<div class="relative z-10">
<span class="text-label-md font-label-md text-on-primary/70 uppercase tracking-wider">Active Fleet</span>
<div class="flex items-center gap-md mt-xs">
<span class="font-display-lg text-display-lg">142</span>
<div class="flex flex-col">
<span class="text-[10px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded">Vessels</span>
<span class="text-[10px] uppercase font-bold text-green-300">Live Tracking</span>
</div>
</div>
</div>
<span class="material-symbols-outlined absolute -bottom-4 -right-4 text-9xl text-white/5 rotate-12 group-hover:rotate-0 transition-transform duration-500">sailing</span>
</div>
</section>
</div>
<!-- Footer / Credits -->
<footer class="mt-auto px-lg py-md border-t border-outline-variant bg-surface flex justify-between items-center text-[10px] text-outline uppercase font-bold tracking-widest">
<div class="flex gap-lg">
<span>© 2024 ISNIS Maritime Systems</span>
<span>System Health: Nominal</span>
<span>Uptime: 99.98%</span>
</div>
<div class="flex items-center gap-base">
<div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
<span>Server: EU-WEST-1</span>
</div>
</footer>
</main>
<!-- Floating Action Button for Emergency -->
<button class="fixed bottom-xl right-xl w-16 h-16 bg-error text-on-error rounded-full shadow-2xl flex items-center justify-center group z-50 hover:scale-105 active:scale-95 transition-all">
<span class="material-symbols-outlined text-3xl group-hover:rotate-45 transition-transform" style="font-variation-settings: 'FILL' 1;">emergency_home</span>
<div class="absolute -top-12 right-0 bg-inverse-surface text-inverse-on-surface text-[10px] py-1 px-3 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">SOS ALERT SYSTEM</div>
</button>
<script>
        // Simple Interaction: Tooltip toggle for port markers
        document.querySelectorAll('g.cursor-pointer').forEach(port => {
            port.addEventListener('mouseenter', () => {
                port.querySelector('circle').style.r = '10';
                port.querySelector('circle').style.transition = 'all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            });
            port.addEventListener('mouseleave', () => {
                port.querySelector('circle').style.r = '6';
            });
        });

        // Simulating live data update for speed
        const speedDisplay = document.querySelector('.font-headline-sm.text-headline-sm.text-primary');
        if (speedDisplay) {
            setInterval(() => {
                const base = 18.4;
                const variance = (Math.random() - 0.5) * 0.4;
                speedDisplay.textContent = (base + variance).toFixed(1) + ' kn';
            }, 3000);
        }
    </script>
</body></html>