<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total User Berdasarkan Role
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'Admin')->count();
        $totalInspectors = User::where('role', 'Inspector')->count();
        $totalCustomers = User::where('role', 'Customer')->count();

        // Total Alat Berat per Jenis
        $totalExcavator = Equipment::whereHas('equipmentType', fn($q) => $q->where('name', 'Excavator'))->count();
        $totalLoader    = Equipment::whereHas('equipmentType', fn($q) => $q->where('name', 'Loader'))->count();
        $totalElevator  = Equipment::whereHas('equipmentType', fn($q) => $q->where('name', 'Elevator'))->count();
        $totalEquipments = $totalExcavator + $totalLoader + $totalElevator;

        // Alat Berat Rusak: Filter Berdasarkan Rata-rata Score Inspeksi < 75
        $rawDamagedEquipments = Equipment::with(['inspections.items'])
            ->get()
            ->filter(function ($equipment) {
                $scores = $equipment->inspections->flatMap->items->pluck('score');
                return $scores->isNotEmpty() && $scores->avg() < 75;
            })
            ->map(function ($equipment) {
                $latestInspection = $equipment->inspections->sortByDesc('inspection_date')->first();

                return [
                    'machine_type'       => $equipment->machine_type,
                    'serial_number'      => $equipment->serial_number,
                    'inspection_date'    => optional($latestInspection)?->inspection_date
                        ? Carbon::parse($latestInspection->inspection_date)->format('d M Y')
                        : '-',
                    'inspection_date_raw' => optional($latestInspection)?->inspection_date // untuk sorting
                ];
            })
            ->sortByDesc('inspection_date_raw')
            ->values();

        // Manual Pagination: 5 item per halaman
        $perPage = 5;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $damagedEquipments = new LengthAwarePaginator(
            $rawDamagedEquipments->slice($offset, $perPage)->values(),
            $rawDamagedEquipments->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard.index', [
            // Total user
            'totalUsers'      => $totalUsers,
            'totalAdmin'      => $totalAdmin,
            'totalInspectors' => $totalInspectors,
            'totalCustomers'  => $totalCustomers,

            // Total alat berat
            'totalExcavator'  => $totalExcavator,
            'totalLoader'     => $totalLoader,
            'totalElevator'   => $totalElevator,
            'totalEquipments' => $totalEquipments,

            // Alat berat rusak
            'totalDamaged'        => $rawDamagedEquipments->count(),
            'damagedEquipments'   => $damagedEquipments,
        ]);
    }
}
