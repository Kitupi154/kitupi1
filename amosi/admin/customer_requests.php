<?php
session_start();
include "db.php";

// if(!isset($_SESSION['admin_id'])){
//     header("Location: login.php");
//     exit();
// }

/* UPDATE STATUS */
if(isset($_GET['action']) && isset($_GET['id'])){

    $id = intval($_GET['id']);
    $action = $_GET['action'];

    $allowed = ['Pending','In Progress','Completed','Cancelled'];

    if(in_array($action, $allowed)){
        $stmt = $conn->prepare(
            "UPDATE service_requests
             SET request_status=?
             WHERE request_id=?"
        );
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: requests.php");
    exit();
}

/* FETCH */
$result = mysqli_query($conn,
"SELECT * FROM service_requests ORDER BY request_id DESC");
?>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Customer Requests - Mr Amosi Technical Services</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-background": "#1b1b1d",
                    "secondary-fixed-dim": "#62df7d",
                    "on-tertiary-container": "#98805d",
                    "on-primary-container": "#7c839b",
                    "error-container": "#ffdad6",
                    "on-secondary": "#ffffff",
                    "surface-container-highest": "#e4e2e4",
                    "on-primary": "#ffffff",
                    "primary-fixed": "#dae2fd",
                    "surface-variant": "#e4e2e4",
                    "surface-bright": "#fcf8fa",
                    "inverse-surface": "#303032",
                    "outline-variant": "#c6c6cd",
                    "inverse-primary": "#bec6e0",
                    "on-primary-fixed-variant": "#3f465c",
                    "surface": "#fcf8fa",
                    "background": "#fcf8fa",
                    "primary-fixed-dim": "#bec6e0",
                    "tertiary-container": "#271901",
                    "on-error": "#ffffff",
                    "surface-tint": "#565e74",
                    "tertiary-fixed": "#fcdeb5",
                    "primary-container": "#131b2e",
                    "primary": "#000000",
                    "on-primary-fixed": "#131b2e",
                    "secondary-fixed": "#7ffc97",
                    "surface-container-high": "#eae7e9",
                    "on-secondary-fixed": "#002109",
                    "tertiary-fixed-dim": "#dec29a",
                    "on-tertiary-fixed-variant": "#574425",
                    "outline": "#76777d",
                    "tertiary": "#000000",
                    "secondary": "#006e2d",
                    "surface-dim": "#dcd9db",
                    "on-surface": "#1b1b1d",
                    "on-secondary-container": "#007230",
                    "error": "#ba1a1a",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "secondary-container": "#7cf994",
                    "inverse-on-surface": "#f3f0f2",
                    "on-tertiary-fixed": "#271901",
                    "on-secondary-fixed-variant": "#005320",
                    "on-surface-variant": "#45464d",
                    "on-error-container": "#93000a",
                    "surface-container-low": "#f6f3f5",
                    "surface-container": "#f0edef"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "sm": "12px",
                    "xxl": "48px",
                    "container_max": "1280px",
                    "gutter": "24px",
                    "lg": "24px",
                    "md": "16px",
                    "base": "4px",
                    "xl": "32px",
                    "xs": "8px"
            },
            "fontFamily": {
                    "card-title": ["Inter"],
                    "page-title": ["Inter"],
                    "small-label": ["Inter"],
                    "body-text": ["Inter"],
                    "section-title": ["Inter"],
                    "hero-title": ["Inter"]
            },
            "fontSize": {
                    "card-title": ["22px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "page-title": ["36px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "small-label": ["13px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "body-text": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "section-title": ["28px", {"lineHeight": "1.3", "fontWeight": "600"}],
                    "hero-title": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .sidebar-active {
            background-color: #006e2d; /* Secondary from config */
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">
<!-- Admin SideNavBar Shell -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-primary-container dark:bg-on-background shadow-xl flex flex-col gap-sm p-md z-50">
<div class="mb-xxl px-md">
<h1 class="font-card-title text-card-title font-bold text-on-primary">Admin Panel</h1>
<p class="font-small-label text-small-label text-on-primary-container opacity-80">Technical Services</p>
</div>
<nav class="flex-grow flex flex-col gap-xs">
<a class="flex items-center gap-sm text-on-primary-container opacity-80 px-md py-sm hover:bg-primary-fixed-dim hover:text-primary-container transition-all scale-100 hover:scale-105 active:scale-95 rounded-lg font-small-label text-small-label" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Dashboard
            </a>
<a class="flex items-center gap-sm text-on-primary-container opacity-80 px-md py-sm hover:bg-primary-fixed-dim hover:text-primary-container transition-all scale-100 hover:scale-105 active:scale-95 rounded-lg font-small-label text-small-label" href="#">
<span class="material-symbols-outlined" data-icon="build">build</span>
                Services
            </a>
<!-- Active State: Requests -->
<a class="flex items-center gap-sm bg-secondary dark:bg-secondary-container text-on-secondary dark:text-on-secondary-container rounded-lg px-md py-sm font-small-label text-small-label scale-100 hover:scale-105 active:scale-95 transition-all" href="#">
<span class="material-symbols-outlined" data-icon="assignment_late">assignment_late</span>
                Requests
            </a>
<a class="flex items-center gap-sm text-on-primary-container opacity-80 px-md py-sm hover:bg-primary-fixed-dim hover:text-primary-container transition-all scale-100 hover:scale-105 active:scale-95 rounded-lg font-small-label text-small-label" href="#">
<span class="material-symbols-outlined" data-icon="analytics">analytics</span>
                Reports
            </a>
<a class="flex items-center gap-sm text-on-primary-container opacity-80 px-md py-sm hover:bg-primary-fixed-dim hover:text-primary-container transition-all scale-100 hover:scale-105 active:scale-95 rounded-lg font-small-label text-small-label" href="#">
<span class="material-symbols-outlined" data-icon="group">group</span>
                Users
            </a>
<a class="flex items-center gap-sm text-on-primary-container opacity-80 px-md py-sm hover:bg-primary-fixed-dim hover:text-primary-container transition-all scale-100 hover:scale-105 active:scale-95 rounded-lg font-small-label text-small-label" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
                Settings
            </a>
<a class="flex items-center gap-sm text-on-primary-container opacity-80 px-md py-sm hover:bg-primary-fixed-dim hover:text-primary-container transition-all scale-100 hover:scale-105 active:scale-95 rounded-lg font-small-label text-small-label" href="#">
<span class="material-symbols-outlined" data-icon="help">help</span>
                Support
            </a>
</nav>
<div class="mt-auto px-md pb-md">
<button class="w-full py-sm bg-secondary text-on-secondary rounded-lg font-small-label transition-transform active:scale-95 flex items-center justify-center gap-xs">
<span class="material-symbols-outlined" data-icon="add" style="font-size: 18px;">add</span>
                New Service
            </button>
</div>
</aside>



<!-- Main Content Canvas -->
<main class="ml-64 p-xxl">
<!-- Header Section -->
<header class="mb-xxl flex justify-between items-end">
<div>
<h2 class="font-page-title text-page-title text-on-surface">Customer Requests</h2>
<p class="font-body-text text-body-text text-on-surface-variant mt-xs">Manage and respond to technical service inquiries from clients.</p>
</div>
<div class="flex items-center gap-sm">
<button class="px-lg py-sm bg-surface-container-high border border-outline-variant text-on-surface rounded-lg font-small-label flex items-center gap-xs hover:bg-surface-container-highest transition-colors">
<span class="material-symbols-outlined" data-icon="download">download</span>
                    Export CSV
                </button>
</div>
</header>


<!-- Filters Bento-ish Layout -->
<section class="mb-xl grid grid-cols-1 md:grid-cols-4 gap-lg">
<div class="md:col-span-2 relative">
<span class="absolute left-md top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant" data-icon="search">search</span>
<input class="w-full pl-[48px] pr-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg focus:border-secondary focus:ring-1 focus:ring-secondary transition-all font-body-text text-body-text" placeholder="Search by name, ID, or problem..." type="text"/>
</div>
<div>
<select class="w-full px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg focus:border-secondary focus:ring-1 focus:ring-secondary transition-all font-body-text text-body-text appearance-none">
<option>All Categories</option>
<option>Electrical</option>
<option>Plumbing</option>
<option>HVAC</option>
<option>General Repair</option>
</select>
</div>
<div>
<select class="w-full px-md py-sm bg-surface-container-lowest border border-outline-variant rounded-lg focus:border-secondary focus:ring-1 focus:ring-secondary transition-all font-body-text text-body-text appearance-none">
<option>All Statuses</option>
<option>Pending</option>
<option>In Progress</option>
<option>Completed</option>
<option>Cancelled</option>
</select>
</div>
</section>


<!-- Data Table Section -->
<section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-md overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-low border-b border-outline-variant">
<tr>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">ID</th>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Date</th>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Customer Name</th>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Service Type</th>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Problem Summary</th>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Status</th>
<th class="px-lg py-md font-small-label text-small-label text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant font-body-text text-body-text">
<!-- Row 1 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-medium">#REQ-4029</td>
<td class="px-lg py-md">Oct 24, 2023</td>
<td class="px-lg py-md">
<div class="flex items-center gap-sm">
<div class="w-8 h-8 rounded-full bg-primary-fixed-dim flex items-center justify-center text-primary font-bold text-xs">JM</div>
                                    Jonathan Miller
                                </div>
</td>
<td class="px-lg py-md">Electrical</td>
<td class="px-lg py-md max-w-xs truncate text-on-surface-variant">Circuit breaker tripping repeatedly in server room.</td>
<td class="px-lg py-md">
<span class="px-sm py-xs bg-secondary-container text-on-secondary-container rounded-full text-xs font-semibold">Active</span>
</td>
<td class="px-lg py-md text-right">
<a class="text-secondary font-semibold hover:underline flex items-center justify-end gap-xs" href="#">
                                    View Details
                                    <span class="material-symbols-outlined" data-icon="chevron_right" style="font-size: 16px;">chevron_right</span>
</a>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-medium">#REQ-4028</td>
<td class="px-lg py-md">Oct 23, 2023</td>
<td class="px-lg py-md">
<div class="flex items-center gap-sm">
<div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center text-primary font-bold text-xs">SA</div>
                                    Sarah Anderson
                                </div>
</td>
<td class="px-lg py-md">HVAC</td>
<td class="px-lg py-md max-w-xs truncate text-on-surface-variant">Unusual noise coming from main AC unit.</td>
<td class="px-lg py-md">
<span class="px-sm py-xs bg-error-container text-on-error-container rounded-full text-xs font-semibold">Urgent</span>
</td>
<td class="px-lg py-md text-right">
<a class="text-secondary font-semibold hover:underline flex items-center justify-end gap-xs" href="#">
                                    View Details
                                    <span class="material-symbols-outlined" data-icon="chevron_right" style="font-size: 16px;">chevron_right</span>
</a>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-medium">#REQ-4027</td>
<td class="px-lg py-md">Oct 23, 2023</td>
<td class="px-lg py-md">
<div class="flex items-center gap-sm">
<div class="w-8 h-8 rounded-full bg-secondary-fixed-dim flex items-center justify-center text-primary font-bold text-xs">RP</div>
                                    Robert Peterson
                                </div>
</td>
<td class="px-lg py-md">Plumbing</td>
<td class="px-lg py-md max-w-xs truncate text-on-surface-variant">Low water pressure in building B bathrooms.</td>
<td class="px-lg py-md">
<span class="px-sm py-xs bg-surface-variant text-on-surface-variant rounded-full text-xs font-semibold">Pending</span>
</td>
<td class="px-lg py-md text-right">
<a class="text-secondary font-semibold hover:underline flex items-center justify-end gap-xs" href="#">
                                    View Details
                                    <span class="material-symbols-outlined" data-icon="chevron_right" style="font-size: 16px;">chevron_right</span>
</a>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-medium">#REQ-4026</td>
<td class="px-lg py-md">Oct 22, 2023</td>
<td class="px-lg py-md">
<div class="flex items-center gap-sm">
<div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-xs">EK</div>
                                    Emily Knowles
                                </div>
</td>
<td class="px-lg py-md">General Repair</td>
<td class="px-lg py-md max-w-xs truncate text-on-surface-variant">Loose handrail on the north stairwell.</td>
<td class="px-lg py-md">
<span class="px-sm py-xs bg-secondary-container text-on-secondary-container rounded-full text-xs font-semibold">Scheduled</span>
</td>
<td class="px-lg py-md text-right">
<a class="text-secondary font-semibold hover:underline flex items-center justify-end gap-xs" href="#">
                                    View Details
                                    <span class="material-symbols-outlined" data-icon="chevron_right" style="font-size: 16px;">chevron_right</span>
</a>
</td>
</tr>
<!-- Row 5 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-md font-medium">#REQ-4025</td>
<td class="px-lg py-md">Oct 21, 2023</td>
<td class="px-lg py-md">
<div class="flex items-center gap-sm">
<div class="w-8 h-8 rounded-full bg-surface-dim flex items-center justify-center text-primary font-bold text-xs">DC</div>
                                    David Chen
                                </div>
</td>
<td class="px-lg py-md">Electrical</td>
<td class="px-lg py-md max-w-xs truncate text-on-surface-variant">Exterior parking lights not turning on at night.</td>
<td class="px-lg py-md">
<span class="px-sm py-xs bg-surface-container-high text-on-surface rounded-full text-xs font-semibold">Completed</span>
</td>
<td class="px-lg py-md text-right">
<a class="text-secondary font-semibold hover:underline flex items-center justify-end gap-xs" href="#">
                                    View Details
                                    <span class="material-symbols-outlined" data-icon="chevron_right" style="font-size: 16px;">chevron_right</span>
</a>
</td>
</tr>
</tbody>
</table>
</div>



<!-- Pagination Controls -->
<footer class="px-lg py-md flex items-center justify-between bg-surface-container-low border-t border-outline-variant">
<span class="font-small-label text-small-label text-on-surface-variant">Showing 1 to 5 of 42 requests</span>
<div class="flex items-center gap-xs">
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-highest transition-colors disabled:opacity-50" disabled="">
<span class="material-symbols-outlined" data-icon="navigate_before">navigate_before</span>
</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg bg-secondary text-on-secondary font-small-label">1</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-highest transition-colors font-small-label">2</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-highest transition-colors font-small-label">3</button>
<span class="px-xs text-on-surface-variant">...</span>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-highest transition-colors font-small-label">9</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-highest transition-colors">
<span class="material-symbols-outlined" data-icon="navigate_next">navigate_next</span>
</button>
</div>
</footer>
</section>
<!-- Insights Summary Cards (Bento style highlight) -->
<section class="mt-xxl grid grid-cols-1 md:grid-cols-3 gap-lg">
<div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
<h4 class="font-small-label text-small-label text-on-surface-variant uppercase mb-sm">Avg Response Time</h4>
<div class="flex items-baseline gap-xs">
<span class="text-hero-title font-hero-title text-on-surface">2.4</span>
<span class="font-body-text text-body-text text-on-surface-variant">hours</span>
</div>
<div class="mt-md flex items-center gap-xs text-secondary">
<span class="material-symbols-outlined" data-icon="trending_up" style="font-size: 18px;">trending_up</span>
<span class="font-small-label">12% faster than last month</span>
</div>
</div>
<div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
<h4 class="font-small-label text-small-label text-on-surface-variant uppercase mb-sm">Current Active Tickets</h4>
<div class="flex items-baseline gap-xs">
<span class="text-hero-title font-hero-title text-on-surface">18</span>
<span class="font-body-text text-body-text text-on-surface-variant">requests</span>
</div>
<div class="mt-md flex items-center gap-xs text-on-surface-variant">
<span class="material-symbols-outlined" data-icon="warning" style="font-size: 18px;">warning</span>
<span class="font-small-label">3 require immediate attention</span>
</div>
</div>
<div class="bg-primary-container p-lg rounded-xl border border-outline-variant text-on-primary">
<h4 class="font-small-label text-small-label opacity-70 uppercase mb-sm">Client Satisfaction</h4>
<div class="flex items-baseline gap-xs">
<span class="text-hero-title font-hero-title">4.9</span>
<span class="font-body-text text-body-text opacity-70">/ 5.0</span>
</div>
<div class="mt-md flex items-center gap-xs text-secondary-fixed">
<span class="material-symbols-outlined" data-icon="verified" data-weight="fill" style="font-size: 18px;">verified</span>
<span class="font-small-label">Highly rated by enterprises</span>
</div>
</div>
</section>
</main>
<!-- Simple Footer (suppressed for admin dash if needed, but included for completeness) -->
<footer class="ml-64 bg-surface-container-high dark:bg-surface-container-highest border-t border-outline-variant py-lg">
<div class="max-w-container_max mx-auto px-lg flex flex-col md:flex-row justify-between items-center gap-md">
<p class="font-body-text text-body-text text-on-surface-variant">© 2024 Mr Amosi Technical Services. All rights reserved.</p>
<div class="flex gap-lg">
<a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Privacy Policy</a>
<a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Terms of Service</a>
<a class="font-body-text text-body-text text-on-surface-variant hover:text-secondary transition-colors" href="#">Support Portal</a>
</div>
</div>
</footer>
</body></html>