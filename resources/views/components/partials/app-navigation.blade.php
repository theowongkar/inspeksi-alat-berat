{{-- Overlay --}}
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 transition-opacity md:hidden"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
</div>

{{-- Sidebar --}}
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-[#2A7A9F] text-white md:translate-x-0 md:static md:inset-0 flex flex-col shadow-xl">

    {{-- Header Sidebar --}}
    <div class="px-4 py-4 flex items-center space-x-3">
        <img src="{{ asset('img/application-logo.webp') }}" alt="Logo Inspeksi Alat Berat" class="w-12 h-12 shrink-0">
        <div class="flex flex-col">
            <h3 class="text-sm font-semibold leading-tight uppercase">Inspeksi Alat Berat</h3>
            <span class="text-xs">Sulawesi Utara</span>
        </div>
    </div>

    {{-- Navigasi --}}
    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-4">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-[#38B6FF] {{ Route::is('dashboard') ? 'bg-[#38B6FF]' : '' }}">
            <i class="bi bi-house-door-fill"></i>
            <span class="text-sm font-bold">Dashboard</span>
        </a>

        {{-- Data Pengguna --}}
        <a href="{{ route('dashboard.user.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-[#38B6FF] {{ Route::is('dashboard.user.*') ? 'bg-[#38B6FF]' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span class="text-sm font-bold">User Data</span>
        </a>

        {{-- Data Alat Berat --}}
        <a href="{{ route('dashboard.equipment.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-[#38B6FF] {{ Route::is('dashboard.equipment.*') ? 'bg-[#38B6FF]' : '' }}">
            <i class="bi bi-gear-wide-connected"></i>
            <span class="text-sm font-bold">Heavy Equipment</span>
        </a>

        {{-- Data Inspeksi --}}
        <a href="{{ route('dashboard.inspection.index') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-[#38B6FF] {{ Route::is(['dashboard.inspection.index', 'dashboard.inspection.show']) ? 'bg-[#38B6FF]' : '' }}">
            <i class="bi bi-archive-fill"></i>
            <span class="text-sm font-bold">Inspection History</span>
        </a>

        {{-- Buat Inspeksi --}}
        <a href="{{ route('dashboard.inspection.create') }}"
            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-[#38B6FF] {{ Route::is('dashboard.inspection.create') ? 'bg-[#38B6FF]' : '' }}">
            <i class="bi bi-ui-checks"></i>
            <span class="text-sm font-bold">Create Inspection</span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left flex items-center space-x-3 px-4 py-2 rounded hover:bg-[#38B6FF] text-red-200 cursor-pointer hover:text-white transition">
                <i class="bi bi-box-arrow-right"></i>
                <span class="text-sm font-bold">Logout</span>
            </button>
        </form>
    </nav>
</div>
