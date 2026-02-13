<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicalRecordModel extends Model
{
    protected $table = 'medicalrecord';
    protected $primaryKey = 'RecordCode';

    protected $allowedFields = [
        'RecordCode',
        'Visit_date',
        'Diagnosis',
        'Treatment',
        'Prescription'
    ];

    protected $useTimestamps = false;
}
