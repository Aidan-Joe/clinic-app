<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDateTimetoAppoinment extends Migration
{
    public function up() {
    $this->forge->addColumn('Appointment', [
        'Appointment_date' => ['type' => 'DATE', 'after' => 'Room_Code'],
        'Appointment_time' => ['type' => 'TIME', 'after' => 'Room_Code']
    ]);
}

public function down() {
    $this->forge->dropColumn('Appointment', 'Appointment_date');
    $this->forge->dropColumn('Appointment', 'Appointment_time');
}
}