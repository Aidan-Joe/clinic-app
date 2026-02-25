<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['RecordCode'=>'RC001','Visit_date'=>'2026-02-12','Diagnosis'=>'Angina Pectoris',    'Treatment'=>'Rest and medication',         'Prescription'=>'Nitroglycerin 0.5mg', 'DoctorCode'=>'DC001','Patientcode'=>'PT001'],
            ['RecordCode'=>'RC002','Visit_date'=>'2026-02-10','Diagnosis'=>'Hypertension',       'Treatment'=>'Low sodium diet',             'Prescription'=>'Amlodipine 5mg',      'DoctorCode'=>'DC001','Patientcode'=>'PT008'],
            ['RecordCode'=>'RC003','Visit_date'=>'2026-02-08','Diagnosis'=>'Atrial Fibrillation','Treatment'=>'Cardiac monitoring and rest', 'Prescription'=>'Warfarin 2mg',        'DoctorCode'=>'DC001','Patientcode'=>'PT004'],
        ];

        $this->db->table('medicalrecord')->insertBatch($data);
    }
}
