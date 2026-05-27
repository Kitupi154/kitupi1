<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS Fleet Command - Live Vessel Tracking</title>
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
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .vessel-pulse {
            position: relative;
        }
        .vessel-pulse::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #004a99;
            opacity: 0.6;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.6; }
            100% { transform: translate(-50%, -50%) scale(3); opacity: 0; }
        }
        .route-path {
            stroke-dasharray: 10;
            animation: dash 30s linear infinite;
        }
        @keyframes dash {
            to { stroke-dashoffset: -1000; }
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md overflow-hidden h-screen flex">
<!-- Navigation Drawer (Predicted Component) -->
<aside class="fixed left-0 top-0 h-full z-50 flex flex-col py-xl bg-primary dark:bg-primary-container docked left-0 h-full w-[260px] shadow-xl dark:shadow-none bg-gradient-to-b from-primary to-tertiary dark:from-primary-container dark:to-tertiary-container hidden md:flex" id="main-nav">
<div class="px-lg mb-xl">
<h1 class="font-headline-md text-headline-md text-on-primary">ISNIS</h1>
<p class="font-label-md text-label-md text-on-primary/60 uppercase tracking-widest mt-xs">Fleet Command</p>
</div>
<nav class="flex-1 space-y-xs">
<a class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md transition-all duration-200 hover:bg-on-primary/5 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-md">Dashboard</span>
</a>
<a class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md transition-all duration-200 hover:bg-on-primary/5 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined">local_shipping</span>
<span class="font-body-md">Shipments</span>
</a>
<a class="flex items-center gap-sm bg-surface-container-lowest/10 text-on-primary border-l-4 border-on-primary py-sm px-md transition-all duration-200 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">sailing</span>
<span class="font-body-md">Vessel Tracking</span>
</a>
<a class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md transition-all duration-200 hover:bg-on-primary/5 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined">map</span>
<span class="font-body-md">Maps</span>
</a>
<a class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md transition-all duration-200 hover:bg-on-primary/5 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined">forum</span>
<span class="font-body-md">Messages</span>
</a>
<a class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md transition-all duration-200 hover:bg-on-primary/5 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined">notifications</span>
<span class="font-body-md">Notifications</span>
</a>
<a class="flex items-center gap-sm text-on-primary/70 hover:text-on-primary py-sm px-md transition-all duration-200 hover:bg-on-primary/5 cursor-pointer active:scale-95" href="#">
<span class="material-symbols-outlined">assessment</span>
<span class="font-body-md">Reports</span>
</a>
</nav>
<div class="px-md mt-auto pt-lg border-t border-on-primary/10">
<div class="flex items-center gap-sm p-sm">
<img alt="Operator" class="w-10 h-10 rounded-full border border-on-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCFgvcT1_4bC09nU4W6rJuiItuKY0Vb3bLvfTtJXKf89RbGmV4ixdfaHoiTC5KDmqdzQwDOgSCYw90yRpgLuh0yYGhy_2rKe9I8mLd6XZ9uf0VBLdKJQ_6ouDOokIfTXZhFpBSoasKCU2aG8lVITXBmNTgelllfmpWICIWcLGAjsooEOHQCOJ5NN-KG28keJgzLPXFpOWeK72RiFe3MCxFDUFg9qqIUmjz_XiHF9yEAWohCMAK7amEeIzXZAmyiVN_zgV8rCk-uA-mT"/>
<div class="flex flex-col">
<span class="font-body-sm font-semibold text-on-primary">ISNIS Operator</span>
<span class="text-[10px] text-on-primary/50 uppercase tracking-tighter">V1.2.4 Active</span>
</div>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="flex-1 ml-0 md:ml-[260px] relative h-full flex flex-col">
<!-- Top App Bar (Predicted Component) -->
<header class="fixed top-0 left-0 md:left-[260px] right-0 z-40 flex justify-between items-center px-lg h-16 bg-surface border-b border-outline-variant shadow-sm glass-panel">
<div class="flex items-center gap-md">
<button class="md:hidden text-primary">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="flex flex-col">
<h2 class="font-headline-sm text-headline-sm text-primary">ISNIS Navigation</h2>
<span class="font-label-md text-[10px] text-on-surface-variant -mt-1">FLEET ID: NX-9022-G</span>
</div>
</div>
<div class="flex items-center gap-lg">
<div class="hidden lg:flex items-center bg-surface-container rounded-lg px-md py-xs gap-sm border border-outline-variant/30">
<span class="material-symbols-outlined text-primary text-[20px]">search</span>
<input class="bg-transparent border-none focus:ring-0 text-body-sm w-48 font-body-sm" placeholder="Search Vessel or Port..." type="text"/>
<kbd class="bg-surface-container-highest text-[10px] px-1.5 rounded text-outline">⌘K</kbd>
</div>
<div class="flex items-center gap-md">
<div class="relative cursor-pointer">
<span class="material-symbols-outlined text-on-surface-variant">notifications</span>
<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
</div>
<div class="flex items-center gap-sm cursor-pointer group">
<div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold text-xs">
                            OP
                        </div>
<span class="material-symbols-outlined text-on-surface-variant group-hover:rotate-180 transition-transform">expand_more</span>
</div>
</div>
</div>
</header>
<!-- Dynamic Content Canvas -->
<section class="flex-1 mt-16 relative bg-surface overflow-hidden">
<!-- Map Layer -->
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover opacity-90" data-alt="A high-tech digital world map visualization for maritime logistics. The map is presented in a sophisticated light-mode aesthetic with soft blue landmasses and subtle grid lines. Dynamic glowing blue lines trace a shipping route from China through the Indian Ocean towards East Africa. The overall lighting is bright and clean, emphasizing a precise and professional data tracking environment." data-location="Indian Ocean" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlJ31e3muxIdZnPRUuQ8o8fMbC7B2H52NM7ogYNTiDw1N_m1QsNBCmUYQ3xF68N3GPRRe1W3AeVrUP43AKvelSMIWUSRB1Vq7xs3kdGBFA59EzP6CBYFDlvi92b9I-ubBTPMQ4ElcCDUciv6HEMPV025TiPdxixq8J0-NeJsj0VW4u27ggtPsNJvpBOW6MMYmR1DTAY1GbKswmUZaLA5Zkb0-_3npXjMnNM5mhu0NQiKerEWplehEv0BzleQ4vD-RK-Dg4qr_L0M4x"/>
<!-- SVG Overlay for Routes and Markers -->
<svg class="absolute inset-0 w-full h-full pointer-events-none" preserveaspectratio="xMidYMid slice" viewbox="0 0 1000 600">
<!-- Shipping Route China -> Tanzania -->
<path class="route-path" d="M800,280 Q650,450 530,520 T300,510" fill="none" stroke="#004a99" stroke-linecap="round" stroke-width="2"></path>
<!-- Vessel Location China (Origin) -->
<circle cx="800" cy="280" fill="#004a99" r="4"></circle>
<!-- Vessel Location Tanzania (Destination) -->
<circle cx="300" cy="510" fill="#00385c" r="4"></circle>
</svg>
<!-- Current Vessel Marker (Interactive) -->
<div class="absolute" style="top: 48%; left: 55%;">
<div class="vessel-pulse w-4 h-4 rounded-full bg-primary border-2 border-white cursor-pointer hover:scale-125 transition-transform" onclick="toggleTrackingPanel()"></div>
<div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white/95 px-3 py-1.5 rounded shadow-lg border border-outline-variant/30 flex items-center gap-2 whitespace-nowrap">
<span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
<span class="font-label-md text-primary font-bold">MV PACIFIC STAR</span>
</div>
</div>
</div>
<!-- Floating Controls -->
<div class="absolute top-lg right-lg z-20 flex flex-col gap-sm">
<div class="glass-panel p-1 rounded-xl shadow-lg border border-outline-variant flex flex-col">
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors">
<span class="material-symbols-outlined">add</span>
</button>
<div class="h-[1px] bg-outline-variant mx-2"></div>
<button class="p-2 hover:bg-surface-container-high rounded-lg text-on-surface-variant transition-colors">
<span class="material-symbols-outlined">remove</span>
</button>
</div>
<button class="glass-panel p-3 rounded-xl shadow-lg border border-outline-variant text-on-surface-variant hover:text-primary transition-colors">
<span class="material-symbols-outlined">layers</span>
</button>
<button class="glass-panel p-3 rounded-xl shadow-lg border border-outline-variant text-on-surface-variant hover:text-primary transition-colors">
<span class="material-symbols-outlined">my_location</span>
</button>
</div>
<!-- Left Panel: Vessel Details (Glassmorphism Bento Style) -->
<div class="absolute top-lg left-lg bottom-lg w-80 z-20 transition-all duration-500 transform translate-x-0" id="vessel-panel">
<div class="h-full glass-panel rounded-2xl shadow-xl border border-outline-variant flex flex-col overflow-hidden">
<div class="p-md bg-primary-container text-on-primary flex items-center justify-between">
<div class="flex flex-col">
<span class="font-label-md opacity-70">CURRENTLY TRACKING</span>
<h3 class="font-headline-sm">MV PACIFIC STAR</h3>
</div>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">sailing</span>
</div>
<div class="flex-1 overflow-y-auto p-md space-y-md">
<!-- Status Badge -->
<div class="flex items-center justify-between bg-surface-container-lowest/50 p-sm rounded-xl border border-outline-variant/30">
<span class="text-body-sm text-outline">Status</span>
<div class="flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full">
<span class="w-2 h-2 rounded-full bg-green-600"></span>
<span class="text-xs font-bold text-green-700">IN TRANSIT</span>
</div>
</div>
<!-- Data Grid -->
<div class="grid grid-cols-2 gap-sm">
<div class="bg-surface-container-low p-sm rounded-xl">
<span class="text-[10px] text-outline uppercase font-semibold">Speed</span>
<div class="font-headline-sm text-primary">18.4 <span class="text-xs">kn</span></div>
</div>
<div class="bg-surface-container-low p-sm rounded-xl">
<span class="text-[10px] text-outline uppercase font-semibold">Heading</span>
<div class="font-headline-sm text-primary">242° <span class="text-xs">SW</span></div>
</div>
</div>
<!-- Location Coordinates -->
<div class="space-y-sm">
<label class="font-label-md text-outline">COORDINATES</label>
<div class="font-label-md bg-surface p-sm rounded-lg border border-outline-variant flex justify-between items-center">
<span class="text-on-surface">Lat: 06° 48' 22" S</span>
<span class="material-symbols-outlined text-outline text-sm">content_copy</span>
</div>
<div class="font-label-md bg-surface p-sm rounded-lg border border-outline-variant flex justify-between items-center">
<span class="text-on-surface">Lon: 39° 16' 10" E</span>
<span class="material-symbols-outlined text-outline text-sm">content_copy</span>
</div>
</div>
<!-- ETA & Progress -->
<div class="space-y-sm pt-md">
<div class="flex justify-between items-end">
<div class="flex flex-col">
<span class="text-[10px] text-outline uppercase">Next Port</span>
<span class="font-body-md font-bold text-primary">Dar es Salaam</span>
</div>
<div class="text-right">
<span class="text-[10px] text-outline uppercase">ETA</span>
<span class="font-body-sm text-on-surface block">Oct 12, 14:00</span>
</div>
</div>
<div class="h-2 bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-primary w-2/3"></div>
</div>
<div class="flex justify-between text-[10px] text-outline">
<span>SIN (Origin)</span>
<span>65% Complete</span>
</div>
</div>
<!-- Weather Info -->
<div class="bg-blue-50/50 p-sm rounded-xl border border-blue-100 flex items-center gap-md">
<span class="material-symbols-outlined text-tertiary">storm</span>
<div class="flex flex-col">
<span class="text-xs font-bold text-tertiary">Heavy Swell Alert</span>
<span class="text-[10px] text-tertiary/70">Moderate impact expected in 12h</span>
</div>
</div>
</div>
<div class="p-md border-t border-outline-variant bg-surface-container-low">
<button class="w-full bg-primary text-on-primary py-sm rounded-lg font-body-sm font-bold shadow-md active:scale-[0.98] transition-all">
                            View Full Manifest
                        </button>
<p class="text-[10px] text-outline text-center mt-2">Last Updated: Just Now</p>
</div>
</div>
</div>
<!-- Bottom Analytics Bar (Dashboard Grid) -->
<div class="absolute bottom-lg left-[340px] right-lg z-20">
<div class="grid grid-cols-12 gap-md">
<div class="col-span-12 md:col-span-8 glass-panel p-md rounded-2xl shadow-lg border border-outline-variant">
<div class="flex items-center justify-between mb-md">
<h4 class="font-headline-sm text-primary">Global Logistics Analytics</h4>
<div class="flex gap-2">
<span class="px-2 py-0.5 rounded bg-primary-container/10 text-primary text-[10px] font-bold">LIVE FEED</span>
<span class="px-2 py-0.5 rounded bg-surface-container text-outline text-[10px]">7 DAYS</span>
</div>
</div>
<div class="h-24 flex items-end gap-1 px-1">
<!-- Visual Chart Mockup -->
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 40%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 55%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 35%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 80%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 60%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 45%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 90%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 75%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 65%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 100%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 85%"></div>
<div class="flex-1 bg-primary/20 hover:bg-primary rounded-t-sm transition-all" style="height: 70%"></div>
</div>
<div class="flex justify-between mt-2 text-[10px] text-outline uppercase font-bold tracking-tighter">
<span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
</div>
</div>
<div class="col-span-12 md:col-span-4 glass-panel p-md rounded-2xl shadow-lg border border-outline-variant flex flex-col justify-between">
<div class="flex items-center justify-between">
<span class="font-label-md text-outline">FLEET PERFORMANCE</span>
<span class="material-symbols-outlined text-primary">trending_up</span>
</div>
<div class="flex items-center gap-md">
<div class="w-16 h-16 rounded-full border-4 border-primary border-r-transparent animate-[spin_10s_linear_infinite] flex items-center justify-center">
<span class="font-headline-sm text-primary">94%</span>
</div>
<div class="flex flex-col">
<span class="text-body-sm font-bold">On-Time Arrival</span>
<span class="text-[10px] text-green-600 font-bold">+2.4% vs last mo.</span>
</div>
</div>
<div class="flex justify-between gap-1 mt-md">
<div class="w-2 h-2 rounded-full bg-primary"></div>
<div class="w-2 h-2 rounded-full bg-primary/50"></div>
<div class="w-2 h-2 rounded-full bg-primary/20"></div>
<div class="w-2 h-2 rounded-full bg-primary/10"></div>
</div>
</div>
</div>
</div>
</section>
</main>
<!-- Contextual FAB (Logic Mandate) -->
<button class="fixed bottom-lg right-lg z-50 w-14 h-14 rounded-full bg-primary text-on-primary shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all md:hidden">
<span class="material-symbols-outlined">explore</span>
</button>
<script>
        function toggleTrackingPanel() {
            const panel = document.getElementById('vessel-panel');
            if (panel.classList.contains('translate-x-0')) {
                panel.classList.remove('translate-x-0');
                panel.classList.add('-translate-x-[120%]');
            } else {
                panel.classList.remove('-translate-x-[120%]');
                panel.classList.add('translate-x-0');
            }
        }

        // Simulating live data updates
        setInterval(() => {
            const coords = [
                'Lat: 06° 48\' ' + Math.floor(Math.random() * 60) + '" S',
                'Lon: 39° 16\' ' + Math.floor(Math.random() * 60) + '" E'
            ];
            const coordElements = document.querySelectorAll('#vessel-panel .font-label-md.bg-surface span:first-child');
            if(coordElements.length >= 2) {
                coordElements[0].innerText = coords[0];
                coordElements[1].innerText = coords[1];
            }
        }, 5000);
    </script>
</body></html>