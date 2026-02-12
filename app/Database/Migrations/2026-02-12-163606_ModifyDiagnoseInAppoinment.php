<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyDiagnoseInAppointment extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('appointment', [
            'Diagnosis' => [
                'name' => 'Symptoms',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('appointment', [
            'Symptoms' => [
                'name' => 'Diagnosis',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
    }
}


