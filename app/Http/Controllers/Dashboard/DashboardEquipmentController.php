<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentType;
use App\Http\Controllers\Controller;

class DashboardEquipmentController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'equipment_type' => 'nullable|integer|exists:equipment_types,id',
        ]);

        // Ambil data validasi search
        $search = $validated['search'] ?? null;
        $typeId = $validated['equipment_type'] ?? null;

        // Query Alat Berat
        $equipments = Equipment::with('equipmentType')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('serial_number', 'like', "%{$search}%")
                        ->orWhere('make', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%");
                });
            })
            ->when($typeId, function ($query, $typeId) {
                $query->where('equipment_type_id', $typeId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        // Ambil Tipe Alat Berat
        $equipmentTypes = EquipmentType::all();

        return view('dashboard.equipments.index', compact('equipments', 'equipmentTypes'));
    }

    public function create()
    {
        // Ambil Tipe Alat Berat
        $equipmentTypes = EquipmentType::orderBy('name')->get();

        return view('dashboard.equipments.create', compact('equipmentTypes'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'machine_type'      => 'required|string|max:100',
            'serial_number'     => 'required|string|max:100|unique:equipments,serial_number',
            'make'              => 'required|string|max:100',
            'model'             => 'required|string|max:100',
            'year'              => 'required|digits:4|integer|min:1950|max:' . date('Y'),
        ]);

        // Simpan Alat Berat
        Equipment::create($validated);

        return redirect()->route('dashboard.equipment.index')->with('success', 'Equipment successfully added.');
    }

    public function edit(string $id)
    {
        // Ambil Alat Berat
        $equipment = Equipment::findOrFail($id);

        // Ambil Tipe Alat Berat
        $equipmentTypes = EquipmentType::orderBy('name')->get();

        return view('dashboard.equipments.edit', compact('equipment', 'equipmentTypes'));
    }

    public function update(Request $request, string $id)
    {
        // Ambil Alat Berat
        $equipment = Equipment::findOrFail($id);

        // Validasi Input
        $validated = $request->validate([
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'machine_type'      => 'required|string|max:100',
            'serial_number'     => 'required|string|max:100|unique:equipments,serial_number,' . $equipment->id,
            'make'              => 'required|string|max:100',
            'model'             => 'required|string|max:100',
            'year'              => 'required|digits:4|integer|min:1950|max:' . date('Y'),
        ]);

        // Update Alat Berat
        $equipment->update($validated);

        return redirect()->route('dashboard.equipment.index')->with('success', 'Equipment successfully updated.');
    }

    public function destroy(string $id)
    {
        // Ambil Alat Berat
        $equipment = Equipment::findOrFail($id);

        // Hapus Alat Berat
        $equipment->delete();

        return redirect()->route('dashboard.equipment.index')->with('success', 'Equipment successfully deleted.');
    }
}
