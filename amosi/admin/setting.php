<?php
session_start();
include "db.php";

$sql = "SELECT * FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql);

$settings = mysqli_fetch_assoc($result);

if(isset($_POST['save_settings'])){

    // save logic here


if(isset($_POST['save_settings'])){

    $business_name     = mysqli_real_escape_string($conn, $_POST['business_name']);
    $phone             = mysqli_real_escape_string($conn, $_POST['phone']);
    $email             = mysqli_real_escape_string($conn, $_POST['email']);
    $location          = mysqli_real_escape_string($conn, $_POST['location']);
    $about_us          = mysqli_real_escape_string($conn, $_POST['about_us']);

    $tagline           = mysqli_real_escape_string($conn, $_POST['tagline']);
    $hero_title        = mysqli_real_escape_string($conn, $_POST['hero_title']);
    $hero_subtitle     = mysqli_real_escape_string($conn, $_POST['hero_subtitle']);
    $hero_button_text  = mysqli_real_escape_string($conn, $_POST['hero_button_text']);

    $meta_title        = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_description  = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keywords     = mysqli_real_escape_string($conn, $_POST['meta_keywords']);

    $facebook          = mysqli_real_escape_string($conn, $_POST['facebook']);
    $instagram         = mysqli_real_escape_string($conn, $_POST['instagram']);
    $linkedin          = mysqli_real_escape_string($conn, $_POST['linkedin']);
    $twitter           = mysqli_real_escape_string($conn, $_POST['twitter']);
    $youtube           = mysqli_real_escape_string($conn, $_POST['youtube']);

    $primary_color     = mysqli_real_escape_string($conn, $_POST['primary_color']);
    $secondary_color   = mysqli_real_escape_string($conn, $_POST['secondary_color']);

    /*
    =========================
    GET CURRENT FILES
    =========================
    */

    $current = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT * FROM settings LIMIT 1")
    );

    $logo        = $current['logo'];
    $favicon     = $current['favicon'];
    $hero_image  = $current['hero_image'];
    $og_image    = $current['og_image'];

    /*
    =========================
    LOGO UPLOAD
    =========================
    */

    if(!empty($_FILES['logo']['name'])){

        $logo =
        time().'_'.$_FILES['logo']['name'];

        move_uploaded_file(
            $_FILES['logo']['tmp_name'],
            "uploads/".$logo
        );
    }

    /*
    =========================
    FAVICON UPLOAD
    =========================
    */

    if(!empty($_FILES['favicon']['name'])){

        $favicon =
        time().'_'.$_FILES['favicon']['name'];

        move_uploaded_file(
            $_FILES['favicon']['tmp_name'],
            "uploads/".$favicon
        );
    }

    /*
    =========================
    HERO IMAGE
    =========================
    */

    if(!empty($_FILES['hero_image']['name'])){

        $hero_image =
        time().'_'.$_FILES['hero_image']['name'];

        move_uploaded_file(
            $_FILES['hero_image']['tmp_name'],
            "uploads/".$hero_image
        );
    }

    /*
    =========================
    OG IMAGE
    =========================
    */

    if(!empty($_FILES['og_image']['name'])){

        $og_image =
        time().'_'.$_FILES['og_image']['name'];

        move_uploaded_file(
            $_FILES['og_image']['tmp_name'],
            "uploads/".$og_image
        );
    }

    /*
    =========================
    UPDATE SETTINGS
    =========================
    */

    $sql = "
    UPDATE settings SET

    business_name='$business_name',
    phone='$phone',
    email='$email',
    location='$location',
    about_us='$about_us',

    tagline='$tagline',
    hero_title='$hero_title',
    hero_subtitle='$hero_subtitle',
    hero_button_text='$hero_button_text',

    meta_title='$meta_title',
    meta_description='$meta_description',
    meta_keywords='$meta_keywords',

    facebook='$facebook',
    instagram='$instagram',
    linkedin='$linkedin',
    twitter='$twitter',
    youtube='$youtube',

    primary_color='$primary_color',
    secondary_color='$secondary_color',

    logo='$logo',
    favicon='$favicon',
    hero_image='$hero_image',
    og_image='$og_image'

    WHERE setting_id = 1
    ";

    if(mysqli_query($conn,$sql)){

        $success =
        "Settings updated successfully.";

        $settings = mysqli_fetch_assoc(
            mysqli_query($conn,"SELECT * FROM settings LIMIT 1")
        );

    }else{

        $error =
        "Failed to update settings.";

    }
}
}
if(isset($_POST['update_password'])){

    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($new_password)){

        $error = "Password cannot be empty.";

    }elseif($new_password != $confirm_password){

        $error = "Passwords do not match.";

    }else{

        $hashed_password = password_hash(
            $new_password,
            PASSWORD_DEFAULT
        );

        $admin_id = $_SESSION['admin_id'];

        mysqli_query(
            $conn,
            "UPDATE admins
             SET password='$hashed_password'
             WHERE admin_id='$admin_id'"
        );

        $success = "Password updated successfully.";
    }
}

