<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachersCrm extends Model
{
    use HasFactory;

    protected $table = 'teachers_crms';

    protected $fillable = [
        'customer_name',
        'phone',
        'whatsapp',
        'email',
        'gender',
        'area',
        'district_id',
        'age',
        'educational_qualification',
        'joining_as',
        'course',
        'current_designation',
        'years_of_experience',
        'teaching_group',
        'institution_name',
        'institution_address',
        'institution_type',
        'child_name',
        'child_gender',
        'dob',
        'other_type',
        'organization',
        'calling_agent',
        'calling_purpose',
        'calling_status',
        'data_source_id',
        'discussion_note',
        'next_follow_up_date',
        'call_back',
        'call_back_date',
        'call_back_time',
        'interested_course',
        'date_of_purchase',
        'branch',
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
