<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDoctorAndPatientToMedicalRecord extends Migration
{
    public function up()
    {
        $fields = [
            'DoctorCode' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
                'after' => 'RecordCode',
            ],
            'Patientcode' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
                'after' => 'DoctorCode',
            ],
        ];

        $this->forge->addColumn('medicalrecord', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('medicalrecord', ['DoctorCode', 'Patientcode']);
    }
}
