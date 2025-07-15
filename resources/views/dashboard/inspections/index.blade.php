<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Inspection Data</x-slot>

    <section>
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <a href="{{ route('dashboard.inspection.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow text-center">
                Add Inspection
            </a>

            {{-- Search Filter --}}
            <form method="GET" action="{{ route('dashboard.inspection.index') }}"
                class="w-full max-w-2xl flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 mb-4">

                {{-- Equipment Type Filter --}}
                <select name="equipment_type"
                    class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none">
                    <option value="">All Types</option>
                    @foreach ($equipmentTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ request('equipment_type') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Search --}}
                <div
                    class="flex w-full md:flex-grow focus-within:ring-2 focus-within:ring-blue-500 rounded-lg shadow-sm border border-gray-300 overflow-hidden">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by serial number or inspector name..." autocomplete="off"
                        class="flex-grow px-4 py-2 focus:outline-none">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium cursor-pointer">
                        Search
                    </button>
                </div>
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
                        <th class="px-4 py-3 text-left">Equipment Type</th>
                        <th class="px-4 py-3 text-left">Serial Number</th>
                        <th class="px-4 py-3 text-left">Inspector</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Location</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($inspections as $inspection)
                        <tr class="hover:bg-blue-50">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $inspection->equipmentType->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $inspection->equipment->serial_number ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $inspection->inspector->name ?? '-' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2">{{ $inspection->location }}</td>
                            <td class="px-4 py-2 text-center space-x-2 whitespace-nowrap">
                                <a href="{{ route('dashboard.inspection.show', $inspection->id) }}"
                                    class="text-blue-600 hover:underline">Show</a>
                                <form action="{{ route('dashboard.inspection.destroy', $inspection->id) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this inspection?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 cursor-pointer hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">No inspections available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $inspections->links('pagination::custom') }}
        </div>
    </section>

</x-app-layout>