$maintenance_mode =
isset($_POST['maintenance_mode']) ? 1 : 0;

$auto_backup =
isset($_POST['auto_backup']) ? 1 : 0;

$notifications_enabled =
isset($_POST['notifications_enabled']) ? 1 : 0;

$backup_time =
mysqli_real_escape_string(
$conn,
$_POST['backup_time']
);

$notification_type =
mysqli_real_escape_string(
$conn,
$_POST['notification_type']
);

// maintenance_mode='$maintenance_mode',
// auto_backup='$auto_backup',
// notifications_enabled='$notifications_enabled',
// backup_time='$backup_time',
// notification_type='$notification_type',


if(isset($_POST['clear_cache'])){

    $success =
    "System cache cleared successfully.";

}
?>

<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TechCore Admin - Full Settings Console</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #051424; /* surface */
            scrollbar-width: thin;
            scrollbar-color: #3e4a3d #051424;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "surface": "#051424",
                      "secondary": "#7bd0ff",
                      "on-primary-container": "#003111",
                      "tertiary": "#ffb2bf",
                      "on-tertiary-fixed-variant": "#8a143c",
                      "on-secondary": "#00354a",
                      "primary-container": "#1ca64d",
                      "error-container": "#93000a",
                      "tertiary-container": "#ec6284",
                      "surface-container-low": "#0d1c2d",
                      "surface-container-high": "#1c2b3c",
                      "error": "#ffb4ab",
                      "on-surface-variant": "#bdcaba",
                      "outline": "#879485",
                      "secondary-fixed": "#c4e7ff",
                      "outline-variant": "#3e4a3d",
                      "inverse-on-surface": "#233143",
                      "primary-fixed": "#7ffc97",
                      "inverse-surface": "#d4e4fa",
                      "on-error-container": "#ffdad6",
                      "surface-tint": "#62df7d",
                      "on-tertiary-container": "#5a0022",
                      "secondary-container": "#00a6e0",
                      "tertiary-fixed": "#ffd9de",
                      "on-secondary-fixed-variant": "#004c69",
                      "primary": "#16a34a", /* Overridden to requested green */
                      "tertiary-fixed-dim": "#ffb2bf",
                      "surface-container": "#122131",
                      "surface-bright": "#2c3a4c",
                      "surface-container-lowest": "#010f1f",
                      "on-error": "#690005",
                      "on-surface": "#d4e4fa",
                      "on-secondary-fixed": "#001e2c",
                      "on-primary-fixed": "#002109",
                      "inverse-primary": "#006e2d",
                      "secondary-fixed-dim": "#7bd0ff",
                      "primary-fixed-dim": "#62df7d",
                      "on-tertiary-fixed": "#3f0016",
                      "on-primary-fixed-variant": "#005320",
                      "background": "#051424",
                      "surface-dim": "#051424",
                      "surface-container-highest": "#273647",
                      "on-secondary-container": "#00374d",
                      "on-tertiary": "#660027",
                      "on-primary": "#ffffff",
                      "surface-variant": "#273647",
                      "on-background": "#d4e4fa"
              },
              "borderRadius": {
                      "DEFAULT": "0.125rem",
                      "lg": "0.25rem",
                      "xl": "0.5rem",
                      "full": "0.75rem"
              },
              "spacing": {
                      "stack-lg": "32px",
                      "container-max-width": "1440px",
                      "gutter": "16px",
                      "stack-xs": "4px",
                      "stack-md": "16px",
                      "stack-sm": "8px",
                      "unit": "4px",
                      "margin": "24px"
              },
              "fontFamily": {
                      "label-sm": ["JetBrains Mono"],
                      "headline-lg": ["Geist"],
                      "body-lg": ["Geist"],
                      "headline-sm": ["Geist"],
                      "body-md": ["Geist"],
                      "label-md": ["JetBrains Mono"],
                      "headline-md": ["Geist"]
              },
              "fontSize": {
                      "label-sm": ["10px", {"lineHeight": "14px", "letterSpacing": "0.08em", "fontWeight": "500"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
                      "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                      "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "500"}],
                      "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                      "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                      "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}]
              }
            },
          },
        }
    </script>
