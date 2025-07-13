<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">User Data</x-slot>

    <section>
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            {{-- Tombol Tambah --}}
            <a href="{{ route('dashboard.user.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow text-center">
                Add User
            </a>

            {{-- Form Search --}}
            <form method="GET" action="{{ route('dashboard.user.index') }}"
                class="w-full md:w-1/3 flex focus-within:ring-2 focus-within:ring-blue-500 rounded-lg shadow-sm overflow-hidden border border-gray-300">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..." autocomplete="off"
                    class="flex-grow px-4 py-2 focus:outline-none">

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium cursor-pointer focus:outline-none">
                    Search
                </button>
            </form>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div
                class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 text-sm rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 text-sm rounded-lg shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl shadow-md">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-[#2A7A9F] text-xs text-white uppercase tracking-wide">
                    <tr>
                        <th class="px-2 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-center">Role</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-blue-50">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 font-medium">{{ Str::limit($user->name, 25, '...') }}</td>
                            <td class="px-4 py-2">{{ Str::limit($user->email, 35, '...') }}</td>
                            <td class="px-4 py-2 text-center whitespace-nowrap">
                                @php
                                    $roleColors = [
                                        'Admin' => 'bg-purple-200 text-purple-800',
                                        'Inspector' => 'bg-green-200 text-green-800',
                                        'Customer' => 'bg-rose-200 text-rose-800',
                                    ];
                                @endphp

                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center space-x-2 whitespace-nowrap">
                                <a href="{{ route('dashboard.user.edit', $user->id) }}"
                                    class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 cursor-pointer hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No users available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->links('pagination::custom') }}
        </div>
    </section>

</x-app-layout>
