<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
{
    $data = [
        ['AdminCode'=>'ADM01','DoctorCode'=>'DC001','Admin_name'=>'Admin Klinik','Admin_email'=>'admin@klinik.com'],
    ];

    $this->db->table('admin')->insertBatch($data);
}

}
