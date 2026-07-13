<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachersCrm extends Model
{
    use HasFactory;

    protected $table = 'teachers_crms';

    protected $fillable = [
        'trainee_name',
        'phone',
        'email',
        'data_source_id',
        'district_id',
        'profession',
        'experience',
        'trainee_age',
        'course_title',
        'calling_status',
        'query_source',
        'query_status',
        'call_back',
        'assigned_person',
        'query_complaint',
        'agent',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function dataSource()
    {
        return $this->belongsTo(DataSource::class);
    }

    public function callBacks()
    {
        return $this->morphMany(CallBack::class, 'crm');
    }
}
