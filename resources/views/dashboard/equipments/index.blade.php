<x-app-layout>

    {{-- Page Title --}}
    <x-slot name="title">Equipment Data</x-slot>

    <section>
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            {{-- Add Equipment Button --}}
            <a href="{{ route('dashboard.equipment.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow text-center">
                Add Heavy Equipment
            </a>

            {{-- Search & Filter Form --}}
            <form method="GET" action="{{ route('dashboard.equipment.index') }}"
                class="w-full max-w-2xl flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 mb-4">

                {{-- Select Equipment Type --}}
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

                {{-- Search Input & Button --}}
                <div
                    class="flex w-full md:flex-grow focus-within:ring-2 focus-within:ring-blue-500 rounded-lg shadow-sm border border-gray-300 overflow-hidden">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by serial number or brand..." autocomplete="off"
                        class="flex-grow px-4 py-2 focus:outline-none">

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium cursor-pointer focus:outline-none">
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
                        <th class="px-4 py-3 text-left">Machine Type</th>
                        <th class="px-4 py-3 text-left">Serial Number</th>
                        <th class="px-4 py-3 text-left">Make</th>
                        <th class="px-4 py-3 text-left">Model</th>
                        <th class="px-4 py-3 text-center">Year</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($equipments as $equipment)
                        <tr class="hover:bg-blue-50">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $equipment->equipmentType->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $equipment->machine_type }}</td>
                            <td class="px-4 py-2">{{ $equipment->serial_number }}</td>
                            <td class="px-4 py-2">{{ $equipment->make }}</td>
                            <td class="px-4 py-2">{{ $equipment->model }}</td>
                            <td class="px-4 py-2 text-center">{{ $equipment->year }}</td>
                            <td class="px-4 py-2 text-center space-x-2 whitespace-nowrap">
                                <a href="{{ route('dashboard.equipment.edit', $equipment->id) }}"
                                    class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('dashboard.equipment.destroy', $equipment->id) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this equipment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 cursor-pointer hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">No equipment available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $equipments->links('pagination::custom') }}
        </div>
    </section>

</x-app-layout>
