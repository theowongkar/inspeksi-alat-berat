<x-app-layout>
    
    <x-slot name="title">Create Inspection</x-slot>

    <section x-data="{ selectedType: '{{ old('equipment_type') }}' || null }" class="grid grid-cols-1 gap-3">
        @php
            $iconMap = [
                'Excavator' => [
                    'color' => 'text-yellow-600',
                    'svg' => '<path d="M3 13h2l1 5h11l1-5h2M5 18h14M9 6h6m-3 0v12" />',
                ],
                'Loader' => [
                    'color' => 'text-blue-600',
                    'svg' => '<path d="M5 13l4 4L19 7" />',
                ],
                'Elevator' => [
                    'color' => 'text-green-600',
                    'svg' => '<path d="M12 2v20m0-20l4 4m-4-4l-4 4" />',
                ],
            ];

            $descriptionMap = [
                'Excavator' => 'Heavy equipment used for digging and demolition tasks.',
                'Loader' => 'Ideal for loading materials into trucks and transporting debris.',
                'Elevator' => 'Vertical transport system for people or goods in buildings.',
            ];
        @endphp

        {{-- STEP 1: Pilih tipe alat berat, hanya tampil jika belum dipilih --}}
        <template x-if="!selectedType">
            <div class="grid grid-cols-1 gap-3">
                @foreach ($equipmentTypes as $type)
                    <div @click="selectedType = '{{ $type->name }}'"
                        class="flex items-start gap-4 cursor-pointer p-4 bg-white text-gray-800 rounded-xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-150"
                        :class="{ 'ring-2 ring-offset-2 ring-indigo-500': selectedType === '{{ $type->name }}' }">

                        {{-- Icon --}}
                        <div class="flex-shrink-0">
                            @if (isset($iconMap[$type->name]))
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 {{ $iconMap[$type->name]['color'] }}" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $iconMap[$type->name]['svg'] !!}
                                </svg>
                            @endif
                        </div>

                        {{-- Title & Description --}}
                        <div class="flex flex-col">
                            <h3 class="text-base font-semibold mb-1">{{ $type->name }}</h3>
                            <p class="text-sm text-gray-600 leading-snug">
                                {{ $descriptionMap[$type->name] ?? 'No description available.' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </template>

        {{-- STEP 2: Tampilkan form berdasarkan pilihan --}}
        <div x-show="selectedType === 'Excavator'" x-transition>
            @include('dashboard.inspections.partials.excavator-form')
        </div>

        <div x-show="selectedType === 'Loader'" x-transition>
            @include('dashboard.inspections.partials.loader-form')
        </div>

        <div x-show="selectedType === 'Elevator'" x-transition>
            @include('dashboard.inspections.partials.elevator-form')
        </div>
    </section>

</x-app-layout>
