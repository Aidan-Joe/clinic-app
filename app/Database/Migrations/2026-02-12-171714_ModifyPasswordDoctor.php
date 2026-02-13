<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPasswordDoctor extends Migration
{
    public function up() {
    $this->forge->addColumn('doctor', [
        'Password' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => FALSE,
            'after' => 'Doctor_email'
        ]
    ]);
}

public function down() {
    $this->forge->dropColumn('doctor', 'Password');
}

}
