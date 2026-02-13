<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordPatient extends Migration
{
    public function up() {
    $this->forge->addColumn('patient', [
        'Patient_email' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => FALSE,
            'after' => 'Patient_name'
        ],
        'Password' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => FALSE,
            'after' => 'Patient_email'
        ]
    ]);
}

public function down() {
    $this->forge->dropColumn('patient', 'Patient_email');
    $this->forge->dropColumn('patient', 'Password');
}

}
