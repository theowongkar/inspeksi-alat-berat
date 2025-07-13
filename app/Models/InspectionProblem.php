<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionProblem extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionProblemFactory> */
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'notes'
    ];

    public $timestamps = false;

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function photos()
    {
        return $this->hasMany(InspectionPhoto::class);
    }
}