</head>
<body>

<?php include("includes/sidebar.php"); ?>

<div class="main-wrapper">

    <?php include("includes/header.php"); ?>

    <main class="content-area">

<!-- Content Area -->
<div class="p-margin max-w-[1280px] mx-auto w-full space-y-gutter pb-40">
    <form method="POST"
enctype="multipart/form-data">
    <div class="p-margin grid grid-cols-2 gap-margin">

    <!-- BUSINESS NAME -->
    <div class="space-y-stack-xs">
        <label class="font-label-md text-label-md text-outline uppercase">
            Business Name
        </label>

        <input
        type="text"
        name="business_name"
        value="<?= htmlspecialchars($settings['business_name']) ?>"
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none transition-all">
    </div>

    <!-- TAGLINE -->
    <div class="space-y-stack-xs">
        <label class="font-label-md text-label-md text-outline uppercase">
            Tagline
        </label>

        <input
        type="text"
        name="tagline"
        value="<?= htmlspecialchars($settings['tagline']) ?>"
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none transition-all">
    </div>

    <!-- ABOUT US -->
    <div class="col-span-2 space-y-stack-xs">
        <label class="font-label-md text-label-md text-outline uppercase">
            About Us
        </label>

        <textarea
        name="about_us"
        rows="4"
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none transition-all resize-none"><?= htmlspecialchars($settings['about_us']) ?></textarea>
    </div>

    <!-- EMAIL -->
    <div class="space-y-stack-xs">
        <label class="font-label-md text-label-md text-outline uppercase">
            Email Address
        </label>

        <input
        type="email"
        name="email"
        value="<?= htmlspecialchars($settings['email']) ?>"
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none transition-all">
    </div>

    <!-- PHONE -->
    <div class="space-y-stack-xs">
        <label class="font-label-md text-label-md text-outline uppercase">
            Phone Number
        </label>

        <input
        type="text"
        name="phone"
        value="<?= htmlspecialchars($settings['phone']) ?>"
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none transition-all">
    </div>

    <!-- LOCATION -->
    <div class="col-span-2 space-y-stack-xs">
        <label class="font-label-md text-label-md text-outline uppercase">
            Business Location
        </label>

        <input
        type="text"
        name="location"
        value="<?= htmlspecialchars($settings['location']) ?>"
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none transition-all">
    </div>

</div>


<!-- 3. Homepage Hero (Interactive Preview) -->
<section class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<div class="bg-surface-container border border-outline-variant rounded-xl p-margin flex flex-col">
<div class="flex items-center gap-stack-md text-primary mb-stack-lg">
<span class="material-symbols-outlined" data-icon="web">web</span>
<h3 class="font-headline-sm text-headline-sm">Homepage Hero</h3>
</div>
<div class="space-y-stack-md flex-grow">
<div class="space-y-stack-xs">
<label class="font-label-md text-label-md text-outline uppercase">Hero Title</label>
<input
class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none"
type="text"
name="hero_title"
value="<?= htmlspecialchars($settings['hero_title']) ?>">
</div>
<div class="space-y-stack-xs">
<label class="font-label-md text-label-md text-outline uppercase">Subtitle / Tagline</label>
<input
class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none"
type="text"
name="hero_subtitle"
value="<?= htmlspecialchars($settings['hero_subtitle']) ?>">
</div>
<div class="space-y-stack-xs">
<label class="font-label-md text-label-md text-outline uppercase">Button Label</label>
<input
class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none"
type="text"
name="hero_button_text"
value="<?= htmlspecialchars($settings['hero_button_text']) ?>">
</div>

