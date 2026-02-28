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
            ->where('Appointment_date', date('Y-m-d'))
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
        return $this->select('
            appointment.Appointmentcode,
            appointment.Patientcode,
            appointment.Room_Code,
            appointment.Appointment_time,
            appointment.Symptoms,
            appointment.Status,
            patient.Patient_name,
            patient.Photo
        ')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode', 'left')
            ->join('room', 'room.Room_Code = appointment.Room_Code', 'left')
            ->where('appointment.DoctorCode', $doctorCode)
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
        return $this->select('
            appointment.Appointmentcode,
            appointment.DoctorCode,
            appointment.Appointment_date,
            appointment.Appointment_time,
            appointment.Symptoms,
            appointment.Status,
            doctor.Doctor_name,
            doctor.Specialization
        ')
            ->join('doctor', 'doctor.DoctorCode = appointment.DoctorCode', 'left')
            ->where('appointment.Patientcode', $patientCode)
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
        appointment.Appointmentcode,
        appointment.Appointment_date,
        appointment.Appointment_time  as time,
        appointment.Symptoms          as symptoms,
        appointment.Status            as status,
        appointment.Room_Code,
        patient.Patient_name          as patient_name,
        patient.Patientcode           as patient_code,
        doctor.Doctor_name            as doctor_name,
        doctor.Specialization         as spec,
        room.Room_Code                as room
    ')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->join('doctor', 'doctor.DoctorCode = appointment.DoctorCode')
            ->join('room', 'room.Room_Code = appointment.Room_Code', 'left')
            ->where('Appointment_date', date('Y-m-d'))
            ->orderBy('Appointment_date', 'DESC')
            ->orderBy('Appointment_time', 'ASC')
            ->findAll();
    }

    public function getAllFullAppointments()
    {
        return $this->select('
            appointment.Appointmentcode,
            appointment.Patientcode,
            appointment.DoctorCode,
            appointment.Room_Code,
            appointment.Appointment_date,
            appointment.Appointment_time,
            appointment.Symptoms,
            appointment.Status,
            patient.Patient_name          as patient_name,
            patient.Patientcode           as patient_code,
            doctor.Doctor_name            as doctor_name,
            doctor.Specialization         as spec,
            room.Room_Code                as room
        ')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->join('doctor', 'doctor.DoctorCode = appointment.DoctorCode')
            ->join('room', 'room.Room_Code = appointment.Room_Code', 'left')
            ->orderBy('CAST(SUBSTR(appointment.Appointmentcode,3) AS UNSIGNED) DESC', '', false)
            ->findAll();
    }

    public function nextCode(): string
    {
        $row = $this->db->query(
            "SELECT Appointmentcode FROM appointment WHERE Appointmentcode LIKE 'AP%' ORDER BY CAST(SUBSTR(Appointmentcode, 3) AS UNSIGNED) DESC LIMIT 1"
        )->getRowArray();

        if ($row) {
            $num = (int) substr($row['Appointmentcode'], 2);
            return 'AP' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'AP001';
    }
    protected $useTimestamps = false;
}
