<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function kidsCrms()
    {
        return $this->hasMany(KidsCrm::class);
    }

    public function teachersCrms()
    {
        return $this->hasMany(TeachersCrm::class);
    }
}
