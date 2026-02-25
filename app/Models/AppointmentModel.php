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

    public function countTodayByDoctor($doctorCode)
    {
        return $this->where('DoctorCode', $doctorCode)
            ->where('Appointment_date', date('Y-m-d'))
            ->countAllResults();
    }

    public function countCompletedByDoctor($doctorCode)
    {
        return $this->where('DoctorCode', $doctorCode)
            ->where('Status', 'completed')
            ->countAllResults();
    }

    public function countTotalPatientsByDoctor($doctorCode)
    {
        return $this->select('Patientcode')
            ->where('DoctorCode', $doctorCode)
            ->distinct()
            ->countAllResults();
    }

    public function getTodayQueueByDoctor($doctorCode)
    {
        return $this->where('DoctorCode', $doctorCode)
            ->where('Appointment_date', date('Y-m-d'))
            ->orderBy('Appointment_time', 'ASC')
            ->findAll();
    }
    public function countUpcomingByPatient($patientCode)
    {
        return $this->where('Patientcode', $patientCode)
            ->where('Status', 'scheduled')
            ->countAllResults();
    }

    public function getAppointmentsByPatient($patientCode)
    {
        return $this->where('Patientcode', $patientCode)
            ->orderBy('Appointment_date', 'DESC')
            ->findAll();
    }
    public function countToday()
    {
        return $this->where('Appointment_date', date('Y-m-d'))
            ->countAllResults();
    }

    public function getTodayAppointments()
    {
        return $this->where('Appointment_date', date('Y-m-d'))
            ->findAll();
    }
    public function getTodayFullAppointments()
    {
        return $this->select('
            appointment.*,
            patient.Patient_name as patient_name,
            doctor.Doctor_name as doctor_name,
            doctor.Specialization as spec,
            room.Room_Code as room
        ')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->join('doctor', 'doctor.DoctorCode = appointment.DoctorCode')
            ->join('room', 'room.Room_Code = appointment.Room_Code', 'left')
            ->where('Appointment_date', date('Y-m-d'))
            ->findAll();
    }
    protected $useTimestamps = false;
}
