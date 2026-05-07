<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRM extends Model
{
    use HasFactory;

    protected $table = 'crms';

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
        'assigned_person',
        'remarks',
        'data_source_id',
    ];

    public function dataSource()
    {
        return $this->belongsTo(DataSource::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