<div class="space-y-stack-xs">

<label class="font-label-md text-label-md text-outline uppercase">
Hero Background
</label>

<div class="flex items-center gap-stack-md border-2 border-dashed border-outline-variant p-stack-md rounded-lg hover:border-primary cursor-pointer transition-all bg-surface-container-lowest/50 group">

<span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">
upload
</span>

<input
type="file"
name="hero_image"
class="w-full text-body-md text-on-surface">

</div>

<?php if(!empty($settings['hero_image'])){ ?>

<img
src="uploads/<?= $settings['hero_image']; ?>"
class="mt-3 rounded-lg border border-outline-variant h-32 object-cover">

<?php } ?>

</div>


<!-- Live Preview Panel (from SCREEN_3) -->
<div class="bg-surface-container-lowest rounded-xl shadow-2xl relative overflow-hidden flex flex-col border border-outline-variant min-h-[400px]">
<img alt="Hero Preview" class="absolute inset-0 w-full h-full object-cover opacity-20" src="<?= !empty($settings['hero_image'])
? 'uploads/'.$settings['hero_image']
: 'uploads/default-hero.jpg'; ?>"

<div class="relative z-10 flex flex-col items-center justify-center text-center p-margin h-full">
<div class="absolute top-margin left-margin flex items-center gap-stack-xs">
<span class="bg-primary px-stack-sm py-0.5 rounded text-[10px] text-on-primary font-bold uppercase tracking-[0.2em] shadow-lg">Live Preview</span>
</div>
<h4 class="text-on-surface font-headline-lg text-headline-lg max-w-xs mb-stack-sm">
<?= htmlspecialchars($settings['hero_title']) ?>
</h4>
<p class="text-on-surface-variant text-body-md mb-stack-lg max-w-xs">
<?= htmlspecialchars($settings['hero_subtitle']) ?>
</p>
<button class="bg-primary text-on-primary px-stack-lg py-stack-sm rounded-lg font-bold text-label-md shadow-xl hover:scale-105 transition-transform">
<?= htmlspecialchars($settings['hero_button_text']) ?>
</button>
</div>
</div>
</section>

<!-- 5. SEO & Metadata -->
<section class="bg-surface-container border border-outline-variant rounded-xl p-margin">
<div class="flex items-center justify-between mb-margin">
<div class="flex items-center gap-stack-md text-primary">
<span class="material-symbols-outlined" data-icon="manage_search">manage_search</span>
<h3 class="font-headline-sm text-headline-sm">SEO &amp; Metadata</h3>
</div>
<span class="px-stack-md py-stack-xs bg-primary/10 text-primary border border-primary/20 rounded-full font-label-sm">INDEXING: ACTIVE</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-12 gap-margin">
<div class="md:col-span-7 space-y-stack-md">
<div class="space-y-stack-xs">
<label class="font-label-md text-label-md text-outline uppercase">Meta Title</label>
<input
type="text"
name="meta_title"
value="<?= htmlspecialchars($settings['meta_title']) ?>"
class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none">
</div>
<div class="space-y-stack-xs">
<label class="font-label-md text-label-md text-outline uppercase">Meta Description</label>
<textarea
name="meta_description"
rows="3"
class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none"><?= htmlspecialchars($settings['meta_description']) ?></textarea>
</div>
<div class="space-y-stack-xs">
<label class="font-label-md text-label-md text-outline uppercase">Primary Keywords</label>
<input
type="text"
name="meta_keywords"
value="<?= htmlspecialchars($settings['meta_keywords']) ?>"
placeholder="keyword1, keyword2, keyword3"
class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface focus:border-primary outline-none">
</div>
</div>

<div class="flex-grow flex flex-col items-center justify-center border-2 border-dashed border-outline-variant rounded-lg text-outline hover:text-primary hover:border-primary transition-all cursor-pointer bg-surface-container-lowest/50 group">

<input
type="file"
name="og_image"
class="w-full p-4">

</div>

