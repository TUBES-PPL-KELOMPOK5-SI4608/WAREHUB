<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Manajemen Gudang' }}</title>

    <!-- Tailwind CSS & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Noto Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FBFAF5] text-gray-800 h-screen overflow-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#74512D] text-white flex flex-col p-4">
            <div class="mb-10">
                <h2 class="text-xl font-bold">WareHub</h2>
            </div>
            <nav class="space-y-2">
                <a href="/admin/dashboard" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/dashboard') ? 'bg-[#FEBA17] font-semibold' : '' }}">🏠 Dashboard</a>
                <a href="{{ route('barangs.index') }}" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/barangs*') ? 'bg-[#FEBA17] font-semibold' : '' }}">📦 Inventory</a>
                <a href="/admin/barang/out" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/barang/out') ? 'bg-[#FEBA17] font-semibold' : '' }}">📤 Barang Keluar</a>
                <a href="/admin/returs" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/returs') ? 'bg-[#FEBA17] font-semibold' : '' }}">🛠️ Catatan Kerusakan</a>
                <a href="/admin/notifikasi" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/notifikasi') ? 'bg-[#FEBA17] font-semibold' : '' }}">🕘 Riwayat Perubahan</a>
                <a href="/admin/barang/minimum" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/barang/minimum') ? 'bg-[#FEBA17] font-semibold' : '' }}">📉 Batas Stok Minimum</a>
                <a href="/admin/vendors" class="block py-2 px-4 rounded hover:bg-[#FEBA17] {{ request()->is('admin/vendors*') ? 'bg-[#FEBA17] font-semibold' : '' }}">🏭 Data Supplier</a>
            </nav>

            <div class="space-y-2 pt-10 border-t border-white/30 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2 px-4 rounded hover:bg-[#FEBA17] text-white">🚪 Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-[#74512D] text-white px-6 py-4 shadow flex justify-between items-center">
                <h1 class="text-lg font-semibold">Halo, {{ $user->username ?? 'Pengguna' }}</h1>
                <div class="space-x-5">
                    <a href="/admin/notifikasi">
                        <i class="fas fa-bell"></i>
                    </a>
                    <span id="current-date-time" class="text-sm"></span>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long', year: 'numeric', month: 'long',
                day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'
            };
            document.getElementById('current-date-time').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>
</html>
