<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionPhoto extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionPhotoFactory> */
    use HasFactory;

    protected $fillable = [
        'inspection_problem_id',
        'photo_url'
    ];

    public $timestamps = false;

    public function problem()
    {
        return $this->belongsTo(InspectionProblem::class, 'inspection_problem_id');
    }
}
