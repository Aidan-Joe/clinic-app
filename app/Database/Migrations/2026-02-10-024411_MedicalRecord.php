<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MedicalRecord extends Migration
{
    public function up() {
    $this->forge->addField([
        'RecordCode' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
        'Visit_date'  => ['type' => 'DATE', 'null' => FALSE],
        'Diagnosis' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE],  
        'Treatment' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE],
        'Prescription' => ['type' => 'VARCHAR', 'constraint' => '1000', 'null' => FALSE],
    ]);
    $this->forge->addKey('RecordCode', true);
    $this->forge->createTable('MedicalRecord');
   }
    public function down() {
    $this->forge->dropTable('MedicalRecord');
    }
}
