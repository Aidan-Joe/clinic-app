<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $today    = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $data = [
            // Past completed appointment
            ['Appointmentcode'=>'AP001','Patientcode'=>'PT001','DoctorCode'=>'DC001','Room_Code'=>'R-01','Appointment_time'=>'08:30:00','Appointment_date'=>$yesterday,'Status'=>'completed','Symptoms'=>'Chest pain'],
            // Today's appointments (will show in dashboard queue)
            ['Appointmentcode'=>'AP002','Patientcode'=>'PT002','DoctorCode'=>'DC001','Room_Code'=>'R-01','Appointment_time'=>'09:00:00','Appointment_date'=>$today,    'Status'=>'scheduled','Symptoms'=>'Shortness of breath'],
            ['Appointmentcode'=>'AP003','Patientcode'=>'PT003','DoctorCode'=>'DC002','Room_Code'=>'R-02','Appointment_time'=>'10:00:00','Appointment_date'=>$today,    'Status'=>'scheduled','Symptoms'=>'General checkup'],
            ['Appointmentcode'=>'AP004','Patientcode'=>'PT004','DoctorCode'=>'DC001','Room_Code'=>'R-01','Appointment_time'=>'11:00:00','Appointment_date'=>$today,    'Status'=>'scheduled','Symptoms'=>'Palpitations'],
            ['Appointmentcode'=>'AP005','Patientcode'=>'PT005','DoctorCode'=>'DC003','Room_Code'=>'R-03','Appointment_time'=>'09:30:00','Appointment_date'=>$today,    'Status'=>'scheduled','Symptoms'=>'Skin rash'],
            // Tomorrow's appointments
            ['Appointmentcode'=>'AP006','Patientcode'=>'PT008','DoctorCode'=>'DC001','Room_Code'=>'R-01','Appointment_time'=>'08:00:00','Appointment_date'=>$tomorrow, 'Status'=>'scheduled','Symptoms'=>'Follow-up checkup'],
            ['Appointmentcode'=>'AP007','Patientcode'=>'PT001','DoctorCode'=>'DC002','Room_Code'=>'R-02','Appointment_time'=>'13:00:00','Appointment_date'=>$tomorrow, 'Status'=>'scheduled','Symptoms'=>'Headache'],
        ];

        $this->db->table('appointment')->insertBatch($data);
    }
}
