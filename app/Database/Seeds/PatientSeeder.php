<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run()
{
    $data = [
        ['Patientcode'=>'PT001','Patient_name'=>'Rina Ayu Lestari','Patient_email'=>'rina@email.com','Phone'=>'081234567890','Birthdate'=>'1990-03-14','Gender'=>'Female','Address'=>'Jakarta'],
        ['Patientcode'=>'PT002','Patient_name'=>'Budi Santoso','Patient_email'=>'budi@email.com','Phone'=>'081234567891','Birthdate'=>'1992-05-22','Gender'=>'Male','Address'=>'Bandung'],
        ['Patientcode'=>'PT003','Patient_name'=>'Maya Putri','Patient_email'=>'maya@email.com','Phone'=>'081234567892','Birthdate'=>'1995-08-11','Gender'=>'Female','Address'=>'Surabaya'],
        ['Patientcode'=>'PT004','Patient_name'=>'Dian Novita Sari','Patient_email'=>'dian@email.com','Phone'=>'081234567893','Birthdate'=>'1990-03-14','Gender'=>'Female','Address'=>'Jakarta'],
        ['Patientcode'=>'PT005','Patient_name'=>'Agus Prasetyo','Patient_email'=>'agus@email.com','Phone'=>'081234567894','Birthdate'=>'1988-01-02','Gender'=>'Male','Address'=>'Bogor'],
        ['Patientcode'=>'PT008','Patient_name'=>'Bambang Sutrisno','Patient_email'=>'bambang@email.com','Phone'=>'081234567895','Birthdate'=>'1985-07-30','Gender'=>'Male','Address'=>'Depok'],
    ];

    $this->db->table('patient')->insertBatch($data);
}

}
