<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'surname',
        'other_names',
        'date_of_birth',
        'marital_status',
        'phone_number',
        'address',
        'state_of_origin',
        'local_government',
        'ethnic_group',
        'religion',
        'name_of_father',
        'father_state_of_origin',
        'father_place_of_birth',
        'mother_state_of_origin',
        'mother_place_of_birth',
        'applicant_occupation',
        'desired_study_cent',
        'working_experience',
        'has_paid',
        'application_date',
        'application_trxid',
        'application_reference'
    ];

    public function studentDetail()
    {
        return $this->hasOne(StudentDetail::class, 'application_number', 'application_number');
    }
    public function educationalDetail()
    {
        return $this->hasOne(EducationalDetail::class, 'application_number', 'application_number');
    }
}
