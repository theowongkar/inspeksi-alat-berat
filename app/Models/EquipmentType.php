<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function items()
    {
        return $this->hasMany(EquipmentTypeItem::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }
}
