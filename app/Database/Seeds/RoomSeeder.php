<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run()
{
    $data = [
        ['Room_Code'=>'R-01','Room_Name'=>'Cardiology Ward A','Room_Type'=>'Examination Room','Status'=>'Occupied'],
        ['Room_Code'=>'R-02','Room_Name'=>'General Consultation B','Room_Type'=>'Consultation Room','Status'=>'Available'],
        ['Room_Code'=>'R-03','Room_Name'=>'Dermatology Suite','Room_Type'=>'Treatment Room','Status'=>'Available'],
        ['Room_Code'=>'R-04','Room_Name'=>'Neurology Lab','Room_Type'=>'Examination Room','Status'=>'Occupied'],
        ['Room_Code'=>'R-05','Room_Name'=>'Pediatrics Ward','Room_Type'=>'Ward','Status'=>'Available'],
        ['Room_Code'=>'R-06','Room_Name'=>'Emergency Suite','Room_Type'=>'ICU','Status'=>'Available'],
    ];

    $this->db->table('room')->insertBatch($data);
}

}
