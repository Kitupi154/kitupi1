<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Customer Registration | MARITIME CONNECT</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

<style>
body{
    background:#f6f9ff;
    font-family: Arial, sans-serif;
}

.material-symbols-outlined{
    font-variation-settings:
    'FILL' 0,
    'wght' 400,
    'GRAD' 0,
    'opsz' 24;
}
</style>

</head>
<body class="min-h-screen flex items-center justify-center p-4 relative">

<!-- HERO BACKGROUND -->
<div class="bg-white shadow-2xl rounded-3xl overflow-hidden w-full max-w-4xl grid md:grid-cols-2">

    <!-- LEFT HERO SECTION -->
    <div class="relative hidden md:block">

        <!-- HERO IMAGE -->
        <img src="https://images.unsplash.com/photo-1501700493788-fa1a4fc9fe62?w=1200"
             class="h-full w-full object-cover">

        <!-- DARK OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/70 via-blue-900/50 to-black/70"></div>

        <!-- HERO CONTENT -->
        <div class="absolute inset-0 flex flex-col justify-end p-8 text-white">
            <h1 class="text-3xl font-bold tracking-wide">
                MARITIME CONNECT
            </h1>

            <p class="text-sm opacity-90 mt-2">
                Smart Shipping & Customer Registration Portal
            </p>

            <div class="mt-6 flex items-center gap-2 text-xs opacity-80">
                <span class="material-symbols-outlined text-sm">sailing</span>
                <span>Track • Register • Manage Shipments</span>
            </div>
        </div>
    </div>

    <!-- RIGHT FORM SECTION (your existing code stays unchanged) -->
    <div class="p-8 bg-white">

        <form action="register.php" method="POST" enctype="multipart/form-data" class="space-y-4">

        <div class="mb-6">
    <h2 class="text-3xl font-bold text-blue-900">
        Register Your Account Now
    </h2>

    <p class="text-gray-500 mt-1">
        Create a customer account for your privellages
    </p>
</div>
            <!-- Full Name -->
            <div>
                <label class="font-semibold">Full Name</label>

                <input
                type="text"
                name="full_name"
                required
                class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
                placeholder="Enter full name">
            </div>

            <!-- Email -->
            <div>
                <label class="font-semibold">Email</label>

                <input
                type="email"
                name="email"
                required
                class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
                placeholder="Enter email">
            </div>

            <!-- Phone -->
            <div>
                <label class="font-semibold">Phone</label>

                <input
                type="text"
                name="phone"
                required
                class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
                placeholder="+255...">
            </div>

            <!-- Password -->
            <div>
                <label class="font-semibold">Password</label>

                <input
                type="password"
                name="password"
                required
                class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
                placeholder="Create password">
            </div>

<!-- Address -->
<div>
    <label class="font-semibold">Address</label>

    <textarea
        name="address"
        class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
        placeholder="Example: Kariakoo, Dar es Salaam"
        required>
    </textarea>

    <small class="text-gray-400">
        Enter your location (e.g. Kariakoo, Dar es Salaam)
    </small>
</div>

            <!-- Company Name -->
            <div>
                <label class="font-semibold">Company Name</label>

                <input
                type="text"
                name="company_name"
                class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
                placeholder="Optional">
            </div>

            <!-- ID Number -->
     
<div>
    <label class="font-semibold">ID Number</label>

    <input
        type="text"
        name="id_number"
        class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
        placeholder="Example: NIDA: 12345678-0001 or Passport No: A1234567"
        required
    />

    <small class="text-gray-400">
        Enter National ID (NIDA) or Passport number.
    </small>
</div>
            <!-- Nationality -->
           
<div>
    <label class="font-semibold">Nationality</label>

    <select
        name="nationality"
        class="w-full border rounded-xl p-3 mt-1 outline-none focus:ring-2 focus:ring-blue-700"
        required>

        <option value="">Select nationality</option>
        <option>Tanzania</option>
        <option>Kenya</option>
        <option>Uganda</option>
        <option>Rwanda</option>
        <option>Burundi</option>
    

    </select>
</div>

            <!-- Profile Photo -->
            <div>
                <label class="font-semibold">
                    Profile Photo
                </label>

                <input
                type="file"
                name="profile_photo"
                class="w-full border rounded-xl p-3 mt-1">
            </div>

            <button
            type="submit"
            class="w-full bg-blue-900 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">

                Register Customer

            </button>

        </form>

        <p class="text-center text-gray-500 mt-4">
            Already have account?

           <a href="../registrations/login1.php" class="text-blue-900 font-bold">
                Login
            </a>
        </p>

    </div>

</div>

</body>
</html>