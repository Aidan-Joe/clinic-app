<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTreatmentFromAppoinment extends Migration
{
    public function up() {
        $this->forge->dropColumn('appointment', 'Treatment');
    }

    public function down() {
        $this->forge->addColumn('appointment', [
            'Treatment' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'Symptoms' 
            ]
        ]);
    }
}
