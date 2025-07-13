<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Edit Equipment</x-slot>

    <section class="max-w-3xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('dashboard.equipment.index') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:underline">
                ← Back to Equipment List
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6">
            <form action="{{ route('dashboard.equipment.update', $equipment->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Equipment Type --}}
                <div class="mb-4">
                    <label for="equipment_type_id" class="block text-sm font-medium text-gray-700">Equipment Type</label>
                    <select name="equipment_type_id" id="equipment_type_id" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Equipment Type --</option>
                        @foreach ($equipmentTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('equipment_type_id', $equipment->equipment_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipment_type_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Machine Type --}}
                <div class="mb-4">
                    <label for="machine_type" class="block text-sm font-medium text-gray-700">Machine Type</label>
                    <input type="text" name="machine_type" id="machine_type"
                        value="{{ old('machine_type', $equipment->machine_type) }}" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('machine_type')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Serial Number --}}
                <div class="mb-4">
                    <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number"
                        value="{{ old('serial_number', $equipment->serial_number) }}" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('serial_number')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Make --}}
                <div class="mb-4">
                    <label for="make" class="block text-sm font-medium text-gray-700">Make</label>
                    <input type="text" name="make" id="make" value="{{ old('make', $equipment->make) }}"
                        required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('make')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Model --}}
                <div class="mb-4">
                    <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model" id="model" value="{{ old('model', $equipment->model) }}"
                        required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('model')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Year --}}
                <div class="mb-6">
                    <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                    <input type="number" name="year" id="year" min="1950" max="{{ date('Y') }}"
                        value="{{ old('year', $equipment->year) }}" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('year')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="text-right">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow cursor-pointer">
                        Update Equipment
                    </button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>
