<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function courseOutboundCrms()
    {
        return $this->hasMany(CourseOutboundCrm::class);
    }

    public function teachersTrainingCrms()
    {
        return $this->hasMany(TeachersTrainingCrm::class);
    }
}
