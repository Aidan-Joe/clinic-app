<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToAppointment extends Migration
{
    public function up() {
    $this->forge->addColumn('Appointment', [
        'Status' => ['type' => 'ENUM', 'constraint' => ['scheduled', 'completed', 'cancelled'], 'default' => 'scheduled', 'after' => 'Room_Code']
    ]);
}

public function down() {
    $this->forge->dropColumn('Appointment', 'Status');
}
}
