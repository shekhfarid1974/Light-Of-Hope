<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRM extends Model
{
    use HasFactory;

    protected $table = 'crms';

    protected $fillable = [
        'crm_type',
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
        'calling_status',
        'query_source',
        'query_status',
        'assigned_person',
        'agent',
        'remarks',
        'call_back',
        'data_source_id',
        'trainee_name',
        'trainee_age',
        'experience',
        'course_title',
        'query_complaint',
    ];

    // ---- Dropdown option constants ----
    public static array $interestedForOptions = [
        'Live Online Class',
        'Center Based Class',
    ];

    public static array $callingStatusOptions = [
        'Enrolled',
        'Trial Class',
        'Pending',
        'Cancel',
        'No Interaction',
        'No Communication',
    ];

    public static array $querySourceOptions = [
        'WhatsApp',
        'Messenger',
        'FB Comment',
        'Other',
    ];

    public static array $queryStatusOptions = [
        'Done',
        'Pending',
        'Cancel',
        'No Interaction',
    ];

    // ---- Relationships ----
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function dataSource()
    {
        return $this->belongsTo(DataSource::class);
    }
}
