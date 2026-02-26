<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'Patientcode';

    protected $allowedFields = [
        'Patientcode',
        'Patient_name',
        'Patient_email',
        'Password',
        'Phone',
        'Birthdate',
        'Gender',
        'Address',
        'Photo',
    ];

    protected $useTimestamps = false;
}
