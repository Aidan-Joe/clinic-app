<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {

        // Default password for all doctors: doctor123
        $password = password_hash('doctor123', PASSWORD_DEFAULT);

        $data = [
            ['DoctorCode'=>'DC001','Doctor_name'=>'Dr. Hendra Wijaya','Specialization'=>'Cardiology',       'Doctor_email'=>'hendra@email.com','Password'=>$password,'Phone'=>'081111111','Availability'=>'Available'],
            ['DoctorCode'=>'DC002','Doctor_name'=>'Dr. Sari Rahayu',  'Specialization'=>'General Practice', 'Doctor_email'=>'sari@email.com',  'Password'=>$password,'Phone'=>'082222222','Availability'=>'Available'],
            ['DoctorCode'=>'DC003','Doctor_name'=>'Dr. Wahyu Nugroho','Specialization'=>'Dermatology',      'Doctor_email'=>'wahyu@email.com', 'Password'=>$password,'Phone'=>'083333333','Availability'=>'Not Available'],
            ['DoctorCode'=>'DC004','Doctor_name'=>'Dr. Andi Permana', 'Specialization'=>'Neurology',        'Doctor_email'=>'andi@email.com',  'Password'=>$password,'Phone'=>'084444444','Availability'=>'Available'],
            ['DoctorCode'=>'DC005','Doctor_name'=>'Dr. Fitri Handayani','Specialization'=>'Pediatrics',     'Doctor_email'=>'fitri@email.com', 'Password'=>$password,'Phone'=>'085555555','Availability'=>'Available'],
        ];

        $this->db->table('doctor')->insertBatch($data);
    }
}
