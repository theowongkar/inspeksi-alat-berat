<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Equipment;
use App\Models\Inspection;
use Illuminate\Http\Request;
use App\Models\EquipmentType;
use App\Models\InspectionInfo;
use App\Models\InspectionItem;
use App\Models\InspectionPhoto;
use App\Models\EquipmentTypeItem;
use App\Models\InspectionProblem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DashboardInspectionController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'equipment_type' => 'nullable|integer|exists:equipment_types,id',
        ]);

        // Ambil data validasi
        $search = $validated['search'] ?? null;
        $typeId = $validated['equipment_type'] ?? null;

        // Query Inspeksi
        $inspections = Inspection::with(['equipmentType', 'equipment', 'inspector'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('equipment', fn($eq) =>
                    $eq->where('serial_number', 'like', "%{$search}%")
                        ->orWhere('make', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%"))
                        ->orWhereHas('inspector', fn($iq) =>
                        $iq->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($typeId, function ($query, $typeId) {
                $query->where('equipment_type_id', $typeId);
            })
            ->orderBy('inspection_date', 'desc')
            ->paginate(10)
            ->appends($request->query());

        // Ambil Tipe Alat Berat
        $equipmentTypes = EquipmentType::all();

        return view('dashboard.inspections.index', compact('inspections', 'equipmentTypes'));
    }

    public function create(Request $request)
    {
        Gate::authorize('create', Inspection::class);

        $equipmentTypes = EquipmentType::all();
        $equipments = Equipment::all();
        $inspectors = User::where('role', 'Inspector')->get();
        $lists = EquipmentTypeItem::all();

        return view('dashboard.inspections.create', compact(
            'equipmentTypes',
            'equipments',
            'inspectors',
            'lists'
        ));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Inspection::class);

        // Validasi Input
        $validated = $request->validate([
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'equipment_type'    => 'required|string',
            'equipment_id'      => 'required|exists:equipments,id',
            'inspector_id'      => 'required|exists:users,id',
            'inspection_date' => 'required|date',
            'location' => 'required|string|max:255',

            // Info tambahan tergantung jenis alat
            'report_no' => 'nullable|string|max:100',
            'hour_reading' => 'nullable|integer|min:0',
            'state_id'          => 'nullable|string|max:255',
            'capacity'          => 'nullable|numeric|min:1',

            'lists' => 'required|array',
            'lists.*.score' => 'required|integer|min:0|max:100',
            'lists.*.description' => 'required|string|max:1000',

            'problem_notes' => 'nullable|string',
            'problem_photos' => 'nullable|array|max:6',
            'problem_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Simpan inspeksi utama
            $inspection = Inspection::create([
                'equipment_id' => $request->equipment_id,
                'inspector_id' => $request->inspector_id,
                'equipment_type_id' => $request->equipment_type_id,
                'inspection_date' => $request->inspection_date,
                'location' => $request->location,
            ]);

            // Simpan inspection_info
            InspectionInfo::create([
                'inspection_id' => $inspection->id,
                'report_no' => $request->report_no,
                'hour_reading' => $request->hour_reading,
                'state_id' => $request->state_id,
                'capacity' => $request->capacity,
            ]);

            // Simpan item inspeksi
            foreach ($request->lists as $equipment_type_item_id => $data) {
                InspectionItem::create([
                    'inspection_id' => $inspection->id,
                    'equipment_type_item_id' => $equipment_type_item_id,
                    'score' => $data['score'],
                    'description' => $data['description'],
                ]);
            }

            // Simpan problem & foto jika ada
            if ($request->filled('problem_notes') || $request->hasFile('problem_photos')) {
                $problem = InspectionProblem::create([
                    'inspection_id' => $inspection->id,
                    'notes' => $request->problem_notes,
                ]);

                if ($request->hasFile('problem_photos')) {
                    foreach ($request->file('problem_photos') as $photo) {
                        $path = $photo->store('inspection_photos', 'public');
                        InspectionPhoto::create([
                            'inspection_problem_id' => $problem->id,
                            'photo_url' => $path,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('dashboard.inspection.index')->with('success', 'Inspection created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.inspection.index')->with('error', [
                'message' => 'Failed to create inspection.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show(string $id)
    {
        $inspection = Inspection::with([
            'equipmentType',
            'equipment',
            'inspector',
            'info',
            'items',
            'problems.photos'
        ])->findOrFail($id);

        return view('dashboard.inspections.show', compact('inspection'));
    }

    public function destroy(string $id)
    {

        // Ambil Inspeksi
        $inspection = Inspection::findOrFail($id);

        Gate::authorize('delete', $inspection);

        // Hapus semua foto terkait dari storage
        foreach ($inspection->problems as $problem) {
            foreach ($problem->photos as $photo) {
                if (Storage::disk('public')->exists($photo->photo_url)) {
                    Storage::disk('public')->delete($photo->photo_url);
                }
            }
        }

        // Hapus Inspeksi
        $inspection->delete();

        return redirect()->route('dashboard.inspection.index')->with('success', 'Inspection successfully deleted.');
    }
}
