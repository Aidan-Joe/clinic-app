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
        'Prescription',
        'DoctorCode',
        'Patientcode'
    ];
    public function getRecentByDoctor($doctorCode)
    {
        return $this->where('DoctorCode', $doctorCode)
            ->orderBy('Visit_date', 'DESC')
            ->findAll(5);
    }
    public function countByPatient($patientCode)
    {
        return $this->where('Patientcode', $patientCode)
            ->countAllResults();
    }

    public function getByPatient($patientCode)
    {
        return $this->where('Patientcode', $patientCode)
            ->orderBy('Visit_date', 'DESC')
            ->findAll();
    }
    public function getWithRelation()
{
    return $this->select('
        medicalrecord.*,
        doctor.Doctor_name,
        patient.Patient_name
    ')
    ->join('doctor', 'doctor.DoctorCode = medicalrecord.DoctorCode', 'left')
    ->join('patient', 'patient.Patientcode = medicalrecord.Patientcode', 'left')
    ->findAll();
}
    protected $useTimestamps = false;
}
