<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | MARITIME CONNECT</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {}
  }
}
</script>

<style>
.material-symbols-outlined {
  font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}
</style>
</head>

<body class="bg-background min-h-screen flex flex-col">

<main class="flex-grow flex flex-col max-w-[480px] mx-auto w-full bg-white shadow-2xl">

<!-- HERO -->
<section class="relative h-[45vh] w-full overflow-hidden">
<img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxuBLMHVwr8OGO_U1Cv6Ioe0OaxslHQJxwPeaW4AtnAMarX9J5B5WO-t7NiqxYfouoWT8gIfAG3bHUg0_OwjNMnQVBJuRMjBra63j_fVciQTXBbq6oAH3sHLhPT9Xd-Gj7sVTpJ8OgWsusLN9Ac1-HIQiuBT0JNJxXjo9jLCekLT97wEhK48_kAs2SEv5PhGBTeLrqVdM56uz0SDgasISL403VDyheqgfr1524pgy2l7yu7cR6A40ONawJU5unw0BA3x5Odnlu5ema"/>

<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex flex-col justify-end p-6 pb-20">
<h1 class="text-white text-2xl font-bold">MARITIME CONNECT</h1>
<p class="text-white/80 text-sm">Precision Logistics for Global Commerce</p>
</div>
</section>

<!-- FORM -->
<section class="flex-grow bg-white -mt-12 relative z-10 rounded-t-[32px] px-6 pt-6 pb-6 shadow-[0_-12px_24px_rgba(0,0,0,0.08)]">

<header class="text-center mb-6">
<h2 class="text-2xl font-semibold text-blue-900">Welcome Back</h2>
<p class="text-sm text-gray-500">Sign in to your vessel dashboard</p>
</header>

<!-- ✅ BACKEND CONNECTED FORM -->
<form class="flex flex-col gap-5" method="POST" action="login.php">

<!-- EMAIL -->
<div>
<label class="text-xs uppercase tracking-widest text-blue-900" for="email">
Email
</label>

<div class="relative mt-1">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
person
</span>

<input
class="w-full pl-10 pr-3 py-3 border rounded-xl focus:ring-2 focus:ring-blue-600 outline-none"
type="email"
id="email"
name="email"
placeholder="e.g. j.doe@connect.com"
required
/>
</div>
</div>

<!-- PASSWORD -->
<div>
<label class="text-xs uppercase tracking-widest text-blue-900" for="password">
Password
</label>

<div class="relative mt-1">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
lock
</span>

<input
class="w-full pl-10 pr-10 py-3 border rounded-xl focus:ring-2 focus:ring-blue-600 outline-none"
type="password"
id="password"
name="password"
placeholder="••••••••"
required
/>

<button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
<span class="material-symbols-outlined">visibility</span>
</button>
</div>
</div>

<!-- OPTIONS -->
<div class="flex justify-between items-center text-sm">
<label class="flex items-center gap-2">
<input type="checkbox" name="remember"/>
<span class="text-gray-500">Remember me</span>
</label>

<a href="#" class="text-blue-700 font-semibold">Forgot password?</a>
</div>

<!-- SUBMIT -->
<button
type="submit"
class="w-full bg-blue-800 text-white py-3 rounded-xl flex justify-center items-center gap-2 hover:bg-blue-900"
>
Login to Dashboard
<span class="material-symbols-outlined">arrow_forward</span>
</button>

</form>

</section>

</main>

</body>
</html>