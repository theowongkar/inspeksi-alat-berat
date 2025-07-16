<?php

namespace App\Exports;

use App\Models\Inspection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspectionExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Inspection::with([
            'equipmentType',
            'equipment',
            'inspector',
            'info',
            'items.equipmentTypeItem',
            'problems.photos'
        ])
            ->where('id', $this->id) // hanya 1 ID
            ->get()
            ->map(function ($inspection) {
                $totalScore = $inspection->items->sum('score');
                $count = $inspection->items->count();
                $avgScore = $count > 0 ? round($totalScore / $count, 2) : '-';
                $status = $count > 0 && $totalScore / $count >= 90 ? 'Operationally Feasible' : 'Not Operationally Feasible';

                $itemDetails = $inspection->items->map(function ($item) {
                    return "{$item->equipmentTypeItem->category}: {$item->score} - {$item->description}";
                })->implode(" | ");

                // Pisahkan problem notes dan photo list
                $problemNotes = $inspection->problems->pluck('notes')->implode(' | ');

                $photoUrls = $inspection->problems->flatMap(function ($problem) {
                    return $problem->photos->map(function ($photo) {
                        return asset('storage/' . $photo->photo_url);
                    });
                })->implode(', ');

                return [
                    'ID' => $inspection->id,
                    'Equipment Type' => $inspection->equipmentType->name ?? '-',
                    'Serial Number' => $inspection->equipment->serial_number ?? '-',
                    'Machine Type' => $inspection->equipment->machine_type ?? '-',
                    'Make' => $inspection->equipment->make ?? '-',
                    'Model' => $inspection->equipment->model ?? '-',
                    'Year' => $inspection->equipment->year ?? '-',
                    'Inspector' => $inspection->inspector->name ?? '-',
                    'Inspection Date' => $inspection->inspection_date,
                    'Location' => $inspection->location,
                    'Report No' => $inspection->info->report_no ?? '-',
                    'Hour Reading' => $inspection->info->hour_reading ?? '-',
                    'State ID' => $inspection->info->state_id ?? '-',
                    'Capacity' => $inspection->info->capacity ?? '-',
                    'Average Score' => $avgScore,
                    'Status' => $status,
                    'Inspection Items' => $itemDetails,
                    'Problems' => $problemNotes,
                    'Photos' => $photoUrls,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Equipment Type',
            'Serial Number',
            'Machine Type',
            'Make',
            'Model',
            'Year',
            'Inspector',
            'Inspection Date',
            'Location',
            'Report No',
            'Hour Reading',
            'State ID',
            'Capacity',
            'Average Score',
            'Status',
            'Inspection Items',
            'Problems',
            'Photos',
        ];
    }
}
