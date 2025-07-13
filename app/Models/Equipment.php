<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentFactory> */
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'equipment_type_id',
        'machine_type',
        'serial_number',
        'make',
        'model',
        'year'
    ];

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }
}
