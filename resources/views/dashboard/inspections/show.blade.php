<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Inspection Detail</x-slot>

    <section>
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('dashboard.inspection.index') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:underline">
                ← Back to Inspection List
            </a>
        </div>

        {{-- Grid 2 kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- KIRI: Informasi Inspeksi --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 space-y-4 self-start">
                <h2 class="text-lg font-semibold text-gray-800">Inspection Information</h2>

                <div class="grid grid-cols-1 gap-3 text-sm text-gray-700">
                    {{-- Item --}}
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Equipment Type:</div>
                        <div class="text-right">{{ $inspection->equipmentType->name ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Inspector:</div>
                        <div class="text-right">{{ $inspection->inspector->name ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Serial Number:</div>
                        <div class="text-right">{{ $inspection->equipment->serial_number ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Machine Type:</div>
                        <div class="text-right">{{ $inspection->equipment->machine_type ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Make:</div>
                        <div class="text-right">{{ $inspection->equipment->make ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Model:</div>
                        <div class="text-right">{{ $inspection->equipment->model ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Year:</div>
                        <div class="text-right">{{ $inspection->equipment->year ?? '-' }}</div>
                    </div>

                    <div class="border"></div>

                    {{-- Conditional --}}
                    @if ($inspection->info)
                        @if ($inspection->equipmentType->name === 'Elevator')
                            <div class="grid grid-cols-[150px_1fr]">
                                <div class="font-medium text-left">State ID:</div>
                                <div class="text-right">{{ $inspection->info->state_id ?? '-' }}</div>
                            </div>
                            <div class="grid grid-cols-[150px_1fr]">
                                <div class="font-medium text-left">Capacity:</div>
                                <div class="text-right">{{ $inspection->info->capacity ?? '-' }}</div>
                            </div>
                        @else
                            <div class="grid grid-cols-[150px_1fr]">
                                <div class="font-medium text-left">Report No:</div>
                                <div class="text-right">{{ $inspection->info->report_no ?? '-' }}</div>
                            </div>
                            <div class="grid grid-cols-[150px_1fr]">
                                <div class="font-medium text-left">Hour Reading:</div>
                                <div class="text-right">{{ $inspection->info->hour_reading ?? '-' }}</div>
                            </div>
                        @endif
                    @endif

                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Date:</div>
                        <div class="text-right">
                            {{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d F Y') }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_1fr]">
                        <div class="font-medium text-left">Location:</div>
                        <div class="text-right">{{ $inspection->location }}</div>
                    </div>

                    {{-- Export Button --}}
                    @can('export', $inspection)
                        <div class="flex justify-between md:justify-end gap-2">
                            <a href="{{ route('dashboard.inspection.export-pdf', $inspection->id) }}" target="__BLANK"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow cursor-pointer">
                                <i class="bi bi-filetype-pdf"></i>
                                PDF
                            </a>
                            <a href="{{ route('dashboard.inspection.export-excel', $inspection->id) }}"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow cursor-pointer">
                                <i class="bi bi-filetype-xlsx"></i>
                                EXCEL
                            </a>
                        </div>
                    @endcan
                </div>
            </div>

            {{-- KANAN: Item & Problem --}}
            <div class="space-y-6">
                {{-- Items --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Inspection Items</h2>

                    @php
                        $totalScore = $inspection->items->sum('score');
                        $itemCount = $inspection->items->count();
                        $averageScore = $itemCount > 0 ? round($totalScore / $itemCount, 2) : 0;
                        $isWorthy = $averageScore >= 75;
                    @endphp

                    @forelse ($inspection->items as $item)
                        <div class="py-2 border-b">
                            <div class="font-medium text-sm text-gray-800">{{ $item->equipmentTypeItem->category }}
                            </div>
                            <div class="text-sm text-gray-600">Score: <strong>{{ $item->score }}</strong></div>
                            <div class="text-sm text-gray-600">Description: {{ $item->description }}</div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No inspection items.</p>
                    @endforelse

                    {{-- Rata-rata & Badge Status --}}
                    @if ($itemCount > 0)
                        <div class="mt-2">
                            <div class="text-sm text-gray-700">
                                <strong>Rata-rata Skor:</strong> {{ $averageScore }}
                            </div>

                            <div class="mt-2 inline-flex items-center gap-2 text-xs font-semibold">

                                {{-- Layak --}}
                                <span
                                    class="px-3 py-1 rounded-full border
                    {{ $isWorthy ? 'bg-green-100 text-green-800 border-green-300' : 'line-through text-gray-400 border-gray-300' }}">
                                    Layak Beroperasi
                                </span>

                                {{-- Tidak Layak --}}
                                <span
                                    class="px-3 py-1 rounded-full border
                    {{ !$isWorthy ? 'bg-red-100 text-red-800 border-red-300' : 'line-through text-gray-400 border-gray-300' }}">
                                    Tidak Layak Beroperasi
                                </span>

                            </div>
                        </div>
                    @endif
                </div>

                {{-- Problems --}}
                @if ($inspection->problems->count())
                    <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 space-y-4">
                        <h2 class="text-lg font-semibold text-red-700">Problems / Repairs</h2>
                        @foreach ($inspection->problems as $problem)
                            <div class="space-y-2">
                                <div class="text-sm text-gray-700">{{ $problem->notes }}</div>
                                @if ($problem->photos->count())
                                    <div class="grid grid-cols-2 gap-3 mt-2">
                                        @foreach ($problem->photos as $photo)
                                            <img src="{{ $photo->photo_url ? asset('storage/' . $photo->photo_url) : asset('storage/sample/placeholder.webp') }}"
                                                class="w-full h-32 object-cover rounded border" alt="Problem Photo">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>
