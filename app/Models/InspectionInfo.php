<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionInfo extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'report_no',
        'hour_reading',
        'state_id',
        'capacity'
    ];

    public $timestamps = false;

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
