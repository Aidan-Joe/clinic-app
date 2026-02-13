<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClinicSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        $this->call('DoctorSeeder');
        $this->call('PatientSeeder');
        $this->call('RoomSeeder');
        $this->call('AdminSeeder');
        $this->call('MedicalRecordSeeder');
        $this->call('AppointmentSeeder');

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }
}

