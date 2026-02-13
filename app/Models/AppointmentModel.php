<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'Appointmentcode';

    protected $allowedFields = [
        'Appointmentcode',
        'Patientcode',
        'DoctorCode',
        'AdminCode',
        'RecordCode',
        'Room_Code',
        'Appointment_date',
        'Appointment_time',
        'Status',
        'Symptoms'
    ];
    

    protected $useTimestamps = false;
}
