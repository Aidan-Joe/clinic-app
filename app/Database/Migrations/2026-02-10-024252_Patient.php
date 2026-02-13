<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Patient extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Patientcode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'Patient_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'Phone' => ['type' => 'VARCHAR', 'constraint' => 15],
            'Birthdate' => ['type' => 'DATE'],
            'Gender' => ['type' => 'ENUM', 'constraint' => ['Male', 'Female']],
            'Address' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);

        $this->forge->addKey('Patientcode', true);
        $this->forge->createTable('patient', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('patient');
    }
}

