<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KidsCrm extends Model
{
    use HasFactory;

    protected $table = 'kids_crms';

    protected $fillable = [
        'father_name',
        'mother_name',
        'father_phone',
        'mother_phone',
        'whatsapp',
        'email',
        'profession',
        'district_id',
        'area',
        'interest_for',
        'child_name',
        'child_gender',
        'dob',
        'child_age',
        'class',
        'school_name',
        'calling_date',
        'calling_agent',
        'calling_purpose',
        'calling_status',
        'discussion_note',
        'next_follow_up_date',
        'call_back',
        'call_back_date',
        'call_back_time',
        'course_name',
        'date_of_purchase',
        'branch',
        'data_source_id',
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