<?php if(!empty($settings['og_image'])){ ?>

<img
src="uploads/<?= $settings['og_image']; ?>"
class="mt-4 rounded-lg border border-outline-variant w-full h-40 object-cover">

<?php } ?>



<!-- Column 2: Sidebar Branding, Security, Admin -->
<div class="col-span-12 lg:col-span-4 space-y-gutter">
<!-- 2. Branding -->
<section class="bg-surface-container border border-outline-variant rounded-xl p-margin">

<div class="flex items-center gap-stack-md text-primary mb-stack-lg">
    <span class="material-symbols-outlined">palette</span>
    <h3 class="font-headline-sm text-headline-sm">Branding Assets</h3>
</div>

<div class="space-y-stack-lg">

    <!-- Logo -->
    <div class="flex items-center justify-between bg-surface-container-low p-stack-md rounded-xl border border-outline-variant">

        <div>
            <span class="font-label-md text-label-md text-outline uppercase block mb-1">
                Corporate Logo
            </span>
            <span class="text-label-sm text-on-surface-variant">
                SVG/PNG supported
            </span>
        </div>

        <label class="w-14 h-14 bg-surface-container-highest rounded-lg border border-outline-variant flex items-center justify-center relative overflow-hidden group cursor-pointer">

            <?php if(!empty($settings['logo'])){ ?>

                <img
                src="uploads/<?php echo $settings['logo']; ?>"
                class="w-full h-full object-cover">

            <?php } else { ?>

                <span class="material-symbols-outlined text-outline">
                    image
                </span>

            <?php } ?>

            <input
            type="file"
            name="logo"
            class="hidden">

        </label>

    </div>

    <!-- Colors -->
    <div class="grid grid-cols-2 gap-stack-md">

        <div class="space-y-stack-xs">

            <label class="font-label-md text-label-md text-outline uppercase">
                Primary Color
            </label>

            <div class="flex items-center gap-stack-md bg-surface-container-lowest p-stack-sm rounded-lg border border-outline-variant">

                <div
                class="w-8 h-8 rounded border border-white/10"
                style="background: <?php echo $settings['primary_color']; ?>;">
                </div>

                <input
                name="primary_color"
                class="bg-transparent text-label-md text-on-surface w-full focus:outline-none"
                type="text"
                value="<?php echo htmlspecialchars($settings['primary_color']); ?>">

            </div>

        </div>

        <div class="space-y-stack-xs">

            <label class="font-label-md text-label-md text-outline uppercase">
                Secondary
            </label>

            <div class="flex items-center gap-stack-md bg-surface-container-lowest p-stack-sm rounded-lg border border-outline-variant">

                <div
                class="w-8 h-8 rounded border border-white/10"
                style="background: <?php echo $settings['secondary_color']; ?>;">
                </div>

                <input
                name="secondary_color"
                class="bg-transparent text-label-md text-on-surface w-full focus:outline-none"
                type="text"
                value="<?php echo htmlspecialchars($settings['secondary_color']); ?>">

            </div>

        </div>

    </div>

    <!-- Favicon -->
    <div class="space-y-stack-xs">

        <label class="font-label-md text-label-md text-outline uppercase">
            Favicon Asset
        </label>

        <div class="flex items-center gap-stack-md bg-surface-container-lowest p-stack-md rounded-lg border border-outline-variant border-dashed">

            <?php if(!empty($settings['favicon'])){ ?>

                <img
                src="uploads/<?php echo $settings['favicon']; ?>"
                class="w-8 h-8 object-cover rounded">

            <?php } else { ?>

                <div class="w-8 h-8 bg-surface-container-highest rounded flex items-center justify-center">
                    <span class="material-symbols-outlined text-[16px]">
                        image
                    </span>
                </div>

            <?php } ?>

            <span class="text-label-sm text-on-surface-variant flex-grow">
                Upload 32x32px ico
            </span>

            <label class="text-primary text-label-md font-bold uppercase hover:underline cursor-pointer">
                Pick
                <input
                type="file"
                name="favicon"
                class="hidden">
            </label>

        </div>

    </div>

</div>

</section>



<!-- 7. Admin Profile -->
<section class="bg-surface-container border border-outline-variant rounded-xl p-margin">

