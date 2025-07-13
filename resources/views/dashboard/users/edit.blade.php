<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Edit User</x-slot>

    <section class="max-w-2xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('dashboard.user.index') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:underline">
                ← Back to User List
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6">
            <form action="{{ route('dashboard.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Role --</option>
                        <option value="Admin" {{ old('role', $user->role) === 'Admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="Inspector" {{ old('role', $user->role) === 'Inspector' ? 'selected' : '' }}>
                            Inspector</option>
                        <option value="Customer" {{ old('role', $user->role) === 'Customer' ? 'selected' : '' }}>
                            Customer</option>
                    </select>
                    @error('role')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password (Optional) --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password <small>(leave
                            blank if unchanged)</small></label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="text-right">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow cursor-pointer">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>
