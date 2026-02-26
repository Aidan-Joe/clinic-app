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
    public function getRecentByDoctor($doctorCode, $limit = 5)
    {
        return $this->select('
            medicalrecord.RecordCode,
            medicalrecord.Visit_date,
            medicalrecord.Diagnosis,
            medicalrecord.Treatment,
            medicalrecord.Prescription,
            medicalrecord.DoctorCode,
            medicalrecord.Patientcode,
            patient.Patient_name
        ')
            ->join('patient', 'patient.Patientcode = medicalrecord.Patientcode', 'left')
            ->where('medicalrecord.DoctorCode', $doctorCode)
            ->orderBy('Visit_date', 'DESC')
            ->findAll($limit);
    }
    public function countPendingByDoctor($doctorCode)
    {
        $db = \Config\Database::connect();
        return $db->table('appointment')
            ->where('DoctorCode', $doctorCode)
            ->where('Appointment_date', date('Y-m-d'))
            ->where('Status', 'scheduled')
            ->countAllResults();
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
            medicalrecord.RecordCode,
            medicalrecord.Visit_date,
            medicalrecord.Diagnosis,
            medicalrecord.Treatment,
            medicalrecord.Prescription,
            medicalrecord.DoctorCode,
            medicalrecord.Patientcode,
            doctor.Doctor_name,
            patient.Patient_name
        ')
            ->join('doctor', 'doctor.DoctorCode = medicalrecord.DoctorCode', 'left')
            ->join('patient', 'patient.Patientcode = medicalrecord.Patientcode', 'left')
            ->findAll();
    }
    public function nextCode(): string
    {
        $row = $this->db->query(
            "SELECT RecordCode FROM medicalrecord WHERE RecordCode LIKE 'RC%' ORDER BY CAST(SUBSTR(RecordCode, 3) AS UNSIGNED) DESC LIMIT 1"
        )->getRowArray();

        if ($row) {
            $num = (int) substr($row['RecordCode'], 2);
            return 'RC' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'RC001';
    }

    protected $useTimestamps = false;
}
