<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentTypeItem extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentTypeItemFactory> */
    use HasFactory;

    protected $fillable = [
        'equipment_type_id',
        'category'
    ];

    public $timestamps = false;

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function inspectionItems()
    {
        return $this->hasMany(InspectionItem::class);
    }
}
