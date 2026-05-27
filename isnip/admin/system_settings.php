<?php
session_start();
include("../customer/registrations/db.php");

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: ../customer/registrations/login1.php");
    exit();
}

// ROLE CHECK (same logic as dashboard)
if ($_SESSION['role'] != 'admin') {

    if ($_SESSION['role'] == 'customer') {
        header("Location: ../customer/customerdash.php");
        exit();
    }

    if ($_SESSION['role'] == 'staff') {
        header("Location: ../staff/staffdash.php");
        exit();
    }

    session_destroy();
    header("Location: ../customer/registrations/login1.php");
    exit();
}

$settings = mysqli_query($conn, "SELECT * FROM system_settings ORDER BY setting_id DESC LIMIT 1");
$system = mysqli_fetch_assoc($settings);


if (isset($_POST['save_settings'])) {

    $company_name = $_POST['company_name'];
    $company_email = $_POST['company_email'];
    $company_phone = $_POST['company_phone'];
    $company_address = $_POST['company_address'];

    $check = mysqli_query($conn, "SELECT * FROM system_settings LIMIT 1");

    if (mysqli_num_rows($check) > 0) {

        mysqli_query($conn,
        "UPDATE system_settings SET
            company_name='$company_name',
            company_email='$company_email',
            company_phone='$company_phone',
            company_address='$company_address',
            updated_at=NOW()
        ");
    } else {

        mysqli_query($conn,
        "INSERT INTO system_settings
        (company_name, company_email, company_phone, company_address)
        VALUES
        ('$company_name','$company_email','$company_phone','$company_address')");
    }

    header("Location: system_settings.php?success=1");
    exit();
}


?>


<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>ISNIS - Fleet Settings</title>
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
        .active-tab-indicator {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-panel {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8);
        }
        input:focus { outline: none; }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #004a99;
        }
        .toggle-checkbox:checked + .toggle-label::after {
            transform: translateX(1.25rem);
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-surface font-body-md overflow-hidden h-screen flex">
<!-- Top Navigation Bar -->
<?php include("../admin/includes/sidebar.php"); ?>
<?php include("../admin/includes/header.php"); ?>

<!-- update successfully -->
<?php if (isset($_GET['success'])): ?>
<div class="bg-green-100 text-green-700 p-3 rounded">
    Settings updated successfully!
</div>
<?php endif; ?>


<!-- Main Content Canvas -->
<main class="pl-[260px] pt-16 h-screen w-full flex flex-col">
<!-- Dashboard Header -->
<div class="px-xl py-lg bg-surface flex justify-between items-end border-b border-outline-variant">
<div>
<nav class="flex items-center gap-xs text-on-surface-variant font-label-md mb-base">
<span>System</span>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<span class="text-primary font-bold">Account Settings</span>
</nav>
<h2 class="font-headline-lg text-headline-lg text-primary">Enterprise Settings</h2>
<p class="text-on-surface-variant max-w-2xl">Manage your organizational preferences, fleet tracking configurations, and secure access protocols for the maritime logistics platform.</p>
</div>
<div class="flex gap-md mb-base">
<button class="px-lg py-sm rounded-lg border border-primary text-primary font-semibold hover:bg-primary-container/5 transition-colors">Discard</button>

<button type="submit" name="save_settings">
    Save Changes
</button>
</div>
</div>
<!-- Scrollable Settings Area -->
<div class="flex-1 overflow-y-auto bg-background p-xl">
<div class="max-w-6xl mx-auto flex gap-xl">
<!-- Vertical Tabs (Settings Sidebar) -->
<aside class="w-72 shrink-0">
<div class="flex flex-col gap-xs sticky top-0">
<button class="tab-btn active text-left px-md py-sm rounded-lg font-semibold transition-all duration-200 flex items-center gap-sm bg-primary-container text-on-primary shadow-sm" id="tab-company" onclick="switchTab('company')">
<span class="material-symbols-outlined">business</span>
                            Company Settings
                        </button>
<button class="tab-btn text-left px-md py-sm rounded-lg font-semibold transition-all duration-200 flex items-center gap-sm text-on-surface-variant hover:bg-surface-container" id="tab-security" onclick="switchTab('security')">
<span class="material-symbols-outlined">verified_user</span>
                            Security Settings
                        </button>
<button class="tab-btn text-left px-md py-sm rounded-lg font-semibold transition-all duration-200 flex items-center gap-sm text-on-surface-variant hover:bg-surface-container" id="tab-notification" onclick="switchTab('notification')">
<span class="material-symbols-outlined">notifications_active</span>
                            Notification Settings
                        </button>
<button class="tab-btn text-left px-md py-sm rounded-lg font-semibold transition-all duration-200 flex items-center gap-sm text-on-surface-variant hover:bg-surface-container" id="tab-gps" onclick="switchTab('gps')">
<span class="material-symbols-outlined">location_on</span>
                            GPS Tracking Settings
                        </button>
<button class="tab-btn text-left px-md py-sm rounded-lg font-semibold transition-all duration-200 flex items-center gap-sm text-on-surface-variant hover:bg-surface-container" id="tab-preferences" onclick="switchTab('preferences')">
<span class="material-symbols-outlined">tune</span>
                            User Preferences
                        </button>
</div>
</aside>
<!-- Content Area -->
<div class="flex-1 space-y-lg pb-xl">
<!-- Company Settings Section -->
<section class="settings-content space-y-md" id="content-company">
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-lg shadow-sm">
<h3 class="font-headline-sm text-headline-sm mb-sm text-primary">Organizational Identity</h3>
<div class="grid grid-cols-2 gap-md">
<div class="space-y-xs">
<label class="font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Legal Entity Name</label>
<input class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 bg-surface" type="text" value="ISNIS Global Maritime Logistics Ltd."/>
</div>
<div class="space-y-xs">
<label class="font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Registration Number</label>
<input class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 bg-surface" type="text" value="IMO-9988-GBL"/>
</div>
<div class="space-y-xs col-span-2">
<label class="font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Primary Operations Hub</label>
<select class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 bg-surface">
<option>Rotterdam International Port, Netherlands</option>
<option>Port of Singapore, Central</option>
<option>Shanghai Port Authority, China</option>
</select>
</div>
</div>
</div>
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-lg shadow-sm">
<div class="flex items-start justify-between">
<div class="space-y-xs">
<h4 class="font-headline-sm text-primary">Fleet Branding</h4>
<p class="text-on-surface-variant text-sm">Upload your company logo for automated manifest generation and port documents.</p>
</div>
<div class="w-32 h-32 rounded-xl bg-surface border-2 border-dashed border-outline-variant flex flex-col items-center justify-center text-on-surface-variant hover:border-primary cursor-pointer transition-colors group">
<span class="material-symbols-outlined text-[32px] group-hover:scale-110 transition-transform">cloud_upload</span>
<span class="text-xs font-semibold mt-xs">Update Logo</span>
</div>
</div>
</div>
</section>
<!-- GPS Tracking Settings (Specific Layout) -->
<section class="settings-content hidden space-y-md" id="content-gps">
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
<div class="h-48 bg-surface-dim relative">
<img class="w-full h-full object-cover" data-alt="A highly detailed and sophisticated satellite perspective of global maritime trade routes, featuring glowing blue lines connecting major world ports against a dark oceanic background. The lighting is focused and technical, emphasizing precision and data density typical of a high-tech logistics dashboard. The overall mood is futuristic and reliable, with a soft cool-toned color palette." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCteaoKVYoSRu2p4rAm_qtv4bU4C-WZ9dvr6IW1-rp98aDlhNX0Ny7DgDa6kZTjnOk2jPGTqNfCfPaESYzZ0OOtvCovwlYiJKxWG5PUCP3xkfKOtgCJIqtGmtnaJuq6FN8pGaP3u_kIv147judaqlz3NUmf_hzL89HfODzEoy2zGomwThhYcuhIG_HvvX6ZDOhXL9kOeu77ZcGicoW-zsmOFM7KEhUZj32DBzwQYZAT8uGuOoiPLYrpBDz8ojFz3rJpDbFngsyyvr68"/>
<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-lg">
<span class="text-white font-semibold flex items-center gap-sm">
<span class="material-symbols-outlined">satellite_alt</span>
                                        Live Satellite Feed Active
                                    </span>
</div>
</div>
<div class="p-lg space-y-lg">
<div class="flex items-center justify-between">
<div class="max-w-md">
<h4 class="font-semibold text-primary">Precision Interval</h4>
<p class="text-on-surface-variant text-sm">Frequency of AIS signal updates. Higher frequency provides smoother tracking but increases bandwidth consumption.</p>
</div>
<div class="flex bg-surface rounded-lg p-xs border border-outline-variant">
<button class="px-md py-xs text-xs font-bold rounded bg-primary text-on-primary">High (30s)</button>
<button class="px-md py-xs text-xs font-bold rounded text-on-surface-variant hover:bg-surface-container">Std (2m)</button>
<button class="px-md py-xs text-xs font-bold rounded text-on-surface-variant hover:bg-surface-container">Eco (15m)</button>
</div>
</div>
<hr class="border-outline-variant"/>
<div class="space-y-md">
<div class="flex items-center justify-between">
<div>
<p class="font-semibold text-on-surface">Predictive Dead Reckoning</p>
<p class="text-xs text-on-surface-variant">Estimate vessel position during temporary signal loss.</p>
</div>
<div class="relative inline-block w-12 h-6">
<input checked="" class="toggle-checkbox absolute opacity-0 w-0 h-0" type="checkbox"/>
<label class="toggle-label absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-outline-variant rounded-full transition-all duration-300 before:absolute before:h-4 before:w-4 before:left-1 before:bottom-1 before:bg-white before:rounded-full before:transition-all before:duration-300 after:content-[''] after:absolute after:w-4 after:h-4 after:bg-white after:rounded-full after:left-1 after:bottom-1 after:transition-all after:duration-300"></label>
</div>
</div>
<div class="flex items-center justify-between">
<div>
<p class="font-semibold text-on-surface">Geofence Drift Alert</p>
<p class="text-xs text-on-surface-variant">Notify if vessel deviates more than 500m from planned route.</p>
</div>
<div class="relative inline-block w-12 h-6">
<input class="toggle-checkbox absolute opacity-0 w-0 h-0" type="checkbox"/>
<label class="toggle-label absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-outline-variant rounded-full transition-all duration-300 before:absolute before:h-4 before:w-4 before:left-1 before:bottom-1 before:bg-white before:rounded-full before:transition-all before:duration-300 after:content-[''] after:absolute after:w-4 after:h-4 after:bg-white after:rounded-full after:left-1 after:bottom-1 after:transition-all after:duration-300"></label>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Security Section (Grid Layout) -->
<section class="settings-content hidden space-y-md" id="content-security">
<div class="grid grid-cols-2 gap-md">
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm space-y-md">
<div class="w-12 h-12 rounded-lg bg-error-container flex items-center justify-center text-on-error-container">
<span class="material-symbols-outlined">shield_with_heart</span>
</div>
<div>
<h4 class="font-semibold text-primary">Two-Factor Authentication</h4>
<p class="text-sm text-on-surface-variant">Currently enabled via SMS ending in •••• 42. It is highly recommended to switch to an Authenticator app for enhanced security.</p>
</div>
<button class="w-full py-sm bg-surface-container-high rounded-lg font-bold text-on-surface hover:bg-surface-container-highest transition-colors">Manage 2FA</button>
</div>
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm space-y-md">
<div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-on-primary-fixed-variant">
<span class="material-symbols-outlined">history</span>
</div>
<div>
<h4 class="font-semibold text-primary">Session Monitoring</h4>
<p class="text-sm text-on-surface-variant">You have 3 active sessions across desktop and mobile. All sessions are using encrypted TLS 1.3 protocols.</p>
</div>
<button class="w-full py-sm bg-surface-container-high rounded-lg font-bold text-on-surface hover:bg-surface-container-highest transition-colors">Review Logins</button>
</div>
</div>
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">
<h4 class="font-semibold text-primary mb-md">Connected IP Whitelist</h4>
<div class="space-y-sm">
<div class="flex items-center justify-between p-sm bg-surface rounded-lg border border-outline-variant/30">
<code class="font-label-md text-sm">192.168.1.100 (HQ Office)</code>
<span class="text-primary font-bold text-xs uppercase cursor-pointer">Remove</span>
</div>
<div class="flex items-center justify-between p-sm bg-surface rounded-lg border border-outline-variant/30">
<code class="font-label-md text-sm">45.22.109.12 (Secondary Hub)</code>
<span class="text-primary font-bold text-xs uppercase cursor-pointer">Remove</span>
</div>
<button class="mt-md text-primary font-bold flex items-center gap-xs text-sm hover:underline">
<span class="material-symbols-outlined text-sm">add</span> Add New Trusted IP
                                </button>
</div>
</div>
</section>
<!-- Notification & Preferences Placeholder Sections -->
<section class="settings-content hidden" id="content-notification">
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-xl flex flex-col items-center justify-center text-center space-y-md min-h-[400px]">
<span class="material-symbols-outlined text-6xl text-outline-variant">notifications_paused</span>
<h3 class="font-headline-sm">Notification Channels</h3>
<p class="text-on-surface-variant max-w-sm">Configure how you receive critical alerts, manifest updates, and port authority clearances.</p>
<div class="w-full max-w-md space-y-md text-left">
<div class="flex justify-between items-center p-md border border-outline-variant rounded-xl">
<span class="font-semibold">Email Summary (Weekly)</span>
<input checked="" class="h-5 w-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/>
</div>
<div class="flex justify-between items-center p-md border border-outline-variant rounded-xl">
<span class="font-semibold">Push Notifications (Instant)</span>
<input checked="" class="h-5 w-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/>
</div>
</div>
</div>
</section>
<section class="settings-content hidden" id="content-preferences">
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-xl min-h-[400px] space-y-lg">
<h3 class="font-headline-sm text-primary">Interface Customization</h3>
<div class="grid grid-cols-3 gap-md">
<div class="p-md rounded-xl border-2 border-primary bg-primary-container/10 flex flex-col items-center gap-sm">
<span class="material-symbols-outlined text-primary">light_mode</span>
<p class="font-bold text-sm">Light Mode</p>
</div>
<div class="p-md rounded-xl border-2 border-outline-variant hover:border-primary transition-colors flex flex-col items-center gap-sm cursor-pointer">
<span class="material-symbols-outlined text-on-surface-variant">dark_mode</span>
<p class="font-bold text-sm text-on-surface-variant">Dark Mode</p>
</div>
<div class="p-md rounded-xl border-2 border-outline-variant hover:border-primary transition-colors flex flex-col items-center gap-sm cursor-pointer">
<span class="material-symbols-outlined text-on-surface-variant">settings_brightness</span>
<p class="font-bold text-sm text-on-surface-variant">System</p>
</div>
</div>
<div class="space-y-sm pt-md">
<h4 class="font-semibold">Language &amp; Region</h4>
<select class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface">
<option>English (International)</option>
<option>Dutch (Netherlands)</option>
<option>Mandarin (Simplified)</option>
</select>
</div>
</div>
</section>
</div>
</div>
</div>
</main>
<!-- Contextual FAB (Hidden on Settings but defined for System Integrity) -->
<!-- Suppressed based on "Relevance Check" rule -->
<script>
        function switchTab(tabId) {
            // Hide all content sections
            document.querySelectorAll('.settings-content').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Show selected content section
            document.getElementById('content-' + tabId).classList.remove('hidden');

            // Reset all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-primary-container', 'text-on-primary', 'shadow-sm', 'active');
                btn.classList.add('text-on-surface-variant', 'hover:bg-surface-container');
            });

            // Set active tab button
            const activeBtn = document.getElementById('tab-' + tabId);
            activeBtn.classList.remove('text-on-surface-variant', 'hover:bg-surface-container');
            activeBtn.classList.add('bg-primary-container', 'text-on-primary', 'shadow-sm', 'active');
        }

        // Initialize active state logic based on page intent
        window.addEventListener('load', () => {
            // Force settings tab as active in Sidebar (Visual Mock Only)
            // Actual interaction logic would link real pages
        });
    </script>
</body></html>