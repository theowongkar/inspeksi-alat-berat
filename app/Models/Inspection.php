<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionFactory> */
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'inspector_id',
        'equipment_type_id',
        'inspection_date',
        'location'
    ];

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function info()
    {
        return $this->hasOne(InspectionInfo::class);
    }

    public function items()
    {
        return $this->hasMany(InspectionItem::class);
    }

    public function problems()
    {
        return $this->hasMany(InspectionProblem::class);
    }
}
