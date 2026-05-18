<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOutboundCrm extends Model
{
    use HasFactory;

    protected $table = 'course_outbound_crms';

    protected $fillable = [
        'parents_name',
        'phone',
        'email',
        'profession',
        'district_id',
        'child_gender',
        'child_age',
        'child_name',
        'class',
        'interested_for',
        'data_source_id',
        'calling_status',
        'query_source',
        'query_status',
        'call_back',
        'assigned_person',
        'remarks',
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
