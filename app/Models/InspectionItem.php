<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionItem extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionItemFactory> */
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'equipment_type_item_id',
        'score',
        'description'
    ];

    public $timestamps = false;

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function equipmentTypeItem()
    {
        return $this->belongsTo(EquipmentTypeItem::class);
    }
}
