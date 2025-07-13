<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Dashboard</x-slot>

    {{-- Bagian User --}}
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['label' => 'Total Users', 'value' => $totalUsers, 'icon' => 'people', 'color' => '#2A7A9F'],
                    [
                        'label' => 'Total Admin',
                        'value' => $totalAdmin,
                        'icon' => 'shield-lock-fill',
                        'color' => 'bg-purple-600',
                    ],
                    [
                        'label' => 'Total Inspectors',
                        'value' => $totalInspectors,
                        'icon' => 'tools',
                        'color' => 'bg-green-600',
                    ],
                    [
                        'label' => 'Total Customers',
                        'value' => $totalCustomers,
                        'icon' => 'person-fill',
                        'color' => 'bg-rose-600',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="p-5 bg-white text-gray-800 rounded-xl shadow-md">
                    <div class="flex items-center justify-between min-w-0">
                        <div class="truncate">
                            <div class="text-sm text-gray-500">{{ $stat['label'] }}</div>
                            <div class="text-3xl font-bold">{{ $stat['value'] }}</div>
                        </div>
                        <div class="w-10 h-10 shrink-0 rounded-full {{ str_contains($stat['color'], '#') ? '' : $stat['color'] }} flex items-center justify-center"
                            style="{{ str_contains($stat['color'], '#') ? 'background-color: ' . $stat['color'] : '' }}">
                            <i class="bi bi-{{ $stat['icon'] }} text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Bagian Alat Berat --}}
    <section class="mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Total Alat Berat per Jenis --}}
            <div class="bg-white rounded-xl shadow-md p-6 self-start">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Total Heavy Equipment per Type</h2>
                <ul class="space-y-2 text-gray-800">
                    <li class="flex justify-between"><span>Excavator</span><span
                            class="font-bold">{{ $totalExcavator }}</span></li>
                    <li class="flex justify-between"><span>Loader</span><span
                            class="font-bold">{{ $totalLoader }}</span></li>
                    <li class="flex justify-between"><span>Elevator</span><span
                            class="font-bold">{{ $totalElevator }}</span></li>
                    <li class="border-t pt-2 flex justify-between font-semibold text-gray-900">
                        <span>Total Unit</span><span>{{ $totalEquipments }}</span>
                    </li>
                </ul>
            </div>

            {{-- Total Alat Berat Rusak --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Total Heavy Equipment Damaged</h2>
                        <div class="text-2xl font-bold text-red-500">{{ $totalDamaged }}</div>
                    </div>
                </div>

                {{-- Tabel --}}
                @if ($damagedEquipments->isNotEmpty())
                    <div class="mt-4 overflow-x-auto bg-white border border-gray-200 rounded-md">
                        <table class="min-w-full text-sm text-gray-800 table-auto">
                            <thead class="bg-gray-100 text-center text-gray-600">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Machine Type</th>
                                    <th class="px-4 py-2">Serial Number</th>
                                    <th class="px-4 py-2">Last Inspection Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($damagedEquipments as $item)
                                    <tr class="hover:bg-blue-50 text-center">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $item['machine_type'] }}</td>
                                        <td class="px-4 py-2">{{ $item['serial_number'] }}</td>
                                        <td class="px-4 py-2">{{ $item['inspection_date'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $damagedEquipments->links('pagination::custom') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>
