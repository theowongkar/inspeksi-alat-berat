<x-guest-layout>

    {{-- Bagian Login --}}
    <section class="fixed inset-0 overflow-hidden bg-cover bg-center flex items-center justify-center"
        style="background-image: url('{{ asset('img/hero-image.webp') }}')">
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

        {{-- Login Card --}}
        <div class="relative z-10 w-full max-w-md px-6">
            <div class="bg-white/95 backdrop-blur-md border border-white/30 rounded-2xl shadow-2xl p-8">

                {{-- Header with Logo Left, Text Right --}}
                <div class="flex items-center justify-center gap-4 mb-5">
                    {{-- Logo --}}
                    <div class="flex-shrink-0">
                        <img src="{{ asset('img/application-logo.webp') }}" alt="Logo Inspeksi Alat Berat"
                            class="h-12 w-12 object-contain">
                    </div>

                    {{-- Title --}}
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 leading-none">
                            Inspeksi Alat Berat
                        </h2>
                        <p class="text-xs text-gray-600 tracking-wide">
                            Sulawesi Utara
                        </p>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required autofocus
                                class="mt-1 w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500 transition">

                            {{-- Icon di tengah --}}
                            <div class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <!-- Input -->
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                class="w-full pl-10 pr-10 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500 transition">

                            <!-- Icon Kunci (Kiri) -->
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                                <i class="bi bi-key"></i>
                            </div>

                            <!-- Icon Mata (Kanan) -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500"
                                @click="show = !show">
                                <template x-if="!show">
                                    <i class="bi bi-eye"></i>
                                </template>
                                <template x-if="show">
                                    <i class="bi bi-eye-slash"></i>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="mr-1">
                            Ingat saya
                        </label>
                        <a href="#" class="text-indigo-600 hover:underline">Lupa password?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-2 px-4 bg-gradient-to-r from-[#2A7A9F] to-[#38B6FF] text-white font-semibold cursor-pointer rounded-lg shadow hover:brightness-110 transition">
                        Login
                    </button>
                </form>

                {{-- Footer --}}
                <p class="text-xs text-center text-gray-400 mt-4">
                    &copy; {{ date('Y') }} Inspeksi Alat Berat. All rights reserved.
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>