<div class="flex items-center gap-stack-md text-primary mb-stack-lg">
    <span class="material-symbols-outlined">person</span>
    <h3 class="font-headline-sm text-headline-sm">Admin Profile</h3>
</div>

<div class="flex flex-col items-center mb-stack-lg bg-surface-container-low p-stack-md rounded-xl border border-outline-variant">

    <div class="relative group cursor-pointer">

        <img
        alt="Admin Photo"
        class="w-20 h-20 rounded-full border-2 border-primary shadow-lg object-cover"
        src="uploads/<?=
        !empty($_SESSION['profile_image'])
        ? $_SESSION['profile_image']
        : 'default.png';
        ?>">

    </div>

    <h4 class="mt-stack-md font-bold text-on-surface text-body-lg">
        <?php echo $_SESSION['full_name']; ?>
    </h4>

    <p class="text-label-sm text-primary uppercase font-bold tracking-widest">
        <?php echo ucfirst($_SESSION['role']); ?>
    </p>

</div>

<div class="space-y-stack-md">

    <div class="space-y-stack-xs">

        <label class="font-label-md text-label-md text-outline uppercase">
            Full Identity
        </label>

        <input
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface"
        type="text"
        readonly
        value="<?php echo $_SESSION['full_name']; ?>">

    </div>

    <div class="space-y-stack-xs">

        <label class="font-label-md text-label-md text-outline uppercase">
            User Role
        </label>

        <input
        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface"
        type="text"
        readonly
        value="<?php echo ucfirst($_SESSION['role']); ?>">

    </div>

</div>

</section>

<!-- 4. Social Media (with Icons) -->
<section class="bg-surface-container border border-outline-variant rounded-xl p-margin">

    <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-lg">
        Social Integration
    </h3>

    <div class="space-y-stack-sm">

        <!-- Facebook -->
        <div class="flex items-center gap-stack-md bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm">

            <span class="material-symbols-outlined text-[#1877F2]">
                public
            </span>

            <input
            name="facebook"
            class="bg-transparent border-none focus:ring-0 text-body-md text-on-surface w-full p-0"
            placeholder="Facebook URL"
            type="text"
            value="<?php echo htmlspecialchars($settings['facebook']); ?>">

        </div>

        <!-- Instagram -->
        <div class="flex items-center gap-stack-md bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm">

            <span class="material-symbols-outlined text-[#E4405F]">
                photo_camera
            </span>

            <input
            name="instagram"
            class="bg-transparent border-none focus:ring-0 text-body-md text-on-surface w-full p-0"
            placeholder="Instagram URL"
            type="text"
            value="<?php echo htmlspecialchars($settings['instagram']); ?>">

        </div>

        <!-- LinkedIn -->
        <div class="flex items-center gap-stack-md bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm">

            <span class="material-symbols-outlined text-primary">
                share
            </span>

            <input
            name="linkedin"
            class="bg-transparent border-none focus:ring-0 text-body-md text-on-surface w-full p-0"
            placeholder="LinkedIn URL"
            type="text"
            value="<?php echo htmlspecialchars($settings['linkedin']); ?>">

        </div>

        <!-- Twitter/X -->
        <div class="flex items-center gap-stack-md bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm">

            <span class="material-symbols-outlined text-on-surface">
                alternate_email
            </span>

            <input
            name="twitter"
            class="bg-transparent border-none focus:ring-0 text-body-md text-on-surface w-full p-0"
            placeholder="Twitter / X URL"
            type="text"
            value="<?php echo htmlspecialchars($settings['twitter']); ?>">

        </div>

        <!-- YouTube -->
        <div class="flex items-center gap-stack-md bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm">

            <span class="material-symbols-outlined text-[#FF0000]">
                video_library
            </span>

            <input
            name="youtube"
            class="bg-transparent border-none focus:ring-0 text-body-md text-on-surface w-full p-0"
            placeholder="YouTube Channel"
            type="text"
            value="<?php echo htmlspecialchars($settings['youtube']); ?>">

        </div>

    </div>

