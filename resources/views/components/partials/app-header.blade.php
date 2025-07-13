{{-- Header --}}
<header class="h-18 flex items-center justify-between px-6 bg-[#2A7A9F] text-white shadow-xl">
    <div class="flex items-center">
        <button class="md:hidden" @click="sidebarOpen = true">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list mr-4"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
        </button>
        <h1 class="font-bold">{{ $title ?? 'Dashboard' }}</h1>
    </div>
    <div class="flex items-center">
        <span class="text-sm">Hi, {{ Str::limit(Auth::user()->name, 10, '...') }}</span>
    </div>
</header>
