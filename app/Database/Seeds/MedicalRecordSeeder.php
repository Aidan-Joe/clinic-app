<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run()
{
    $data = [
        ['RecordCode'=>'RC001','Visit_date'=>'2026-02-12','Diagnosis'=>'Angina Pectoris','Treatment'=>'Rest','Prescription'=>'Nitroglycerin'],
        ['RecordCode'=>'RC002','Visit_date'=>'2026-02-10','Diagnosis'=>'Hypertension','Treatment'=>'Diet','Prescription'=>'Amlodipine'],
        ['RecordCode'=>'RC003','Visit_date'=>'2026-02-08','Diagnosis'=>'Atrial Fibrillation','Treatment'=>'Monitoring','Prescription'=>'Warfarin'],
    ];

    $this->db->table('medicalrecord')->insertBatch($data);
}

}
