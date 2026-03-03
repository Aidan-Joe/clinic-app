<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDateTimetoAppoinment extends Migration
{
    public function up() {
    $this->forge->addColumn('appointment', [
        'Appointment_date' => ['type' => 'DATE', 'after' => 'Room_Code'],
        'Appointment_time' => ['type' => 'TIME', 'after' => 'Room_Code']
    ]);
}

public function down() {
    $this->forge->dropColumn('appointment', 'Appointment_date');
    $this->forge->dropColumn('appointment', 'Appointment_time');
}
}