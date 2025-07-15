<form action="{{ route('dashboard.inspection.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    {{-- Hidden Equipment Type --}}
    <input type="hidden" name="equipment_type_id" value="{{ $equipmentTypes->firstWhere('name', 'Elevator')->id }}">
    <input type="hidden" name="equipment_type" value="Elevator">

    {{-- Inspector Selection --}}
    <div class="p-5 bg-white rounded-xl shadow-md">
        <label class="block text-sm font-medium text-gray-700">Select Inspector</label>
        <select name="inspector_id"
            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">
            <option value="">-- Select Inspector --</option>
            @foreach ($inspectors as $inspector)
                <option value="{{ $inspector->id }}" {{ old('inspector_id') == $inspector->id ? 'selected' : '' }}>
                    {{ $inspector->name }}
                </option>
            @endforeach
        </select>
        @error('inspector_id')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Equipment Selection --}}
    <div class="p-5 bg-white rounded-xl shadow-md">
        <label class="block text-sm font-medium text-gray-700">Select Elevator Unit</label>
        <select name="equipment_id"
            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">
            <option value="">-- Select Equipment --</option>
            @foreach ($equipments->where('equipment_type_id', $equipmentTypes->firstWhere('name', 'Elevator')->id) as $eq)
                <option value="{{ $eq->id }}" {{ old('equipment_id') == $eq->id ? 'selected' : '' }}>
                    {{ $eq->machine_type }} - {{ $eq->serial_number }}
                </option>
            @endforeach
        </select>
        @error('equipment_id')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Inspection Info --}}
    <div class="p-5 bg-white rounded-xl shadow-md">
        <div class="grid grid-cols-2 gap-4">
            {{-- State ID --}}
            <div>
                <label for="state_id" class="block text-sm font-medium text-gray-700">State ID</label>
                <input type="text" name="state_id" id="state_id" value="{{ old('state_id') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">
                @error('state_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Capacity --}}
            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">
                @error('capacity')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location --}}
            <div class="col-span-2">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <textarea name="location" id="location" rows="2"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">{{ old('location') }}</textarea>
                @error('location')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Inspection Date --}}
            <div>
                <label for="inspection_date" class="block text-sm font-medium text-gray-700">Inspection Date</label>
                <input type="date" name="inspection_date" id="inspection_date" value="{{ old('inspection_date') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">
                @error('inspection_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Inspection Items --}}
    <div class="p-5 bg-white rounded-xl shadow-md">
        <h4 class="text-sm font-semibold mb-3">Inspection Items</h4>
        <div class="grid grid-cols-2 gap-4">
            @php
                $elevatorTypeId = $equipmentTypes->firstWhere('name', 'Elevator')->id;
                $filteredItems = $lists->where('equipment_type_id', $elevatorTypeId);
            @endphp

            @foreach ($filteredItems as $item)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $item->category }}</label>

                    <input type="number" name="lists[{{ $item->id }}][score]" min="0" max="100"
                        value="{{ old("lists.{$item->id}.score") }}"
                        class="block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1"
                        placeholder="Score (0–100)">
                    @error("lists.{$item->id}.score")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <textarea name="lists[{{ $item->id }}][description]" rows="2"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1"
                        placeholder="Description">{{ old("lists.{$item->id}.description") }}</textarea>
                    @error("lists.{$item->id}.description")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>
    </div>

    {{-- Problems --}}
    <div class="mb-4 p-5 bg-white rounded-xl shadow-md">
        <h4 class="text-sm font-semibold text-red-600 mb-3">Problems Found</h4>

        <div class="mb-3">
            <label for="problem_notes" class="block text-sm font-medium text-gray-700">Problem Description</label>
            <textarea name="problem_notes" id="problem_notes" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1"
                placeholder="Describe the problem, if any...">{{ old('problem_notes') }}</textarea>
            @error('problem_notes')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="problem_photos" class="block text-sm font-medium text-gray-700">Problem Photos</label>
            <input type="file" name="problem_photos[]" id="problem_photos" multiple accept="image/*"
                class="mt-1 block w-full text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1">
            @error('problem_photos')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @error('problem_photos.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Submit --}}
    <div class="text-right">
        <button type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow cursor-pointer">
            Submit
        </button>
    </div>
</form>
