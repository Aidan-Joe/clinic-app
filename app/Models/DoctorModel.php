<?php

namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'DoctorCode';

    protected $allowedFields = [
        'DoctorCode',
        'Doctor_name',
        'Specialization',
        'Doctor_email',
        'Password',
        'Phone',
        'Availability',
        'Photo',
    ];

    protected $useTimestamps = false;
}