</section>
<!-- Security Gateway -->
<section class="bg-surface-container border border-outline-variant rounded-xl p-margin shadow-inner">

    <div class="flex items-center gap-stack-md text-primary mb-stack-lg">

        <span class="material-symbols-outlined">
            security
        </span>

        <h3 class="font-headline-sm text-headline-sm">
            Security Gateway
        </h3>

    </div>

    <div class="space-y-stack-md">

        <!-- New Password -->

        <div class="space-y-stack-xs">

            <label class="font-label-md text-label-md text-outline uppercase">
                New Password
            </label>

            <div class="relative">

                <input
                name="new_password"
                class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface pr-10"
                type="password"
                placeholder="Enter new password">

            </div>

        </div>

        <!-- Confirm Password -->

        <div class="space-y-stack-xs">

            <label class="font-label-md text-label-md text-outline uppercase">
                Confirm Password
            </label>

            <div class="relative">

                <input
                name="confirm_password"
                class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-stack-md py-stack-sm text-body-md text-on-surface pr-10"
                type="password"
                placeholder="Confirm password">

            </div>

        </div>

        <!-- Submit -->

        <div class="space-y-stack-xs">

            <button
            type="submit"
            name="update_password"
            class="w-full py-stack-sm border border-primary text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors">

                Update Password

            </button>

        </div>

    </div>

</section>


<!-- 8. Backup & System (Full Width Footer Control Panel) -->
<!-- 8. Backup & System (Full Width Footer Control Panel) -->
<section class="bg-surface-container-high border border-outline-variant rounded-xl p-margin shadow-2xl relative overflow-hidden">

    <div class="absolute top-0 right-0 p-stack-sm">
        <span class="text-[8px] font-label-sm text-outline uppercase tracking-widest opacity-30">
            Infrastructure Control Panel v2.0
        </span>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-gutter border-b border-outline-variant pb-stack-lg mb-stack-lg">

        <div class="flex items-center gap-stack-md text-primary">

            <span class="material-symbols-outlined text-[32px]" data-icon="settings_suggest">
                settings_suggest
            </span>

            <div>

                <h3 class="font-headline-md text-headline-md">
                    System Management
                </h3>

                <p class="text-on-surface-variant text-body-md">
                    Node maintenance and core synchronization utilities.
                </p>

            </div>

        </div>

        <div class="flex gap-stack-md">

            <button
            type="submit"
            name="sync_backup"
            value="1"
            class="bg-surface-container-highest text-on-surface px-stack-lg py-stack-md rounded-xl font-bold flex items-center gap-stack-md hover:brightness-125 transition-all shadow-lg">

                <span class="material-symbols-outlined" data-icon="backup">
                    backup
                </span>

                Sync & Backup

            </button>

            <button
            type="submit"
            name="restore_system"
            value="1"
            class="bg-primary text-on-primary px-stack-lg py-stack-md rounded-xl font-bold flex items-center gap-stack-md hover:scale-105 active:scale-95 transition-all shadow-xl">

                <span class="material-symbols-outlined" data-icon="restore">
                    restore
                </span>

                Node Restore

            </button>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter">

        <!-- Maintenance Mode -->

        <div class="bg-surface-container border border-outline-variant p-stack-md rounded-xl flex items-center justify-between group hover:bg-surface-container-lowest transition-colors">

            <div>

                <div class="font-label-md text-on-surface font-bold">
                    Maintenance Mode
                </div>

                <div class="text-[10px] text-outline uppercase">
                    Offline for node syncing
                </div>

            </div>

            <label class="cursor-pointer">

                <input
                type="checkbox"
                name="maintenance_mode"
                class="hidden"
                <?= !empty($settings['maintenance_mode']) ? 'checked' : ''; ?>>

                <div class="w-10 h-5 rounded-full relative transition-colors
                <?= !empty($settings['maintenance_mode'])
                ? 'bg-primary'
                : 'bg-outline-variant'; ?>">

                    <div class="absolute top-0.5 w-4 h-4 bg-white rounded-full transition-all
                    <?= !empty($settings['maintenance_mode'])
                    ? 'right-0.5'
                    : 'left-0.5'; ?>">
                    </div>

                </div>

            </label>

        </div>

        <!-- Automated Backups -->

        <div class="bg-surface-container border border-outline-variant p-stack-md rounded-xl flex items-center justify-between group hover:bg-surface-container-lowest transition-colors">

            <div>

                <div class="font-label-md text-on-surface font-bold">
                    Automated Backups
                </div>

                <div class="text-[10px] text-primary uppercase">

                    Active:
                    <?= htmlspecialchars(
                        $settings['backup_time'] ?? '04:00'
                    ); ?>

                </div>

            </div>

            <label class="cursor-pointer">

                <input
                type="checkbox"
                name="auto_backup"
                class="hidden"
                <?= !empty($settings['auto_backup']) ? 'checked' : ''; ?>>

                <div class="w-10 h-5 rounded-full relative transition-colors
                <?= !empty($settings['auto_backup'])
                ? 'bg-primary'
                : 'bg-outline-variant'; ?>">

                    <div class="absolute top-0.5 w-4 h-4 bg-white rounded-full transition-all
                    <?= !empty($settings['auto_backup'])
                    ? 'right-0.5'
                    : 'left-0.5'; ?>">
                    </div>

                </div>

            </label>

        </div>

        <!-- Notifications -->

        <div class="bg-surface-container border border-outline-variant p-stack-md rounded-xl flex items-center justify-between group hover:bg-surface-container-lowest transition-colors">

            <div>

                <div class="font-label-md text-on-surface font-bold">
                    System Notifications
                </div>

                <div class="text-[10px] text-primary uppercase">

                    <?= htmlspecialchars(
                        $settings['notification_type']
                        ?? 'Critical Only'
                    ); ?>

                </div>

            </div>

            <label class="cursor-pointer">

                <input
                type="checkbox"
                name="notifications_enabled"
                class="hidden"
                <?= !empty($settings['notifications_enabled']) ? 'checked' : ''; ?>>

                <div class="w-10 h-5 rounded-full relative transition-colors
                <?= !empty($settings['notifications_enabled'])
                ? 'bg-primary'
                : 'bg-outline-variant'; ?>">

                    <div class="absolute top-0.5 w-4 h-4 bg-white rounded-full transition-all
                    <?= !empty($settings['notifications_enabled'])
                    ? 'right-0.5'
                    : 'left-0.5'; ?>">
                    </div>

                </div>

            </label>

        </div>

        <!-- Clear Cache -->

        <div class="flex gap-stack-sm">

            <button
            type="submit"
            name="clear_cache"
            value="1"
            class="flex-grow flex items-center justify-center gap-stack-sm bg-surface-container border border-outline-variant rounded-xl text-label-md text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-all">

                <span class="material-symbols-outlined text-[18px]">
                    cleaning_services
                </span>

                Clear Cache

            </button>

        </div>

    </div>

    <!-- Hidden Fields -->

    <input
    type="hidden"
    name="backup_time"
    value="<?= htmlspecialchars($settings['backup_time'] ?? '04:00'); ?>">

    <input
    type="hidden"
    name="notification_type"
    value="<?= htmlspecialchars($settings['notification_type'] ?? 'Critical Only'); ?>">

