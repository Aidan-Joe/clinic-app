<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Default password: admin123
        $password = password_hash('admin123', PASSWORD_DEFAULT);

        $data = [
            ['AdminCode'=>'ADM01','DoctorCode'=>'DC001','Admin_name'=>'Admin Klinik','Admin_email'=>'admin@klinik.com','Password'=>$password],
        ];

        $this->db->table('admin')->insertBatch($data);
    }
}
