<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run()
{
    $data = [
        ['Appointmentcode'=>'AP001','Patientcode'=>'PT001','DoctorCode'=>'DC001','AdminCode'=>'ADM01','RecordCode'=>'RC001','Room_Code'=>'R-01','Appointment_time'=>'08:30:00','Appointment_date'=>'2026-02-12','Status'=>'completed','Symptoms'=>'Chest pain'],
        ['Appointmentcode'=>'AP004','Patientcode'=>'PT004','DoctorCode'=>'DC001','AdminCode'=>'ADM01','RecordCode'=>'RC003','Room_Code'=>'R-01','Appointment_time'=>'09:30:00','Appointment_date'=>'2026-02-13','Status'=>'scheduled','Symptoms'=>'Palpitations'],
        ['Appointmentcode'=>'AP007','Patientcode'=>'PT008','DoctorCode'=>'DC001','AdminCode'=>'ADM01','RecordCode'=>'RC002','Room_Code'=>'R-01','Appointment_time'=>'11:00:00','Appointment_date'=>'2026-02-13','Status'=>'scheduled','Symptoms'=>'Checkup'],
    ];

    $this->db->table('appointment')->insertBatch($data);
}

}