</section>
</div>
</form>

<!-- Sticky Save Bar -->
<div class="fixed bottom-0 left-64 right-0 bg-surface/90 backdrop-blur-xl border-t border-outline-variant px-margin py-stack-md flex justify-between items-center z-40 shadow-[0_-10px_20px_-5px_rgba(0,0,0,0.5)]">
<div class="flex items-center gap-stack-md">
<div class="flex items-center gap-stack-sm text-primary">
<span class="material-symbols-outlined animate-pulse" data-icon="cloud_sync">cloud_sync</span>
<span class="font-label-md text-label-md font-bold uppercase tracking-widest">Environment Synced</span>
</div>
<div class="h-4 w-[1px] bg-outline-variant hidden sm:block"></div>
<p class="text-on-surface-variant text-label-sm hidden sm:block">Last integrity check: 2 minutes ago</p>
</div>
<div class="flex gap-stack-md">
<button class="px-stack-lg py-stack-sm border border-outline text-on-surface font-bold rounded-lg hover:bg-surface-container-high transition-all">Discard Pending Changes</button>
<button
type="submit"
name="save_settings"
class="px-stack-xl py-stack-sm bg-primary text-on-primary font-bold rounded-lg">
Save Settings
</button>
</div>
</div>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
    </main>

</div>

</body></html>